<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    //
    protected $table='todo';
    protected $fillable=[
        'title',
        'state',
        'body',
    ];
    public function users(){
        return $this->belongsTo('App\User');
    }
    public function getAllTodo(){
        return $this->where('user_id',1)->orderBy('created_at','desc')->paginate(5);
    }
}
