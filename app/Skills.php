<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skills extends Model
{
    protected $fillable=['projects_id','name'];
    public function Project(){
        return $this->belongsTo('App\Projects');
    }
}
