<?php

namespace App\Entities;

class download extends BaseEntity
{
        protected $table='download';

        protected $fillable=['name','describe_zh','describe_en','year'];
}


