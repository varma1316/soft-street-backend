<?php
// Enable CORS for your React app (replace 'http://localhost:3000' if needed)


// Include PHPMailer (adjust path if necessary)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';


header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || empty($data['email'])) {
    echo json_encode(["success" => false, "error" => "Invalid input data."]);
    exit;
}

// Extract address details from the received data
$address = $data['address'];
$city = $data['city'];
$state = $data['state'];
$postalCode = $data['postalCode'];
$country = $data['country'];
$email = $data['email'];
$phone = $data['phone'];

// Initialize PHPMailer and set up email configuration
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'varmaharshith77@gmail.com'; // SMTP username
    $mail->Password = 'yezrbhxooavxstpi'; // SMTP password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Recipient settings
    $mail->setFrom('varmaharshith77@gmail.com', 'Soft Street'); // Sender's email and name
    $mail->addAddress($email); // Recipient's email

    // Email content
    $mail->isHTML(true);
    $mail->Subject = 'Order Confirmation - Address Details';
    $mail->Body = "
        <h3>Thank you for your order!</h3>
        <p><strong>Address:</strong> $address</p>
        <p><strong>City:</strong> $city</p>
        <p><strong>State:</strong> $state</p>
        <p><strong>Postal Code:</strong> $postalCode</p>
        <p><strong>Country:</strong> $country</p>
        <p><strong>Phone:</strong> $phone</p>
    ";

    // Send the email
    $mail->send();
    echo json_encode(["success" => true, "message" => "Order confirmation email sent successfully!"]);

} catch (Exception $e) {
    echo json_encode(["success" => false, "error" => "Failed to send email: " . $mail->ErrorInfo]);
}
