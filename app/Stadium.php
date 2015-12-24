<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stadium extends Model
{
    use SoftDeletes;
    protected $table = 'stadiums';
    public $timestamps = true;
    public $fillable = ['name', 'rating', 'nowPlayer', 'describe', 'latitude','longitude'];
    protected $dates = ['deleted_at'];

    public function field(){
        return $this->hasMany('App\Field');
    }
}
