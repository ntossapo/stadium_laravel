<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    protected $table = 'fields';
    public $timestamps = true;
    public $fillable = ['name', 'stadium_id', 'type'];
    protected $dates = ['deleted_at'];

    public function stadium(){
        return $this->belongsTo("App\Stadium");
    }
}
