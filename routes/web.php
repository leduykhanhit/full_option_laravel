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

Route::get('/', function (\Illuminate\Http\Request $request) {

//    dd($request);
    //\Illuminate\Support\Facades\Cache::set('KHANHLD',123123213);
    \App\Jobs\HandlerSms::dispatch()->onQueue('LISTEN_SMS');


    return view('welcome');
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
    //dd($request->search);
    $result = StoreModel::search($request->search)
        ->raw();
    dd($result);
//var_dump($result);
    foreach ($result['hits'] as $_value){
        echo "Nhà thuốc: ".$_value['name']." | ";
        echo "Địa chỉ: ".$_value['address']."<br>";
    }
    //\App\Models\StoreModel::where('code','')->searchable();
});

