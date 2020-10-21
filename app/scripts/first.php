<?php

require_once '../vendor/autoload.php';

use Lib\Datastore;

$client = new GuzzleHttp\Client(['base_uri' => 'http://www.base.gov.pt/base2/rest/contratos/']);

$initId = DataStore::getLastId(); //6944250
$options = array(
    'headers' => [
        'User-Agent' => 'basecovid19.pt/1.0',
    ]
);

for ($i = $initId; $i <= $initId + 10000000; $i++) {
    var_dump($i);
    $response = $client->request('GET', (string)$i, $options);
    $body = $response->getBody();
    $content = $body->getContents();

    if (preg_match('/covid|corona|SARS-COV-2|nCoV-2019|SARS|epidemia|pandemia|COV2|EPI|FFP2|ventilador|zaragatoa/i', $content)) {
        $contrato = json_decode($content);
        print_r($contrato);
        $price = $contrato->initialContractualPrice;
        $price = str_replace('€', '', $price);
        $price = str_replace('.', '', $price);
        $price = str_replace(' ', '', $price);
        $price = floatval($price);
        $contrato->signingDateParsed = new \MongoDB\BSON\UTCDateTime(strtotime(str_replace("/", "-", $contrato->signingDate)) * 1000);
        $contrato->price = $price;
        DataStore::updateOrSaveById($contrato->id, $contrato);
    }

    DataStore::savelastId($i + 1);

    usleep(80000);
}
