<?php

    require_once('db.php');
    $conn = open_database();
    $id = $_GET['users_id'];
    $del = mysqli_query($conn,"delete from account where users_id = '$id'");
    if($del)
    {
        mysqli_close($conn);
        header("location:List_user.php");
        exit;	
    }
    else
    {
        echo "Error deleting account";
    }
?>