<?php

namespace App\Entities;

class download_need extends BaseEntity
{
        protected $table='download_need';

        protected $fillable=['need_id','need_zh','need_en'];
}

