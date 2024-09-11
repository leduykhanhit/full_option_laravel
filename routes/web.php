<?php

use App\Models\StoreModel;
use http\Client\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/queue', function (\Illuminate\Http\Request $request) {
    \App\Jobs\HandlerSms::dispatch()->onQueue('LISTEN_SMS');
   echo "push to queue";
   die();
});

Route::get('/exception', function () {
    try {
            echo number_format(2/3333,2);
            \App\Models\User::all()->forget();
    }catch (Exception $exception){

    }
});

Route::get('/slow', function () {
   sleep(15);
   echo "hello";
});


Route::get('/search', function (\Illuminate\Http\Request $request) {

    $result = \App\Models\Melisearch\Province::search($request->search)
        ->paginate(10);

    foreach ($result->items() as $_value){

        echo $_value->name."<br>";
    }

    dd($result);
    //\App\Models\StoreModel::where('code','')->searchable();
});

