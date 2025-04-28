<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\DealApplication;
use App\Models\Deals;
use App\Models\Projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller {

    public function list() {
        $projects = Projects::with('builder')->get();

        return response()->json([
            'success' => true,
            'data' => $projects
        ]);
    }

    public function submit(Request $r) {

        $dealApplication = new DealApplication();
        $dealApplication->customer_wallet = $r->wallet;
        $dealApplication->builder_id = 1;
        $dealApplication->flat_id = 1;
        $dealApplication->project_id = 1;
        $dealApplication->save();

        return response()->json([
            'success' => true,
            'data' => [
                'message' => 'Please wait until developer confirm the deal'
            ]
        ]);
    }

    public function loadProjectsToPay() {
        $deal = Deals::where([
            'status' => 1
        ])->first();

        if(is_null($deal)) {
            return response()->json([
                'success' => false,
                'data' => []
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'dao_wallet' => $deal->dao_wallet,
                'amount' => $deal->amount
            ]
        ]);
    }

    public function confirmClose() {

    }
}
