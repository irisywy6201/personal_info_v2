<?php

namespace App\Entities;

class CDs extends BaseEntity
{
	protected $table='CDs';

	protected $fillable=['softName','theLeft','type','bits'];
}




