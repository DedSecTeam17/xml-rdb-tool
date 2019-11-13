<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><i class="fas fa-tools"></i> E2E</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <!--            <li class="nav-item active">-->
            <!--                <a class="nav-link" href="#">XML TO RDB</a>-->
            <!--            </li>-->


            <?php
            echo '
                     <li class="nav-item ">
                <a class="nav-link"   href="' . Route::to('xmlToRdbIndex', 'ToolController', null, false) . '"><i class="fas fa-scroll" style="font-size: 10px">XML</i> TO <i class="fas fa-database" style="font-size: 10px">DB</i></span></a>
            </li> ';


            echo '
                     <li class="nav-item ">
                <a class="nav-link"   href="' . Route::to('rdbToXmlIndex', 'ToolController', null, false) . '"><i class="fas fa-database" style="font-size: 10px">DB</i> TO <i class="fas fa-scroll" style="font-size: 10px">XML</i></span></a>
            </li> ';

            ?>


            <!--            <li class="nav-item">-->
            <!--                <a class="nav-link" href="#">RDB TO XML</a>-->
            <!--            </li>-->


        </ul>
    </div>
</nav>