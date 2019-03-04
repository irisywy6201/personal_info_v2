<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SectionTwo extends Model
{
  protected $table = 'SectionTwo';
  protected $fillable=['id','title','content','created_at','updated_at'];
}
