<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
    require_once('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassWork</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
        <div class="row my-5">
            <div class="col">
                <div>
                    <img class="logo" style="width:100px;height: 40px;" src="../web/images/icon_google.jpg" alt="">
                    <a>Google Classroom</a>
                </div>
            </div>
            <div class="col text-center">hello</div>
            <div class="col text-right">
                <a class="btn btn-sm btn-outline-danger" href="logout.php">Logout</a>
            </div>
        </div>

        <div class="row">
        <table class="table table-hover table-striped table-bordered text-center" >  
            <thead>
                <tr>
                    <th>MSSV</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Gmail</th>
                    <th>Action</th>
                    <th>Action2</th>
                </tr>
            </thead>
            <tbody>

            
            <?php
                $tep=0;
                $row = 1;
                if (($handle = fopen("StudentList.csv", "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        //echo "<p> $num fields in line $row: <br /></p>\n";
                        // từng ô trong file csv lấy bằng  $data[i];
                        //$row++;
                        echo "$num $tep";
                        for ($c=0; $c < $num; $c++) {
                            echo "<tr class=" .'item' . ">";
                            for($lo=0;$lo<4;$lo++){
                                echo "<td class=".'align-middle'. "> $data[$lo]  </td>";
                                
                            }
                            $tep++;
                            echo "</tr>";
                        }
                    }
                    fclose($handle);
                }
                
                ?>

            </tbody>
        </table>
        </div>
</div>
</body>
</html>