<?php
require_once __DIR__ . '../../vendor/autoload.php';

use Lib\EntidadeStore;

$client = new GuzzleHttp\Client(['base_uri' => 'http://www.base.gov.pt/base2/rest/entidades/']);

$initId = EntidadeStore::getLastId(); //6944250
$options = array(
    'headers' => [
        'User-Agent' => 'basecovid19.pt/1.0',
    ],
    'proxy' => 'socks5://x8458594:KTnxw6cddH@proxy-nl.privateinternetaccess.com:1080'
);

for ($i = $initId; $i <= $initId + 100000; $i++) {
    var_dump($i);
    $response = $client->request('GET', (string)$i, $options);
    $body = $response->getBody();
    $content = $body->getContents();
    $entidade = json_decode($content);

    if(!is_null($entidade->id)){
        EntidadeStore::updateOrSaveById($entidade->id, $entidade);
        EntidadeStore::savelastId($i + 1);
    }

    usleep(75000);
}
