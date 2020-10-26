<?php
require_once '../vendor/autoload.php';

use Lib\DataStore;

$search = $_GET['search'];
$page = $_GET['page'] ? intval($_GET['page']) : 1;

$limit = 9;
$order = $_GET['order'] ? intval($_GET['order']) : -1;
$sort = $_GET['sort'] ? $_GET['sort'] : 'signingDateParsed';

$data = DataStore::getSearchedContracts($search, $page, $sort, $limit, $order);
//$data = \Lib\DataStore::get($page, $sort, $limit, $order);
$count = \Lib\DataStore::getSearchedContractsCount($search, $page, $sort, $limit, $order);

$pages = ceil($count / $limit);

if ($page < 3) {
    $sPage = 1;
} else {
    $sPage = $page - 2;
}

$title = "Pesquisa";
$description = "Pesquisa no BASE COVID19";


include 'includes/head.php';

?>


    <div class="container mt-1">
        <form>
            <div class="form-group row">
                <label for="search" class="col-sm-2 col-form-label">Pesquisa</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="search" id="search" value="<?= $search ?>"/>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Pesquisar</button>
        </form>
    </div>

    <div class="container mt-1">

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


        <?php if ($count): ?>
            <div class="row mt-5">
                <div class="col-12">
                    <nav>
                        <ul class="pagination flex-wrap">
                            <li class="page-item <?php if ($page === 1): ?> disabled <?php endif; ?>">
                                <a class="page-link"
                                   href="/pesquisa?search=<?= $search ?>&page=<?= $page - 1 ?>&order=<?= $order ?>&sort=<?= $sort ?>">Anterior</a>
                            </li>
                            <?php for ($p = $sPage; $p <= $page + 6; $p++): ?>
                                <li class="page-item <?php if ($page === $p): ?> active<?php endif; ?>">
                                    <a class="page-link"
                                       href="/pesquisa?search=<?= $search ?>&page=<?= $p ?>&order=<?= $order ?>&sort=<?= $sort ?>"><?= $p ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item">
                                <a class="page-link"
                                   href="/pesquisa?search=<?= $search ?>&page=<?= $page + 1 ?>&order=<?= $order ?>&sort=<?= $sort ?>">Próxima</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

        <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <p>Não foram encontrados resultados</p>
                </div>
            </div>
        <?php endif; ?>

    </div>

<?php include 'includes/foot.php'; ?>