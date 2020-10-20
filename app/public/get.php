<?php

require_once 'vendor/autoload.php';

use Lib\DataStore;
use Lib\Response;

if(!empty($_GET['id'])){
    $id = intval($_GET['id']);

    $data = DataStore::getItemById($id);
    if($data){
        $code = 200;
    } else {
        $code = 404;
        $data = array(
          'error' => 'No contract found with that id'
        );
    }
} else {
    $data = array(
        'error' => 'Invalid request. Should send id'
    );

    $code = 400;
}

Response::json($data, $code);
