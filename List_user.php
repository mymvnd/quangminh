<?php
    session_start();
    if(!isset($_SESSION['user'])){
        header("Location:login.php");
        exit();
    }
    require_once('db.php');

    $conn = open_database();
    $sql = "SELECT users_id,firstname,lastname,email,role FROM account";
    $data = [];
    $result = mysqli_query($conn,$sql);
    //echo mysqli_num_rows($result);
    $roles = '';
    $idroles ='';
    


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>List User</title>
</head>
<body>
    
<div class="container">
        <div class="row my-5">
            <div class="col">
                <div>
                    <a href="index.php">
                    <img class="logo" style="width:100px;height: 40px;" src="../web/images/icon_google.jpg" alt="">
                    </a>
                    <a href="index.php">Google Classroom</a>
                </div>
            </div>
            <div class="col text-right">
                <a class="btn btn-sm btn-outline-danger" href="logout.php">Logout</a>
            </div>
        </div>
        <div class="row">
        <a href="changepermission.php">Click here to change permisstion.</a>
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

                    <?php while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) : ?>
                        
                        <tr>
                            <td><?php echo $row['users_id']; ?></td>
                            <td><?php echo $row['firstname']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            
                            <td id="change-role"><?php 
                                                    if($row['role']==1){
                                                        echo "Admin";
                                                    }
                                                    if($row['role']==2){
                                                        echo "Teacher";
                                                    }
                                                    if($row['role']==3){
                                                        echo "Student";
                                                    }

                                                        ?>     
                            </td>
                            <td>
                            <?php
                                if($row['role']==3){
                                    
                                    ?>
                                    <a href="deleteuser.php?users_id=<?php echo $row["users_id"]?>" class="badge badge-info">Delete</a>
                                    <?php
                                }
                            ?>
                            </td>
                            
                        </tr>
                        
                    <?php endwhile; ?>

                    </tbody>
            
        </table>
        
        </div>
        
    
        
    <?php
    /*
    $row = 1;
                        if (($handle = fopen("StudentList.csv", "r")) !== FALSE) {
                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                $num = count($data);
                                //echo "<p> $num fields in line $row: <br /></p>\n";
                                // từng ô trong file csv lấy bằng  $data[i];
                                //$row++;
                               
                                for ($c=0; $c < $num; $c++) {
                                    echo "<tr class=" .'item' . ">";
                                    for($lo=0;$lo<4;$lo++){
                                        echo "<td class=".'align-middle'. "> $data[$lo]  </td>";
                                    }
                                    echo "</tr>";
                                }
                            }
                            fclose($handle);
                        }
    }*/
    ?>
    
    
</div>

</body>
</html>