<?php
require_once '../vendor/autoload.php';

$page = $_GET['page'] ? intval($_GET['page']) : 1;
$limit = 9;
$order = $_GET['order'] ? intval($_GET['order']) : -1;
$sort = $_GET['sort'] ? $_GET['sort'] : 'signingDateParsed';

$data = \Lib\DataStore::get($page, $sort, $limit, $order);
$count = \Lib\DataStore::getCount();

$pages = ceil($count / $limit);

if($page < 3){
    $sPage = 1;
} else {
    $sPage = $page -2;
}

$title = 'Contratos';
$description = 'Contratos do base.gov.pt que mencionam COVID19';
include 'includes/head.php';

?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <h1>Contratos</h1>
            </div>
            <div class="col-sm-12 col-md-6">
                <form method="get">
                    <input type="hidden" name="page" value="<?= $page ?>">
                    <select class="select" name="order">
                        <option value="-1" <?php if($order===-1): ?> selected<?php endif; ?>>Decrescente</option>
                        <option value="1"  <?php if($order===1): ?> selected<?php endif; ?>>Crescente</option>
                    </select>

                    <select class="select" name="sort">
                        <option value="signingDateParsed" <?php if($sort==='signingDateParsed'): ?> selected<?php endif; ?>>Data de Assinatura</option>
                        <option value="price" <?php if($sort==='price'): ?> selected<?php endif; ?>>Preço</option>
                    </select>

                </form>
            </div>
        </div>

        <div class="row">
            <?php
            foreach ($data as $d):
                ?>
                <div class="col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="">🏛️ <?= $d->contracting[0]->description ?> <a
                                        href="/entidade?nif=<?= $d->contracting[0]->nif ?>">🔗</a></p>
                            <p class="">✒️<?= $d->contracted[0]->description ?> <a
                                        href="/entidade?nif=<?= $d->contracted[0]->nif ?>">🔗</a></p>
                            <p class="findr">💸 <?= $d->initialContractualPrice ?></p>
                            <p class="findr">📅 <?= $d->signingDate ?></p>
                            <p class="findr">📜 <?= $d->objectBriefDescription ?></p>
                            <p class="findr">🏷️ <?= $d->contractingProcedureType ?></p>

                        </div>
                        <div class="card-footer">
                            <a class="btn btn-sm btn-primary" href="/contrato?id=<?= $d->id ?>">Detalhes</a>
                            <a class="btn btn-sm btn-secondary"
                               href="http://www.base.gov.pt/Base/pt/Pesquisa/Contrato?a=<?= $d->id ?>" target="_blank">Original</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <nav>
                    <ul class="pagination flex-wrap">
                        <li class="page-item <?php if ($page === 1): ?> disabled <?php endif; ?>">
                            <a class="page-link" href="/contratos?page=<?= $page-1 ?>&order=<?= $order ?>&sort=<?= $sort ?>">Anterior</a>
                        </li>
                        <?php for ($p = $sPage; $p <= $page + 6; $p++): ?>
                            <li class="page-item <?php if ($page === $p): ?> active<?php endif; ?>">
                                <a class="page-link"
                                   href="/contratos?page=<?= $p ?>&order=<?= $order ?>&sort=<?= $sort ?>"><?= $p ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item">
                            <a class="page-link" href="/contratos?page=<?= $page+1 ?>&order=<?= $order ?>&sort=<?= $sort ?>">Próxima</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

<?php include 'includes/foot.php'; ?>