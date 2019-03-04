<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class software_category  extends BaseEntity
{
       

        protected $table='software_category';

        protected $fillable=['name_en','name_zh_tw','category_id'];
       
	public $timestamps = false;
}

