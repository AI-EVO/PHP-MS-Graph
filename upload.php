<?php
require __DIR__ . '/vendor/autoload.php';

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
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

$graph->createRequest("PUT", "/me/drive/root/children/".$_FILES["fileToUpload"]["name"]."/content")
	  ->upload($_FILES["fileToUpload"]["tmp_name"]);

// Save to uploads folder on server
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";

?>