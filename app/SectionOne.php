<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionOne extends Model
{
    protected $table = 'SectionOne';
    protected $fillable=['id','title','content','created_at','updated_at'];
}
