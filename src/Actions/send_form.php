<?php

namespace App\Actions;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $sujet = filter_input(INPUT_POST, 'sujet', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);
    
    if (empty($nom) || empty($email) || empty($sujet) || empty($message)) {
        header('Location: /?error=1');
        exit;
    }
    
    $to = 'caeles@live.fr';
    
    $email_subject = "Nouveau message du formulaire de contact: $sujet";
    
    $email_body = "Vous avez reu00e7u un nouveau message du formulaire de contact.\n\n".
        "Nom: $nom\n".
        "Email: $email\n".
        "Sujet: $sujet\n".
        "Message:\n$message";
    
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    
   if (mail($to, $email_subject, $email_body, $headers)) {
        header('Location: /?sent=1#contact');
    } else {
        header('Location: /?error=2');
    }
    
    exit;
}

header('Location: /');
exit;
