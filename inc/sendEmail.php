﻿<?php

// Replace this with your own email address
$siteOwnersEmail = 'msyradoeva@mail.ru';


if($_POST) {

   $name = trim(stripslashes($_POST['contactName']));
   $email = trim(stripslashes($_POST['contactEmail']));
   $subject = trim(stripslashes($_POST['contactSubject']));
   $contact_message = trim(stripslashes($_POST['contactMessage']));

   // Check Name
	if (strlen($name) < 2) {
		$error['name'] = "Пожалуйста, введите своё имя";
	}
	// Check Email
	if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
		$error['email'] = "Пожалуйста, введите валидный E-mail";
	}
	// Check Message
	if (strlen($contact_message) < 15) {
		$error['message'] = "Пожалуйста, введите сообщение. В нем должно быть не менее 15 символов.";
	}
   // Subject
	if ($subject == '') { $subject = "Отправка контактной формы"; }


   // Set Message
   $message .= "Email от: " . $name . "<br />";
	$message .= "Email адрес: " . $email . "<br />";
   $message .= "Сообщение: <br />";
   $message .= $contact_message;
   $message .= "<br /> ----- <br /> Это письмо было отправлено от контактной формы сайта [QA] Syradoeva. <br />";

   // Set From: header
   $from =  $name . " <" . $email . ">";

   // Email Headers
	$headers = "From: " . $from . "\r\n";
	$headers .= "Reply-To: ". $email . "\r\n";
 	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";


   if (!$error) {

      ini_set("sendmail_from", $siteOwnersEmail); // for windows server
      $mail = mail($siteOwnersEmail, $subject, $message, $headers);

		if ($mail) { echo "OK"; }
      else { echo "Что-то пошло не так. Пожалуйста, попробуйте снова."; }
		
	} # end if - no validation error

	else {

		$response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
		$response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
		$response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;
		
		echo $response;

	} # end if - there was a validation error

}

?>