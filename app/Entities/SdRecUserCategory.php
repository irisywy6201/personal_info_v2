<?php
  namespace App\Entities;

  class SdRecUserCategory extends BaseEntity{
      /**
       * The database table used by the model
       */
      protected $table = 'sdRecUserCategory';
      protected $primaryKey = 'id';
      protected $fillable = ['user','visible'];

      public function scopeGetFromId($query,$id){
        return $query->where('id', '=', $id );
      }
      
      public function scopeGetVisibility($query,$visible) {
        return $query->where('visible', '=' ,$visible);
      }
  }

?>
