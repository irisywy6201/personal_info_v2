<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionThree extends Model
{
  protected $table = 'SectionThree';
  protected $fillable=['id','title','content','created_at','updated_at'];
}
