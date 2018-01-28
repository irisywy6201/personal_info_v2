<?php

namespace App\Entities;

use \App;
use Illuminate\Database\Eloquent\Model;

class lostandfound extends BaseEntity
{
    protected $table = 'lostandfound';
    protected $primaryKey = 'id';
    protected $fillable = array('found_at','type_id','status', 'description','location','reco_acct', 'reco_email', 'reco_phone','updated_at','claimed_at','ForwardStatus');

    

}

?>
