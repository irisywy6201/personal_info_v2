<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class software_version  extends BaseEntity
{
	use SoftDeletes;
        protected $table='software_version';
        protected $fillable=['platform_id','software_list_id','surplus','download_link','document_link'];
	protected $dates=['deleted_at'];
	public $timestamps = false;
}

