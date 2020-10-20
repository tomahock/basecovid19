<?php
require_once '../vendor/autoload.php';
use Steampixel\Route;

Route::add('/', function() {
    include '../templates/_index.php';
});

Route::add('/entidade', function() {
    include '../templates/entidade.php';
});

Route::add('/contrato', function() {
    include '../templates/contrato.php';
});

Route::run('/');