<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Google_Client;
use Google\Service\Drive;
use Google_Service_Sheets;
use Illuminate\Support\Facades\Storage;
use Revolution\Google\Sheets\Facades\Sheets;

class GoogleSheetApiCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:google-sheet-api-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $client;
    protected $service;
    /**
     * Execute the console command.
     */
    public function handle()
    {

        dd($this->getGoogleDriveFile2());
        dd($this->getGoogleAuthUrl());
        //dd($this->getGoogleDriveFile());
        $client = new \Google_Client();

//        $client->setClientId('1011252094763-v5clivibsmha80a7c5bupt2osgpcvtgv.apps.googleusercontent.com');
//        $client->setClientSecret('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');
//        $client->setRedirectUri('http://test.com');
        $client->addScope(\Google_Service_Sheets::SPREADSHEETS);

        $client->setAuthConfig(storage_path('../auth.json'));

        //$client->setDeveloperKey('AIzaSyDDtRO5189vW4E0xa8xa7xRHwlaZuZggs0'); // Thay YOUR_API_KEY bằng API Key của bạn

        $this->service = new Google_Service_Sheets($client);

        $spreadsheetId = '1T_DWMqPFzyBIYHIQoV76e5LhpQlkLCK5CdwT5zlPoOE';

        $response = $this->service->spreadsheets->get($spreadsheetId);
        $sheets = $response->getSheets();
        foreach ($sheets as $sheet) {
            $title = $sheet->getProperties()->getTitle();
            echo $title . "\n";  // In ra tên của các trang tính
        }

        $range = 'Câu trả lời biểu mẫu 1';  // Đảm bảo tên trang tính và phạm vi đúng

        $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);

        $data = $response->getValues();

        dd($data);

        die();
    }

    public function getSheetData($spreadsheetId, $range)
    {
        $response = $this->service->spreadsheets_values->get($spreadsheetId, $range);
        return $response->getValues();
    }


    function getGoogleAuthUrl() {
        $client = new Google_Client();
        $client->setApplicationName('Google OAuth Login');
        $client->setScopes([Drive::DRIVE_READONLY]);
        $client->setAuthConfig(storage_path('../auth.json'));
        $client->setRedirectUri('http://localhost/oauth2callback');  // Redirect URL của bạn
        $client->setAccessType('offline');  // Để lấy refresh token
        $client->setPrompt('consent');

        // Tạo URL để chuyển hướng người dùng đến trang đăng nhập của Google
        $authUrl = $client->createAuthUrl();
        return $authUrl;
    }

    function getGoogleDriveFile() {
        $client = new Google_Client();
        $client->setApplicationName('Google Drive API');
        $client->setScopes([Drive::DRIVE_READONLY]);

        // Nếu bạn sử dụng API Key
        $client->setDeveloperKey('AIzaSyDDtRO5189vW4E0xa8xa7xRHwlaZuZggs0');  // Thay YOUR_API_KEY bằng API Key của bạn

        // Nếu sử dụng OAuth hoặc Service Account:
        // $client->setAuthConfig(storage_path('app/credentials.json'));

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
    }



    function getGoogleDriveFile2() {
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
            Storage::put('google-drive-image.jpg', $content);

            return 'File downloaded successfully!';
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

}
