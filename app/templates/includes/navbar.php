<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="/">Base COVID19</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="/contratos">Contratos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/top-contratadas">Top Contratadas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/pesquisa">Pesquisa</a>
            </li>
        </ul>
        <!-- Search form -->
        <form class="form-inline ml-auto" action="/entidade" method="GET">
            <div class="md-form my-0">
                <input class="form-control mr-sm-2" type="text" name="nif" placeholder="NIF" aria-label="NIF">
            </div>
        </form>
    </div>
    <!-- Collapsible content -->

</nav>
<!--/.Navbar-->