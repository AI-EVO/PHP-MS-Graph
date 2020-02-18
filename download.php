<?php
require __DIR__ . '/vendor/autoload.php';

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

$target_dir = "downloads/";

$guzzle = new \GuzzleHttp\Client();
$tenantId = 'your_tenanet_id, e4c9ab4e-****-****-****-230ba2a757fb';
$clientId = 'your_app_id_registered_in_portal, dc175b96-****-****-****-ea03e56da5e7';
$clientSecret = 'app_key_generated_in_portal, /pGggH************************Zr732';
$url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/token';
$user_token = json_decode($guzzle->post($url, [
    'form_params' => [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'resource' => 'https://graph.microsoft.com/',
        'grant_type' => 'password',
        'username' => 'your_user_id, jack@***.onmcirosoft.com', 
        'password' => 'your_password'
    ],
])->getBody()->getContents());
$user_accessToken = $user_token->access_token;

$graph = new Graph();
$graph->setAccessToken($user_accessToken);

$target_dir = 'downloads/';
$graph->createRequest("GET", "/me/drive/root:/Capture.JPG:/content")
    ->download($target_dir.'Capture.JPG');

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($target_dir.'Capture.JPG').'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($target_dir.'Capture.JPG'));
flush(); 
readfile($target_dir.'Capture.JPG');
die();

?>