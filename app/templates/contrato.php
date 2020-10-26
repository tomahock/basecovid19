<?php
require_once '../vendor/autoload.php';

use Lib\DataStore;

$exists = false;
if (!empty($_GET['id'])) {
    $id = intval($_GET['id']);

    $data = DataStore::getItemById($id);
    if ($data) {
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


    <div class="container contract">
        <?php if (!$exists): ?>
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

            <?php if (isset($_GET['reported'])) : ?>
                <div class="row">
                    <div class="col-12">
                        <?php if ($_GET['reported']) : ?>
                            <div class="alert-success">Reportado com sucesso.</div>
                        <?php else: ?>
                            <div class="alert-danger">Ocorreu um erro, reporte novamente.</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="">🏛️ <?= $d->contracting[0]->description ?> <a
                                        href="/entidade?nif=<?= $d->contracting[0]->nif ?>">🔗</a></p>
                            <p class="">✒️<?= $d->contracted[0]->description ?> <a
                                        href="/entidade?nif=<?= $d->contracted[0]->nif ?>">🔗</a></p>
                            <p class="findr">💸 <?= $d->initialContractualPrice ?></p>
                            <p class="findr"> 📅 <?= $d->signingDate ?></p>
                            <p class="findr">📜 <?= $d->objectBriefDescription ?></p>
                            <p class="findr">🏷️ <?= $d->contractingProcedureType ?></p>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-sm btn-danger js-report" data-toggle="modal"
                                    data-target="#reportModal"><i class="fas fa-bullhorn"></i></button>
                            <a class="btn btn-sm btn-secondary"
                               href="http://www.base.gov.pt/Base/pt/Pesquisa/Contrato?a=<?= $d->id ?>" target="_blank">Original</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-sm-12 col-md-4 title">
                    <p>Data de publicação no BASE</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->publicationDate ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Tipo(s) de contrato</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->contractTypes ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Tipo de procedimento</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->contractingProcedureType ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Descrição</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->description ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Fundamentação</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->contractFundamentationType ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Fundamentação da necessidade de recurso ao ajuste direto (se aplicável)</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->directAwardFundamentationType ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Entidade adjudicante - Nome, NIF</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->contracting[0]->description ?> - <?= $d->contracting[0]->nif ?> <a
                                href="/entidade?nif=<?= $d->contracting[0]->nif ?>">🔗</a></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Entidade adjudicatária - Nome, NIF</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <?php foreach ($d->contracted as $c): ?>
                        <p><span class="findr"><?= $c->description ?> - <?= $c->nif ?></span> <a
                                    href="/entidade?nif=<?= $c->nif ?>">🔗</a></p>
                    <?php endforeach; ?>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Objeto do Contrato</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->objectBriefDescription ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Procedimento Centralizado</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->centralizedProcedure ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>CPV</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->cpvs ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Data de celebração do contrato</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->signingDate ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Preço contratual</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->initialContractualPrice ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Prazo de execução</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->executionDeadline ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Local de execução - País, Distrito, Concelho</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->executionPlace ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Concorrentes</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <?php foreach ($d->contestants as $c): ?>
                        <p><span class="findr"><?= $c->description ?></span> - <?= $c->nif ?> <a
                                    href="/entidade?nif=<?= $c->nif ?>">🔗</a></p>
                    <?php endforeach; ?>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Local de execução - País, Distrito, Concelho</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->executionPlace ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>Justificação de contrato não escrito</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->nonWrittenContractJustificationTypes ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>endOfContractType</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->endOfContractType ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>causesPriceChange</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->causesPriceChange ?></p>
                </div>

                <div class="col-sm-12 col-md-4 title">
                    <p>causesDeadlineChange</p>
                </div>
                <div class="col-sm-12 col-md-8 description">
                    <p class="findr"><?= $d->causesDeadlineChange ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="POST" action="/api/v1/report">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Contrato inválido</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="h-captcha" data-sitekey="b1e813fe-0907-4163-90b6-89c0efe32940"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <input type="hidden" name="id" value="<?= $d->id; ?>"/>
                        <button type="submit" class="btn btn-primary">Submeter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


<?php include 'includes/foot.php'; ?>