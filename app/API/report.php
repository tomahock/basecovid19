<?php
require_once '../vendor/autoload.php';

if (empty($_POST['id'])) {
    $response = array(
        'error' => 'id not set'
    );

    header("Location: /contrato?id={$_POST['id']}&reported=false");
    die();
}


if (empty($_POST['h-captcha-response'])) {
    $response = array(
        'error' => 'h-captcha-response not set'
    );

    header("Location: /contrato?id={$_POST['id']}&reported=false");
    die();
}

$token = $_POST['h-captcha-response'];

$data = array(
    'secret' => $_ENV['hcaptcha_secret_key'],
    'response' => $token
);

$options = array(
    'form_params' => $data
);

$client = new GuzzleHttp\Client(['base_uri' => 'https://hcaptcha.com/']);
$response = $client->request('POST', 'siteverify', $options);
$body = $response->getBody();
$content = json_decode($body->getContents());

if($content->success){
    \Lib\DataStore::addReported($_POST['id']);
    $sucess = true;
} else {
    $sucess = false;
}

header("Location: /contrato?id={$_POST['id']}&reported={$sucess}");
die();