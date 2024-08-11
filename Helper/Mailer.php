<?php
// Load Composer's autoloader.
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/MailFunctions.php';

// Import PHPMailer classes into the global namespace.
// These must be at the top of your script, not inside a function.
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * A class to Send mail to a user for otp verification.
 */
class Mailer {

  private $email;
  private $mail;
  private $otp;
  /**
   * Function to set mail configurations.
   *
   * @param string $email
   *   User provided email.
   *
   */
  public function __construct($email) {
    $this->email=$email;
    $this->mail = new PHPMailer(true);
  }

  /**
   * Function to sending otp
   *
   * @param integer $otp
   *   Otp generated.
   *
   * @return boolean
   *   Return true on success.
   */
  public function register(int $otp):bool{
    $this->otp=$otp;
    $this->mail->isSMTP();
    setUserData($this->mail);
    try {
      sendMail($this->mail, $this->email);
      // Content.
      sendMailData($this->mail, $this->otp);
      // If mail is send display a success Message.
      $this->mail->send();
      return true;
    }
    catch (Exception $e) {
      echo "$this->email";
      return false;
    }
  }

  /**
   * Function to sending otp
   *
   * @return boolean
   *   Return true on success.
   */
  public function sendBill():bool{
    $this->mail->isSMTP();
    setUserData($this->mail);
    try {
      sendMail($this->mail, $this->email);
      // Content.
      sendMailWithPdf($this->mail);
      // If mail is send display a success Message.
      $this->mail->send();
      return true;
    }
    catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
      return false;
    }
  }

  /**
   * Function to sending otp
   *
   * @param integer $otp
   *   Otp generated.
   */
  public function reset(int $otp){
    $this->otp=$otp;
    $this->mail->isSMTP();
    setUserData($this->mail);
    try {
      sendMail($this->mail, $this->email);
      // Content.
      sendMailDataToken($this->mail, $this->otp);
      // If mail is send display a success Message.
      $this->mail->send();
      return TRUE;
    }
    catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
      return FALSE;
    }
  }
}
