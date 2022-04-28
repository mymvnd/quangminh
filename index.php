<?php
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
    require_once('db.php');
    $username = $_SESSION['user'];
    $role = '';
    $conn = open_database();

    $sql = "SELECT username,role FROM account ";
    $result = $conn->query($sql);
    if($result->num_rows >0){
        while($row = $result->fetch_assoc()){
            if($row['username'] == $username){
                $role = $row['role'];
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Class Room</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .item img {
            height: 100px;
        }
    </style>
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
            <div class="col text-right">
                <?php
                    if($role == 2 || $role == 1){
                        echo '<a class="btn btn-sm btn-outline-success" href="createclass.php"> Add Class </a>';
                    }
                ?>
                <?php
                    if($role == 1){
                        echo '<a class="btn btn-sm btn-outline-success" href="List_user.php"> User list </a>';
                    }
                ?>
                <a class="btn btn-sm btn-outline-danger" href="logout.php">Logout</a>
            </div>
        </div>
        <div class="row">
            <?php
            require_once('db.php');
            $conn = open_database();
            $sql = "SELECT * FROM class";
            $result = $conn->query($sql);
            if($role ==1){
                while ($row = $result->fetch_assoc()) {
                    ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-body" style="background-image: url('images/soi.jpg');">
                                    <a class="card-tiltle" href="classwork.php?classroomid=<?php echo $row["classroom_id"]?>">
                                        <div class="class"><?php echo $row["class_name"] ?></div>
                                        <div class="class-info"><?php echo $row["No_Room"] . " " . $row["descript"] ?></div>
                                    </a>
                                    <div class="card-text"><?php echo $row["TC_name"] ?></div>
                                </div>
                                <div class="card-body">
                                    <img class="avt" src="<?php echo $row["Picture"] ?>" alt="">
                                </div>
                                <div>
                                    <a href="editclass.php?classroomid=<?php echo $row["classroom_id"]?>" class="badge badge-info">Edit</a>
                                </div>
                                <div>
                                    <a href="deleteclass.php?classroomid=<?php echo $row["classroom_id"]?>" class="badge badge-info">Delete</a>
                                </div>
                            </div>
                        </div>
                    <?php
                    }                    
            }
            ?>
        </div>        
    </div>
</body>
</html>