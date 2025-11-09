<?php




use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
 




header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS"); 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); 


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}


$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email']?? null;
if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["message" => "Invalid email address."]);
    http_response_code(400);
    exit();
}

$mail = new PHPMailer(true);

try {
   
    $mail->isSMTP();                                          
    $mail->Host       = 'smtp.gmail.com';                    
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'varmaharshith77@gmail.com';               
    $mail->Password   = 'yezrbhxooavxstpi';               
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       
    $mail->Port       = 587;                                  

    $mail->setFrom('varmaharshith77@gmail.com', 'Soft Street');
    $mail->addAddress($email);  
    $mail->isHTML(true);                                     
    $mail->Subject = 'Subscription Confirmation';
    $mail->Body    = '<h1>Thank You for Subscribing!</h1><p>You have successfully subscribed to our newsletter. we will have few changes</p>';
   

    $mail->send();
    echo 'Email has been sent';
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>