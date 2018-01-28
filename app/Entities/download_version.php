<?php

namespace App\Entities;

class download_version extends BaseEntity
{
        protected $table='download_version';

        protected $fillable=['version_id','name_en','version_connection'];
}



