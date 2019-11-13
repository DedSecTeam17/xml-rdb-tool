<html lang="ar">
<head>
    <title>Home Page</title>
    <?php require 'views/partials/headers.php' ?>
</head>

<style>

    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
    }

</style>
<body style="background-color: #24252a">
<?php require 'views/partials/nav_bar.php' ?>


<div class="container-fluid">


    <div class="row mt-5">
        <div class="col-md-4 offset-md-4">

            <?php

            if (!empty($data['message_type'])) {
                if ($data['message_type'] === 'error') {
                    echo '<div class="alert alert-error" role="alert">' . '<p>' . $data["message"] . '</p>' . '   </div>';

                } else {
                    echo '<div class="alert alert-success" role="alert">' . '<p>' . $data["message"] . '</p>' . '   </div>';
                }
            }


            ?>


            <!---->
            <div class="card bg-dark">
                <div class="card-body ">
                    <form method="post" enctype="multipart/form-data"
                          action="<?php echo Route::to('xmlToRdb', 'ToolController', null, false) ?>">
                        <div class="form-group">
                            <label for="exampleFormControlFile1" class="text-white">Choose xml file to be converted</label><br>

                            <span class=" btn-file btn btn-outline-info btn-block"><i class="fas fa-upload"></i>
                                <input type="file" class="form-control-file" name="xml_file">
                            </span>

                        </div>
                        <button type="submit" class="btn btn-outline-info btn-block" >CONVERT</button>
                    </form>
                </div>

            </div>
            <!--            table  -->

            <?php

            if (!is_null($data)) {
                echo '<h5>XML FILE CONTENT</h5>';

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
                    $el = get_object_vars($object->children());
                    echo ' <tr>';
                    for ($i = 0; $i < sizeof($data["attr"]); $i++) {
                        $attr_key = $data["attr"][$i];
                        echo '<td>' . $el[$attr_key] . '</td>';
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

    <script>

    </script>


</body>

</html>

