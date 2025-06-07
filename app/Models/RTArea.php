<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RTArea extends Model
{
    protected $table = 'rt_areas';

    public function users()
    {
        return $this->hasManyThrough(User::class, UserDetail::class, 'rt_area_id', 'id');
    }
}
