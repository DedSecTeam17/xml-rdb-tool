<html>
<head>
    <title>Home Page</title>
    <?php require 'views/partials/headers.php' ?>

</head>
<body style="background-color: #24252a">
<?php require 'views/partials/nav_bar.php' ?>

<div class="container-fluid">


    <div class="row mt-5">
        <div class="col-md-8 offset-md-2 ">
            <div class="card bg-dark">
                <div class="card-body">

                    <?php

                    if (!empty($data['message'])) {
                        echo '<div class="alert alert-success" role="alert">' . '<p>' . $data["message"] . '</p>' . '   </div>';
                    }


                    ?>
                    <a class="btn btn-outline-info"   href="<?php echo  Route::to('export', 'ToolController', $data['table_name'], true) ?>"><i class="fas fa-file-export">EXPORT TO XML</i></a>
                    <?php

                    if (!is_null($data)) {
                        echo '<h5 class="text-white m-2">TABLE  CONTENT</h5>';

                        echo '  <table class="table table-dark">
                <thead>
                <tr>';


                        for ($i = 0; $i < sizeof($data["attr"]); $i++) {
                            echo '<th scope="col">' . $data["attr"][$i] . '</th>';
                        }

                        echo ' </tr>


                </thead>
                <tbody>
';


                        foreach ($data['data'] as $object) {
                            echo ' <tr>';
                            for ($i = 0; $i < sizeof($data["attr"]); $i++) {
                                $attr_key = $data["attr"][$i];
                                echo '<td>' . $object[$attr_key] . '</td>';
                            }
                            echo '   </tr>';
                        }


                        echo '  </tbody>
            </table>
        </div>';


                    }

                    ?>
                </div>
            </div>
        </div>
    </div>


</div>


</body>
</html>

