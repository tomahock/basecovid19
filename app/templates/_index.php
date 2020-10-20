<?php
require_once '../vendor/autoload.php';
$data = \Lib\DataStore::getLast10();

$title = 'Inicio';
$description = 'Contratos do base.gov.pt que mencionam COVID19';
include 'includes/head.php';

?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Últimos contratos</h2>
        </div>
    </div>

    <div class="row">
        <?php
        foreach ($data as $d):
            ?>
            <div class="col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <p class="">🏛️ <?= $d->contracting[0]->description ?> <a href="/entidade?nif=<?= $d->contracting[0]->nif ?>">🔗</a></p>
                        <p class="">✒️<?= $d->contracted[0]->description ?> <a href="/entidade?nif=<?= $d->contracted[0]->nif ?>">🔗</a></p>
                        <p class="findr">💸 <?= $d->initialContractualPrice ?></p>
                        <p class="findr">📅 <?= $d->signingDate?></p>
                        <p class="findr">📜 <?= $d->objectBriefDescription?></p>
                        <p class="findr">🏷️ <?= $d->contractingProcedureType ?></p>

                    </div>
                    <div class="card-footer">
                        <a class="btn btn-sm btn-primary" href="/contrato?id=<?= $d->id ?>">Detalhes</a>
                        <a class="btn btn-sm btn-secondary" href="http://www.base.gov.pt/Base/pt/Pesquisa/Contrato?a=<?= $d->id?>" target="_blank">Original</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/foot.php'; ?>