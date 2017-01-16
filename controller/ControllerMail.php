<?php
class ControllerMail {

  private static $email_source = 'myguesthouse.group@gmail.com'; // Indiquez votre adresse e-mail SMTP

  public static function sendMail($destination, $sujet, $contenu) {
    if(filter_var($destination, FILTER_VALIDATE_EMAIL)) {
      if(!empty($contenu) && !ctype_space($contenu)) {
        // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        // En-têtes additionnels
        $headers .= 'To: <'.$destination.'>' . "\r\n";
        $headers .= 'From: MyGuestHouse <'.static::$email_source.'>' . "\r\n";

        // Envoi
        if(@mail($destination, '=?utf-8?B?'.base64_encode($sujet).'?=', $contenu, $headers)) {
          return true;
        } else {
          return false;
        }
      }
    }
  }
}
?>