<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class platform  extends BaseEntity
{
        use SoftDeletes;

        protected $table='platform';

        protected $fillable=['name_en','name_zh_tw'];
        protected $dates=['deleted_at'];

}

