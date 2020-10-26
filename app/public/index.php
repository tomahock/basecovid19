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

Route::add('/contratos', function() {
    include '../templates/contratos.php';
});

Route::add('/pesquisa', function() {
    include '../templates/search.php';
});

Route::add('/top-contratadas', function() {
    include '../templates/top-contratadas.php';
});

Route::add('/api/v1/report', function() {
    include '../API/report.php';
}, 'post');

Route::run('/');