<?php
require_once '../vendor/autoload.php';

use Lib\DataStore;

$search = $_GET['search'];
$page = $_GET['page'] ? $_GET['page'] : 1;

$d = DataStore::getSearchedContracts($search, $page);

print_r($d);

unset($d['created']);
unset($d['updated']);

$title = "Pesquisa";
$description = "Pesquisa no BASE COVID19";


include 'includes/head.php';

?>


    <div class="container mt-1">
        <form>
            <div class="form-group row">
                <label for="search" class="col-sm-2 col-form-label">Pesquisa</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="search" id="search" value="<?= $search ?>" />
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Pesquisar</button>
        </form>
    </div>

<?php include 'includes/foot.php'; ?>