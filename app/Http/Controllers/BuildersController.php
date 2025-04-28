<?php

namespace App\Http\Controllers;

use App\Models\Builders;
use Illuminate\Http\Request;

class BuildersController extends Controller {

    public function init() {

        $builder = new Builders();
        $builder->id = 1;
        $builder->name = "FDG MCHJ";
        $builder->contact_email = "contact@fdg.uz";
        $builder->contact_phone = "+998915883940";
        $builder->address = "Parkent Plaza, жилой комплекс, 7-й Паркентский пр., 1/1, Ташкент";
        $builder->registration_number = "244541248940";
        $builder->wallet_address = "UQDXmbmIXVQQ85YpGX0PUq_J0zQNoZdZ_AK6DyP-6omUNoqw";
        $builder->save();

        dd('he');
    }
}
