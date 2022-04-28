<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;  

    require 'vendor/autoload.php';

    define('HOST','localhost');
    define('USER','root');
    define('PASS','');
    define('DB','classroom') ; 
    
    function open_database(){
        $conn = new mysqli(HOST,USER,PASS,DB);
        if($conn->connect_error){
            die('Connect error: ' . $conn->connect_error);
        }
        return $conn;
    }    
    function login($user,$pass){
        $sql = "select * from account where username = ?";
        $conn = open_database();

        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$user);
        
        if(!$stm->execute()){
            return array('code' => 1,'error' => 'Cannot execute');
        }
        $result = $stm->get_result();
        if($result->num_rows == 0){
            return array('code' => 1,'error' => 'user not exist');
        }
        $data =  $result->fetch_assoc();

        $hashed_pass = $data['password'];
        if(!password_verify($pass,$hashed_pass)){
            return array('code' => 2,'error' => 'invalid password');
        }
        else if($data['activated'] == 0){
            return array('code' => 3,'error' => 'account still not activated');
        }else
            {
                return array('code' => 0,'error' => '','data' => $data);
        }
        
    }
    function is_email_exists($email){
        $sql = 'select username from account where email = ?';
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$email);
        if(!$stm->execute()){

            die('Query error' . $stm->error);
        }
        $result = $stm->get_result();
        if($result->num_rows > 0){
            return true;
        }else {
            return false;
        }

    }
    function register($id,$user,$pass,$first,$last,$email){
        if(is_email_exists($email)){
            return array('code' => 1, 'error' => 'Email exists');
        }
        
        $hash = password_hash($pass,PASSWORD_DEFAULT);
        $rand = random_int(0,1000);
        $token =md5($user . '+' . $rand);
        

        $sql = 'insert into account(users_id,username,firstname,lastname,email,password,token)VALUES(?,?,?,?,?,?,?)';
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('sssssss',$id,$user,$first,$last,$email,$hash,$token);
        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'Cannot execute command');
        }
        sendActivateEmail($email,$token);
        return array('code' => 0, 'error' => 'Create account successful');
        
        
    }
    function sendActivateEmail($email,$token){
        
    
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();        
            $mail->CharSet = 'UTF-8';                                      // Send using SMTP
                                                // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'trancongquangminh.0312@gmail.com';                     // SMTP username
            $mail->Password   = 'wgabjcwuffzjhvcq';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('trancongquangminh.0312@gmail.com', 'Admin');
            $mail->addAddress($email, 'receiver');     // Add a recipient
            /*$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');
            */

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Xác minh tài khoản';
            $mail->Body    = "Nhấn <a href='http://localhost/web/activate.php?email=$email&token=$token'> vào đây </a> để kích hoạt";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

         
    }
    function sendresetEmail($email,$token){
        
    
        $mail = new PHPMailer(true);

        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();     
            $mail->CharSet = 'UTF-8';                                      // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'trancongquangminh.0312@gmail.com';                     // SMTP username
            $mail->Password   = 'wgabjcwuffzjhvcq';                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Recipients
            $mail->setFrom('trancongquangminh.0312@gmail.com', 'Admin');
            $mail->addAddress($email, 'receiver');     // Add a recipient
            /*$mail->addAddress('ellen@example.com');               // Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');
            */

            // Attachments
            //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            // Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'reset your password ';
            $mail->Body    = "Nhấn <a href='http://localhost/web/reset_password.php?email=$email&token=$token'> vào đây </a>đặt lại mật khẩu";
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }

         
    }
    function activeAccount($email,$token){
        $sql = 'select username from account where email = ? 
        and token = ? and activated = 0';
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$email,$token);
        if(!$stm->execute()){
            return array('code' => 1, 'error' =>'Can not do it');
        }
        $result = $stm->get_result();
        if($result->num_rows == 0){
            return array('code' => 2, 'error' =>'not found');
        }
        $sql = "update account set activated = 1,token = '' where email = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$email);
        if(!$stm->execute()){
            return array('code' => 1, 'error' =>'Can not do it');
        }
        return array('code' => 0, 'message' =>'Account activated');


    }
    function reset_password($email){
        if(!is_email_exists($email)){
            return array('code' => 1, 'error' => 'email not exists');
        }


        $token = md5($email . '+' . random_int(1000,2000));
        $sql = 'update reset_token set token = ? where email = ?';
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$token,$email);

        if(!$stm->execute()){
            return array('code' => 2, 'error' => 'cannot execute commnad');
        }

        if($stm->affected_rows == 0){
            $exp = time() + 3600 * 2;
            $sql = 'insert into reset_token values(?,?,?)';
            $stm = $conn->prepare($sql);
            $stm->bind_param('ssi',$email,$token,$exp);

            if(!$stm->execute()){
                return array('code' => 1, 'error' => 'cannot execute commnad');
            }
        }
        $success = sendresetEmail($email,$token);
            return array('code' => 0, 'success' =>  $success);


    }
    function is_user_exist($user_id){
        $sql = 'select username from account where users_id = ?';
        $conn = open_database();
        $stm = $conn->prepare($sql);
        $stm->bind_param('s',$user_id);
        if(!$stm->execute()){

            die('Query error' . $stm->error);
        }
        $result = $stm->get_result();
        if($result->num_rows > 0){
            return true;
        }else {
            return false;
        }
    }
    function set_permission($user_id,$user_role){
            
            $roles ='';
            if($user_role == 'Admin'){
                $roles = '1';
            }elseif($user_role == 'Teacher'){
                $roles = '2';
            }else{
                $roles = '3';
            }
            if(is_user_exist($user_id)){
                $sql = 'update account set role = ? where users_id = ?';
                $conn = open_database();
                $stm = $conn->prepare($sql);
                $stm->bind_param('ss',$roles,$user_id);
                if(!$stm->execute()){
                    die('Query error' . $stm->error);
                }else
                {
                    return array('code' => 0,'error' => '');
                }
            }else {
                return array('code' => 1,'error' => 'Wrong MSSV');      }
            
            
            
        
        
    }
    function control_class($classid,$classname,$tcname,$des,$room,$schedul){
        $sql ="SELECT * FROM class WHERE classroom_id = $classid";
        $conn = open_database();
        $result = $conn->query($sql);
        
        if($result->num_rows == 0){
            $sql='INSERT INTO class(classroom_id,class_name,descript,No_Room,TC_name,No_Schedule) VALUES(?,?,?,?,?,?)';
            $conn = open_database();
            $stm = $conn->prepare($sql);
            $stm->bind_param('ssssss',$classid,$classname,$des,$room,$tcname,$schedul);
            if (!$stm->execute()){
                return array('code' => 2, 'error' => 'can not execute command');
                }else{
                return array('code' => 0, 'error' => 'Create class successful');
                }
        }else{
            if($result->num_rows == 1){
                $sql2='UPDATE class SET class_name=?,descript=?,No_Room=?,TC_name=?,No_Schedule=? WHERE classroom_id=?';
                $conn2 = open_database();
                $stm = $conn2->prepare($sql2);
                $stm->bind_param('ssssss',$classname,$des,$room,$tcname,$schedul,$classid);
                if (!$stm->execute()){
                    return array('code' => 2, 'error' => 'can not execute command');
                }else{
                    return array('code' => 0, 'error' => 'Edit successful');
                }
            }
        }
            
        
        
    }
?>