<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserve extends Model
{
    use SoftDeletes;
    protected $table = 'reserves';
    public $timestamps = true;
    public $fillable = ['user', 'field', 'time_to', 'time_from', 'date'];
    protected $dates = ['deleted_at'];
}
