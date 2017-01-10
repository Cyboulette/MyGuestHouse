<?php
require_once File::build_path(array('lib', 'PHPMailer', 'PHPMailerAutoload.php'));

class ControllerMail {

  private static $email_source = 'myguesthouse.group@gmail.com'; // Indiquez votre adresse e-mail SMTP
  private static $email_passwd = 'socap123'; // Indiquez votre mot de passe
  private static $host = 'smtp.gmail.com'; // Indiquez l'hôte SMTP au besoin

  public static function sendMail($destination, $sujet, $contenu) {
    if(filter_var($destination, FILTER_VALIDATE_EMAIL)) {
      if(!empty($contenu) && !ctype_space($contenu)) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = static::$host;
        $mail->SMTPAuth = true;
        $mail->Username = static::$email_source;
        $mail->Password = static::$email_passwd;
        $mail->SMTPSecure = 'tls'; // Changez la sécurité SMTP au besoin
        $mail->Port = 587; // Changez le port SMTP au besoin
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $mail->setFrom(static::$email_source, 'MyGuestHouse');
        $mail->addAddress($destination);
        $mail->Subject = htmlspecialchars($sujet);
        $mail->Body = $contenu;

        if(!$mail->send()) {
          return false;
        } else {
          return true;
        }
      }
    }
  }

}
?>