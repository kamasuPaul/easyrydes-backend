<?php

namespace Kamasupaul\Laradocs;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DocsController extends Controller
{
    public function add($a, $b){
    	echo $a + $b;
    }

    public function subtract($a, $b){
    	echo $a - $b;
    }
}
