<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projects extends Model {

    public function builder() {
        return $this->hasOne(Builders::class, 'id', 'builder_id');
    }
}
