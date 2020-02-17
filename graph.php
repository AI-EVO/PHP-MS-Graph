<?php
require __DIR__ . '/vendor/autoload.php';
$guzzle = new \GuzzleHttp\Client();
$tenantId = 'your_tenanet_id, e4c9ab4e-****-****-****-230ba2a757fb';
$clientId = 'your_app_id_registered_in_portal, dc175b96-****-****-****-ea03e56da5e7';
$clientSecret = 'app_key_generated_in_portal, /pGggH************************Zr732';
$url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/token';

// Get token with application permission
$token = json_decode($guzzle->post($url, [
    'form_params' => [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'resource' => 'https://graph.microsoft.com/',
        'grant_type' => 'client_credentials',
    ],
])->getBody()->getContents());
$accessToken = $token->access_token;
print_r($accessToken);

// Get token with delegated permission
// If you call Graph with /me path, you should use this token
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
print_r($user_accessToken);

?>