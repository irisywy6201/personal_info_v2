<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class CDs_2 extends BaseEntity
{
	use SoftDeletes;

        protected $table='CDs_2';

        protected $fillable=['left_number','download_id','download_version_id','type'];
	protected $dates=['deleted_at'];

}

