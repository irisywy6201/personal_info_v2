<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class software_list  extends BaseEntity
{
       // use SoftDeletes;

        protected $table='software_list';

        protected $fillable=['software_category_id','officeDoc_id','name_zh','name_en','summary_zh','summary_en',
				'kms_link','year','isdelete'];
        public $timestamps = false;

}



