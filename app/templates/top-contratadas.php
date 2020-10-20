<?php
require_once '../vendor/autoload.php';

use Lib\DataStore;


$d = DataStore::getTopContracted();

unset($d['created']);
unset($d['updated']);

$title = "TOP";

include 'includes/head.php';

?>


<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Lista de entidades mais contratadas</h2>
        </div>
    </div>

    <div class="row">
            <div class="col-md-12 col-sm-12">
                <ul>
                    <?php foreach ($d as $contracted): ?>
                        <li><a href="/entidade?nif=<?= $contracted->_id ?>"><?= $contracted->_id ?></a>: <?= $contracted->count ?> contratos (total <?= $contracted->sum_price ?>€)</li>
                    <?php endforeach; ?>
                </ul>

            </div>
    </div>
</div>

<?php include 'includes/foot.php'; ?>