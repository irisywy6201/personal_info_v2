<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class software  extends BaseEntity
{
        use SoftDeletes;

        protected $table='software';

        protected $fillable=['software_info_id','platform_id','cd_count','download_link','year'];
        protected $dates=['deleted_at'];

}

