<?php

namespace App\Entities;

use \App;

use Illuminate\Database\Eloquent\Model;

class lostType extends BaseEntity
{
    //
    protected $table = 'lostthing_type';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];


}
