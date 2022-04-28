<?php

    require_once('db.php');
    $conn = open_database();
    $id = $_GET['classroomid'];
    $del = mysqli_query($conn,"delete from class where classroom_id = '$id'");
    if($del)
    {
        mysqli_close($conn);
        header("location:index.php");
        exit;	
    }
    else
    {
        echo "Error deleting class";
    }
?>