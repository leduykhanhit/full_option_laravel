<?php

use App\Models\StoreModel;
use Google\Service\Drive;
use http\Client\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/form', function () {

return view('google_form');

});

Route::get('/', function () {

 echo 1;
    sleep(3);

    echo 2;
    sleep(5);
    return view('welcome');

});

Route::get('/queue', function (\Illuminate\Http\Request $request) {
    \App\Jobs\HandlerSms::dispatch()->onQueue('LISTEN_SMS');
   echo "push to queue";
   die();
});

Route::get('/mysql', function (\Illuminate\Http\Request $request) {
    $provinces = \App\Models\Province::all();
    echo 'mysql';
    dd($provinces);

});

Route::get('/mongo', function (\Illuminate\Http\Request $request) {
    echo 'mongo';
    $provinces = \App\Models\MongoDB\Province::all();
    dd($provinces);
});

Route::get('/redis', function (\Illuminate\Http\Request $request) {
    echo 'redis';
    $provinces = \App\Models\MongoDB\Province::all();
    $cacheData = \Illuminate\Support\Facades\Cache::get('data');
     \Illuminate\Support\Facades\Cache::set('data',$provinces);
    dd($cacheData);
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

Route::get('/exception', function () {
    try {
        echo number_format(2/3333,2);
        \App\Models\User::all()->forget();
    }catch (Exception $exception){

    }
});

Route::get('/oauth2callback', function (\Illuminate\Http\Request $request) {

    $client = new Google_Client();
    $client->setApplicationName('Google OAuth Login');
    $client->setAuthConfig(storage_path('../auth.json'));
    $client->setRedirectUri('http://localhost/oauth2callback');

    // Nhận mã xác thực từ query string
    $code = $request->input('code');

    // Trao đổi mã xác thực lấy access token
    $token = $client->fetchAccessTokenWithAuthCode($code);

    // Lưu token vào session hoặc database
    session(['access_token' => $token]);

    dd($token);
    return 'Access token saved!';
});

Route::get('/info', function (\Illuminate\Http\Request $request) {

        $client = new Google_Client();
        $client->setApplicationName('Google Drive API');
        $client->setScopes([Drive::DRIVE_READONLY]);
        $client->setAuthConfig(storage_path('../auth.json'));

        // Lấy access token từ session
        $accessToken = session('access_token');

        //dd($accessToken);
        $client->setAccessToken($accessToken);

        // Làm mới access token nếu đã hết hạn
        if ($client->isAccessTokenExpired()) {
            $refreshToken = $client->getRefreshToken();
            $client->fetchAccessTokenWithRefreshToken($refreshToken);
            session(['access_token' => $client->getAccessToken()]);
        }

        $service = new Drive($client);
        $fileId = '1AskQ9pww2BfcJoNHoFgmDulQSaQzYiK4';  // ID của file bạn muốn tải

        try {
            $file = $service->files->get($fileId, array('alt' => 'media'));
            $content = $file->getBody()->getContents();  // Nội dung file

            // Lưu hình ảnh vào storage
            Storage::put("$fileId.jpg", $content);

            return 'File downloaded successfully!';
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }

});
