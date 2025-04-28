<?php

namespace App\Http\Controllers;

use App\Models\Builders;
use App\Models\DealApplication;
use App\Models\Deals;
use App\Models\Flats;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class ProjectsController extends Controller {

    public function list(Request $r) {
        $projects = Projects::where('builder_id', 1)->get();

        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    public function store(Request $r) {
//        $validate = Validator::make($r->all(), [
//            'name' => ['required'],
//            'location' => ['required'],
//            'region' => ['required'],
//            'description' => ['required'],
//            'start_date' => ['required'],
//            'expected_finish_date' => ['required'],
//            'images' => ['required']
//        ]);

//        if($validate->fails()) {
//            return response()->json([
//                'success' => false,
//                'data' =>[
//                    'message' => 'Validation error'
//                ]
//            ]);
//        }

        $project = new Projects();
        $project->builder_id = 1;
        $project->name = $r->name;
        $project->region = 1;
        $project->location = Str::random(10);
        $project->description = Str::random(200);
        $project->start_date = date("Y-m-d");
        $project->expected_finish_date = "2026-03-15";
        $project->images = json_encode([]);
        $project->save();

        $flats = [];
        for($i = 0; $i < 10; $i++) {
            $flats[] = [
                'project_id' => $project->id,
                'apartment_number' => $i + 1,
                'area' => mt_rand(50, 120),
                'floor' => mt_rand(1, 9),
                'rooms' => mt_rand(2, 6),
                'price' => 35000,
                'status' => 1,
                'balcony' => 0,
                'parking' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];
        }

        DB::table('flats')->insert($flats);

        return response()->json([
            'success' => true,
            'data' => [
                'message' => 'Object was saved'
            ]
        ]);
    }

    public function deals() {
        $deal_applications = DealApplication::where([
            'builder_id' => 1,
            'status' => 1
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $deal_applications
        ]);
    }

    public function confirm(Request $r) {

        $validate = Validator::make($r->all(), [
            'deal' => ['required'],
            'action' => ['required']
        ]);

        if($validate->fails()) {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => "Validation error"
                ]
            ]);
        }

        $deal_applications = DealApplication::where([
            'id' => $r->deal
        ])->first();

        if(is_null($deal_applications)) {
            return response()->json([
                'success' => false,
                'data' => [
                    'message' => "Deal not found"
                ]
            ]);
        }

        $deal_applications->update([
            'status' => $r->action == "accept" ? 2 : 3,
        ]);

        $executableFinder = new ExecutableFinder();
        $node = $executableFinder->find('node');
        $process = new Process([$node, public_path('wallet.js')]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();

        $wallet = json_decode($output);

        $builderInfo = Builders::find(1);

        $createDeal = new Deals();
        $createDeal->customer_wallet = $deal_applications->customer_wallet;
        $createDeal->dao_wallet = $wallet->wallet;
        $createDeal->builder_wallet = $builderInfo->wallet_address;
        $createDeal->amount = 1;
        $createDeal->mnemonic = $wallet->mnemonic;
        $createDeal->public_key = $wallet->publicKey;
        $createDeal->private_key = $wallet->privateKey;
        $createDeal->flat_id = 1;
        $createDeal->project_id = 1;
        $createDeal->save();

        return response()->json([
            'success' => true,
            'data' => []
        ]);
    }

    public function close() {

    }
}
