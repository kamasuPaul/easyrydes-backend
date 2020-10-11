<?php

use Kamasupaul\Laradocs\DocsController;

Route::get('calculator', function(){
	echo 'Hello from the calculator package!';
});
Route::get('add/{a}/{b}', [DocsController::class,'add']);
Route::get('subtract/{a}/{b}',[DocsController::class,'subtract']);