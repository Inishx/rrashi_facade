<?php

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  exit();
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$to = "contact@rrashi-facade.fr"; 



// Crï¿œer une nouvelle instance de PHPMailer
$mail = new PHPMailer(true);

try {
    // Paramï¿œtres du serveur GMAIL
    $mail->isSMTP();                                    // Utiliser SMTP
    $mail->Host = 'mail.rrashi-facade.fr';                     // Serveur SMTP (par exemple Gmail)
    $mail->SMTPAuth = true;                             // Activer l'authentification SMTP
    $mail->Username = 'contact@rrashi-facade.fr';          // Adresse e-mail SMTP
    $mail->Password = 'inissite24@A';          // Mot de passe SMTP ou mot de passe d'application
    $mail->SMTPSecure = 'ssl';                          // Activer le chiffrement TLS
    $mail->Port = 587;                                  // Port SMTP pour TLS
    

   

    // Paramï¿œtres de l'e-mail
    $mail->setFrom($email, $name);                      // L'expï¿œditeur du mail (l'adresse saisie dans le formulaire)
    $mail->addAddress($to);                             // Destinataire (votre adresse)
    $mail->addReplyTo($email);                          // Ajouter une adresse de rï¿œponse (l'e-mail du formulaire)

    // Contenu de l'e-mail
    $mail->isHTML(false);                               // Envoyer en texte brut
    $mail->Subject = "$m_subject:  $name";              // Objet de l'e-mail
    $mail->Body    = "Vous avez recu un nouveau message via le formulaire de contact de votre site web.\n\n"."Voici les details:\n\nName: $name\n\nEmail: $email\n\nSubject: $m_subject\n\nMessage: $message";

    // Envoyer l'e-mail
    $mail->send();
    echo "mail envoyï¿œ !";
} catch (Exception $e) {
    // Gestion des erreurs
    echo "ERROR: " . $e ;
    //http_response_code(500);
    echo " Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo} ";
}

?>
