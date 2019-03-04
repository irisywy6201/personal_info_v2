<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class software_cd_collection_record extends BaseEntity
{
        use SoftDeletes;

        protected $table='software_cd_collection_record';
        protected $fillable=['users_id','software_version_id'];
        protected $dates=['deleted_at'];

}

