<?php
  namespace App\Entities;

  class SdRecCategory extends BaseEntity{
      /**
       * The database table used by the model
       */
      protected $table = 'sdRecCategory';
      protected $primaryKey = 'id';
      protected $fillable = ['name','parent_id','visible'];

      public function scopeGetSubCategory($query,$parent_id){
        return $query->where('parent_id', '=', $parent_id );
      }

      public function scopeGetFromId($query,$id){
        return $query->where('id', '=', $id );
      }

      public function scopeGetVisibility($query,$visible) {
        return $query->where('visible', '=' ,$visible);
      }


  }

?>
