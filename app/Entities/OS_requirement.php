<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class OS_requirement  extends BaseEntity
{
        use SoftDeletes;

        protected $table='OS_requirement';

        protected $fillable=['software_info_id','description_en','description_zh_tw'];
        protected $dates=['deleted_at'];

}

