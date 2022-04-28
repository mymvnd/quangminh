<?php
    session_start();
    
    require_once ('db.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Class</title>
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
        <form  method="post" action="" novalidate enctype="multipart/form-data">
        <h3>Edit Class</h3>
        <?php
            $success='';
            $error = '';
            $classid = $_GET['classroomid'];
            $conn = open_database();
            $sql="SELECT class_name,descript,No_Room,TC_name,No_Schedule FROM class WHERE classroom_id = $classid ";
            $result = $conn->query($sql);
            
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()){
                    $classname = $row["class_name"];
                    $tcname =$row["TC_name"] ;
                    $des = $row["descript"] ;
                    $room = $row["No_Room"];
                    $schedul =$row["No_Schedule"] ;
                    
                }


            }
            $picture ='' ;
            $pic = '';
            
            
            
            
            
            if(isset($_POST['classroomid']) && isset($_POST['classname'])
            && isset($_POST['noroom']) && isset($_POST['noschedule']))
            {
                $classid = $_POST['classroomid'];     
                $classname = $_POST['classname'];
                $tcname = $_POST['tcname'];
                $des = $_POST['description'];
                $room = $_POST['noroom'];
                $schedul = $_POST['noschedule'];

                
                if(empty($classid)){
                    $error = 'Please input Class ID';
                }
                elseif(empty($classname)){
                    $error = 'Please input Class name';
                }
                elseif(empty($tcname)){
                    $error = 'Please input Name of Teacher';
                }
                elseif(empty($des)){
                    $error = 'Please input Description';
                }
                elseif(empty($room)){
                    $error = 'Please input Room';
                }
                elseif(empty($schedul)){
                    $error = 'Please input Schedule';
                }else{
                    $result = control_class($classid,$classname,$tcname,$des,$room,$schedul);
                    if ($result['code'] == 0) {
                        // successful
                        $success = "Edit successfully.";
                        
                    } else if ($result['code'] == 2) {
                        $error = "Cannot edit class";
                    } else {
                        $error = "try again later";
                    }
                }
            }
        ?>
            <div class="form-group">
                <label for="subject">Class ID:</label>
                <input value="<?= $classid ?>" type="text" class="form-control" required placeholder="Class ID" id='classroomid' name='classroomid'>
            </div>
            <div class="form-group">
                <label for="">Class Name:</label>
                <input value="<?= $classname?>"  type="text" class="form-control" required placeholder="Class Name" id='classname' name='classname'>
            </div>

            <div class="form-group">
                <label for="">Teacher Name:</label>
                <input value="<?= $tcname?>"  type="text" class="form-control" required placeholder="Teacher Name" id='tcname' name='tcname'>
            </div>
            <div class="form-group">
                <label for="">Description:</label>
                <input value="<?= $des ?>" type="text" class="form-control" required placeholder="Description" id='description' name='description'>
            </div>
            

            <div class="form-group">
                <label for="classroom">Room:</label>
                <input value="<?= $room ?>" type="text" class="form-control" required placeholder="Room" id='noroom' name='noroom'>
            </div>
            <div class="form-group">
                <label for="No_sche">Number of Chedule:</label>
                <input value="<?= $schedul ?>" type="text" class="form-control" required placeholder="Number of Schedule" id='noschedule' name='noschedule'>
            </div>

            <div class="form-group">
                <label for="image">Picture:</label>
                <input type="file" class="form-control" required placeholder="Picture" id='picture' name='fileupload[]' multiple="multiple" >
            </div>
            <div class="form-group">
                <?php
                    if (!empty($error)) {
                    echo "<div class='alert alert-danger'>$error</div>";
                    }
                ?>
                <?php
                    if (!empty($success)) {
                    echo "<div class='alert alert-success'>$success</div>";
                    }
                ?>

            <!--<div class="d-flex justify-centent-center form-group w-10">-->
                <table style="margin: auto; text-align: center">
                    <td>
                        <tr>
                            <button type="submit" id='login-bt-dangky' class="btn btn-success">Edit</button>
                        </tr>
                    </td>
                    
                    <td>
                        <tr>
                            <button type="submit" id='login-bt-default' class="btn btn-default"><a href="index.php">Cancel</a></button>
                        </tr>
                    </td>
                    
                </table>
            </div>
            <!--</div>-->

        </form>
    </div>
</body>
</html>