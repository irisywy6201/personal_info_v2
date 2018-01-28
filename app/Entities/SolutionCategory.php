<?php

namespace App\Entities;

class SolutionCategory extends BaseEntity{
    /**
     * The database table used by the model
     */
    protected $table = 'solution';
    protected $primaryKey = 'id';
    protected $fillable = ['method','visible'];

    public function scopeGetFromId($query,$id){
      return $query->where('id', '=', $id );
    }

    public function scopeGetVisibility($query,$visible) {
      return $query->where('visible', '=' ,$visible);
    }
}

?>
