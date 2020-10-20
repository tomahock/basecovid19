<?php

require_once '../vendor/autoload.php';

use MongoDB\Client;

$connection = new Client('mongodb://root:MongoDB2019!@mongo:27017');

$collection = $connection->covid19->data;

$query = array(
    'signingDateParsed' => array(
        '$exists' => false
    )
);

$result = $collection->find($query);

foreach($result as $r){
    $date = strtotime(str_replace("/", "-", $r->signingDate)) * 1000;
    $newDate = new \MongoDB\BSON\UTCDateTime($date);

    echo $r->id . ' ' . $date . ' ' . $newDate . PHP_EOL;

    $r->signingDateParsed = $newDate;
    \Lib\DataStore::updateById($r->id,$r);
}
