<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Excel;

class ExcelController extends Controller
{
    public function postImport()
    {
    	Excel::load(Input::file('result'), function($reader){
    		$results = $reader->get();
    	});
    }
}
