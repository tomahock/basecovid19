<?php
require_once '../vendor/autoload.php';

use Lib\DataStore;
use Lib\EntidadeStore;


$exists = false;
if(!empty($_GET['nif'])){
    $nif = $_GET['nif'];

    $entidade = EntidadeStore::getItemByNIF($nif);
    $count = DataStore::getContractingContractsCount($nif);
    $lastContracts = DataStore::getLastByNif($nif);
    $totalPrice = DataStore::getContractingContractsTotalPrice($nif);
    $totalPrice = number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $totalPrice)),2);
    $totalWon = DataStore::getContractedContractsTotalPrice($nif);
    $totalWon = number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $totalWon)),2);
    if($entidade){
        $exists = true;
    }
}

$title = "Entidade - {$entidade->description}";
$description = "Contratos do base.gov.pt que mencionam COVID19 da entidade {$entidade->description}";


include 'includes/head.php';
?>

<div class="container">
    <?php if(!$exists): ?>
        <div class="row">
            <div class="col-12">
                <h2>Entidade não encontrada.</h2>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <h2>Entidade - <?= $entidade->description ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
<!--                        <p class="findr">🏛️ <strong>--><?//= $d->contracting[0]->description ?><!--</strong></p>-->
<!--                        <p class="findr">✒️<strong>--><?//= $d->contracted[0]->description ?><!--</strong></p>-->
<!--                        <p class="findr">💸 --><?//= $d->initialContractualPrice ?><!--</p>-->
<!--                        <p class="findr"> 📅 --><?//= $d->signingDate?><!--</p>-->
<!--                        <p class="findr">📜 --><?//= $d->objectBriefDescription?><!--</p>-->
<!--                        <p class="findr">🏷️ --><?//= $d->contractingProcedureType ?><!--</p>-->
                        <p>Total contratos: <?= $count ?></p>
                        <p>Total gasto: <?= $totalPrice ?>€</p>
                        <p>Total ganho: <?= $totalWon ?>€</p>
                    </div>
                    <div class="card-footer">
<!--                        <a class="btn btn-sm btn-secondary" href="http://www.base.gov.pt/Base/pt/Pesquisa/Contrato?a=--><?//= $d->id?><!--" target="_blank">Original</a>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <h1>Últimos contratos</h1>
        </div>
        <div class="row">

            <?php
            foreach ($lastContracts as $d):
                ?>
                <div class="col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="">🏛️ <?= $d->contracting[0]->description ?> <a href="entidade?nif=<?= $d->contracting[0]->nif ?>">🔗</a></p>
                            <p class="">✒️<?= $d->contracted[0]->description ?> <a href="entidade?nif=<?= $d->contracted[0]->nif ?>">🔗</a></p>
                            <p class="findr">💸 <?= $d->initialContractualPrice ?></p>
                            <p class="findr">📅 <?= $d->signingDate?></p>
                            <p class="findr">📜 <?= $d->objectBriefDescription?></p>
                            <p class="findr">🏷️ <?= $d->contractingProcedureType ?></p>

                        </div>
                        <div class="card-footer">
                            <a class="btn btn-sm btn-primary" href="/contrato.php?id=<?= $d->id ?>">Detalhes</a>
                            <a class="btn btn-sm btn-secondary" href="http://www.base.gov.pt/Base/pt/Pesquisa/Contrato?a=<?= $d->id?>" target="_blank">Original</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/foot.php'; ?>