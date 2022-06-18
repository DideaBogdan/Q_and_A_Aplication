<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Autorization, X-Requested-With');

//Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'vendor/autoload.php';

$data = json_decode(file_get_contents("php://input"));
print_r($data);

$mail = new PHPMailer(); // create a new object
$mail->IsSMTP(); // enable SMTP
$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
$mail->SMTPAuth = true; // authentication enabled
$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
$mail->Host = "smtp.gmail.com";
$mail->Port = 465; // or 587
$mail->IsHTML(true);
$mail->Username = "qa.knowledge.bag@gmail.com";
$mail->Password = "vxfuebrvqdegjbew";
$mail->SetFrom( $data->email, $data->nume);
$mail->Subject = "New report";
$mail->Body = "Email: " .$data->email .'<br>' ."User: " .$data->name .'<br>' ." Phone number: " .$data->phone .'<br>' ."Subject: ".$data->subject;
$mail->AddAddress("qa.knowledge.bag@gmail.com");


 if(!$mail->Send()) {
   echo json_encode(array("answer" => "mesaj netrimis"));
   return false;
 } else {
    echo json_encode(array("answer" => "mesaj trimis"));
    return true;
 }



