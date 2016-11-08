<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fileentry extends Model
{
	protected $fillable = ['task_id', 'user_id', 'mime', 'filename', 'original_filename'];

    public function task()
    {
    	return $this->belongsTo('App\Task')->first();
    }

    public function user()
    {
    	return $this->belongsTo('App\User')->first();
    }
}
