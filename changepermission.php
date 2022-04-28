<?php
    require_once('db.php');
    
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<?php
    $user_id = '';
    $user_role = '';
    //$error = '';
    if(isset($_POST['users_id']) && isset($_POST['role'])){
        $user_id=$_POST['users_id'];
        $user_role=$_POST['role'];
        if($user_role == 'Admin'){
            $result = set_permission($user_id,$user_role);
            if($result['code'] == 0){
                $success = 'Permission has change for user.';
            }else if($result['code'] == 1){
                $error = 'This user is not exists';
            }else{
                $error = 'Failed. Try again later ';
            } 
        }
        elseif($user_role == 'Teacher'){
            $result = set_permission($user_id,$user_role);
            if($result['code'] == 0){
                $success = 'Permission has change for user.';
            }else if($result['code'] == 1){
                $error = 'This user is not exists';
            }else{
                $error = 'Failed. Try again later ';
            } 
        }
        elseif($user_role == 'Student'){
            $result = set_permission($user_id,$user_role);
            if($result['code'] == 0){
                $success = 'Permission has change for user.';
            }else if($result['code'] == 1){
                $error = 'This user is not exists';
            }else{
                $error = 'Failed. Try again later ';
            } 
        }else{
            $error = 'Wrong role.';
        }
        

    }

?>
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
            <form action="" method="post">
                <p>Choose MSSV to change permission:</p>            
                <input type="text" id="users_id" name="users_id" placeholder="MSSV">
                <p>There are 3 roles for you to set: Admin, Teacher, Student</p>
                <input type="text" name="role" id="role">
                </br>
                <?php
                        if (isset($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        }
                        if (isset($success)) {
                            echo "<div class='alert alert-success'>$success</div>";
                        }
                    ?>
                <button type="submit">Confirm</button>
            </form>
        </div>
</div>





    
</body>
</html>