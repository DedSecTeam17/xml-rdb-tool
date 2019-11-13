<html>
<head>
    <title>Home Page</title>
    <?php require 'views/partials/headers.php' ?>

</head>
<body style="background-color: #24252a">
<?php require 'views/partials/nav_bar.php' ?>

<div class="container-fluid">


    <div class="row mt-5">
        <div class="col-md-4 offset-md-4">
            <div class="card bg-dark">
                <div class="card-body">
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle btn-block" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            SELECT TABLE
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <?php

                            for ($i = 0; $i < sizeof($data); $i++) {
                                echo ' <a class="dropdown-item" href="' . Route::to('showTableContent', 'ToolController', $data[$i], true) . '">' . $data[$i] . '</a>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


</body>
</html>

