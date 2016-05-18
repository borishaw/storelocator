<?php
require_once 'securimage/securimage.php';
/**
 * 
 * Your Email. All Contact messages will be sent there
 */
$errors = array();
$responseArr = array();
$your_email = 'julie@ankitdesigns.com';
//$your_email = 'pchieni25@gmail.com';
$image = new Securimage();
if ($image->check($_POST['captcha_code']) == true) {
	//echo "Correct!";
} else {
	//echo "Sorry, wrong code.";
	//exit('<div class="error_message">Sorry, wrong code</div>');
	$errors['message']="Sorry, wrong code";
	$responseArr [1] = "Sorry, wrong code";
	//exit;
}
/* Do not change any code below this line unless you are sure what you are doing. */
$name = $_POST['name'];
$email = $_POST['email'];
//$phone = $_POST['phone'];
$message = $_POST['message'];



if ($name == '')
{
	$errors['name'] = 'Please enter your Name!';
	$responseArr [1] = "Please enter your Name!";
}

$phone = "N/A";

if ($phone == '')
{
	$errors['phone'] = 'Please enter your Phone!';
	$responseArr [1] = "Please enter your Phone!";
}

if ( ! filter_var($email, FILTER_VALIDATE_EMAIL))
{
	$errors['email'] = 'Please enter a valid Email!';
	$responseArr [1] = "Please enter a Valid Email!";
}
if ($message == '')
{
	$errors['message'] = 'Please enter the Message!';
	$responseArr [1] = "Please enter the Message!";
}



if (count($errors) == 0)
{
	require 'inc/class.phpmailer.php';
	$mail = new PHPMailer;

	$mail->AddAddress($your_email);

	$mail->From = $email;
	$mail->FromName = '';
	$mail->Subject = 'Contact request from http://'.$_SERVER['HTTP_HOST'].'/';
	$mail->Body = "Name: ".$name."\n"."Email: ".$email."\n"."Phone: ".$phone."\n\n"."Message:\n".$message;

	if($mail->Send()) {
		$response = array ('success' => 1);
		
		$responseArr [0] = "success";	
		$responseArr [1] = "Message Sent";
		echo json_encode($responseArr);
		exit;

	} else {
		$errors['sending'] = 'An error occurred while sending your message! Please try again later.';
		$responseArr [0] = "failed";
		$responseArr [1] = "Message Not Sent";
		echo json_encode($responseArr);
		exit;
	}

}else{
	
	$responseArr [0] = "Failed";
	echo json_encode($responseArr);
	
}
