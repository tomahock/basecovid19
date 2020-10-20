<?php
require_once '../vendor/autoload.php';

use Lib\DataStore;

$exists = false;
if(!empty($_GET['id'])){
    $id = intval($_GET['id']);

    $data = DataStore::getItemById($id);
    if($data){
        $exists = true;
    }
}

$d = DataStore::getItemById($id);
unset($d['created']);
unset($d['updated']);

$title = "Contrato - {$d->contracting[0]->description} e {$d->contracted[0]->description}";
$description = "{$d->objectBriefDescription}";

include 'includes/head.php';

?>


<div class="container">
    <?php if(!$exists): ?>
        <div class="row">
            <div class="col-12">
                <h2>Contrato não encontrado.</h2>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-12">
                <h2>Detalhe - <?= $d->id ?></h2>
            </div>
        </div>

        <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="">🏛️ <?= $d->contracting[0]->description ?> <a href="/entidade?nif=<?= $d->contracting[0]->nif ?>">🔗</a></p>
                            <p class="">✒️<?= $d->contracted[0]->description ?> <a href="/entidade?nif=<?= $d->contracted[0]->nif ?>">🔗</a></p>
                            <p class="findr">💸 <?= $d->initialContractualPrice ?></p>
                            <p class="findr"> 📅 <?= $d->signingDate?></p>
                            <p class="findr">📜 <?= $d->objectBriefDescription?></p>
                            <p class="findr">🏷️ <?= $d->contractingProcedureType ?></p>
                        </div>
                        <div class="card-footer">
                            <a class="btn btn-sm btn-secondary" href="http://www.base.gov.pt/Base/pt/Pesquisa/Contrato?a=<?= $d->id?>" target="_blank">Original</a>
                        </div>
                    </div>
                </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table table-responsive table-bordered">
                    <tbody>
                        <?php foreach($d as $k => $v): ?>
                            <tr>
                                <td><?= $k ?></td>
                                <td class="findr">
                                    <?php if( $v instanceof  MongoDB\Model\BSONArray ):
                                        foreach($v as $vv) {
                                            if( $vv instanceof  MongoDB\Model\BSONDocument ){
                                                foreach($vv as $vvv){
                                                    echo "<span> {$vvv} </span>";
                                                }
                                            } else {
                                                echo $vv;
                                            }
                                        } ?>
                                    <?php else: ?>
                                        <?= $v ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/foot.php'; ?>