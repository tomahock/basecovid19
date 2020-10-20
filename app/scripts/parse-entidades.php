<?php

require_once '../vendor/autoload.php';

use Lib\EntidadeStore;

$client = new GuzzleHttp\Client(['base_uri' => 'http://www.base.gov.pt/base2/rest/entidades/']);

$initId = EntidadeStore::getLastId(); //6944250
$options = array(
    'headers' => [
        'User-Agent' => 'basecovid19.pt/1.0',
    ]
);

for ($i = $initId; $i <= $initId + 100000; $i++) {
    var_dump($i);
    $response = $client->request('GET', (string)$i, $options);
    $body = $response->getBody();
    $content = $body->getContents();
    $entidade = json_decode($content);

    EntidadeStore::updateOrSaveById($entidade->id, $entidade);
    EntidadeStore::savelastId($i + 1);

    usleep(75000);
}
