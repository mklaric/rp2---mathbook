<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
	protected $fillable = ['page_result_id', 'link',  'filename', 'mime','original_filename'];

    public function pageResult()
    {
    	return $this->belongsTo('App\PageResult')->first();
    }


}


