<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Join extends Model
{
    protected $table = 'joins';
    public $timestamps = true;
    public $fillable = ['facebook_id', 'reserve_id'];
    protected $dates = ['deleted_at'];

}
