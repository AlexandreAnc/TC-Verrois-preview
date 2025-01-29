<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$secretKey = "HIDDEN";
$reCaptchaResponse = $_POST['g-recaptcha-response'];

$reCaptchaVerifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($reCaptchaResponse));
$reCaptchaVerifyResponse = json_decode($reCaptchaVerifyResponse);

if ($reCaptchaVerifyResponse->success) {

    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $sujet = $_POST['sujet'];
    $email = $_POST['email'];
    $messageUtilisateur = $_POST['message']; 

    $message = "Nom : " . $nom . "\n" . "Prénom : " . $prenom . "\n" . "Sujet : " . $sujet . "\n" . "Email : " . $email . "\n" . "Message : " . $messageUtilisateur;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hidden_email';
        $mail->Password = 'hidden_password'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('from@example.com', 'Nouvelle prise de contact');
        $mail->addAddress('e-mail-receiver');

        $mail->isHTML(true);
        $mail->Subject = 'Informations du formulaire';
        $mail->Body    = nl2br($message);
        $mail->AltBody = $message;

        $mail->send();
        echo 'Message envoyé avec succès.';
    } catch (Exception $e) {
        echo "Erreur dans l'envoi du mail : " . $mail->ErrorInfo;
    }
} else {
    echo 'La vérification reCAPTCHA a échoué. Veuillez réessayer.';
}
