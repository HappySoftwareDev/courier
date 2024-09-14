<?php
    require_once('../db.php'); 
    
    if (isset($_POST['name'])) {
       $name = $_POST['name'];
       $lastname = $_POST['lastname'];
       $email = $_POST['email'];
       $message = $_POST['message'];
       $stmt = $Connect->prepare("INSERT INTO contacts (Name, Surname, Email, message) VALUES ('$name', '$lastname', '$email', '$message')");
       
    if ($stmt->execute()) {
    
        $email_to = "bamhara1@google.com";
        $email = $_POST['email'];
    
        $email_subject = "New Message From" . $name;
    
        $email_from = "orders@merchantcouriers.com";
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $msg = $_POST['message'];
    
        function clean_string($string)
        {
    
            $bad = array("content-type", "bcc:", "to:", "cc:", "href");
    
            return str_replace($bad, "", $string);
        }
    
        $email_message = $name;
        $email_message = $email;
        $email_message = $msg;
    
        $headers = 'From: ' . $email_from . "\r\n" .
    
            'Reply-To: ' . $email . "\r\n" .
    
            'X-Mailer: PHP/' . phpversion();
    
        @mail($email_to, $email_subject, $email_message, $headers);
        
     
     
    
        echo "<script>alert('Message sent!')</script>";
        echo "<script>window.open('index.html','_self')</script>";
     
    }else {
        echo "<script>alert('Error failed to send!')</script>";
    }
    }

?>