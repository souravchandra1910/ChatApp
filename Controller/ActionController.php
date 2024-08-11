<?php

require_once  __DIR__ . '/../Helper/Mailer.php';
require_once  __DIR__ . '/../Controller/FieldValidator.php';
require_once  __DIR__ . '/../Model/Operation.php';
require_once  __DIR__ . '/../Core/Dotenv.php';
require_once  __DIR__ . '/../vendor/autoload.php';


// Creating object of Dotenv class.
$env = new Dotenv();

/**
 * Class for controlling all controller actions.
 */
class ActionController {

  private $validator;
  private $operation;

  /**
   * Constructor function to initialise variables and objects.
   */
  public function __construct() {

    // Creating object of validator class.
    $this->validator = new FieldValidator();

    // Creating object of Read class.
    $this->operation = new Operation($_ENV['username'], $_ENV['dbpassword'], $_ENV['dbname']);
  }

  /**
   * Function for Validating user registration.
   *
   * @param string $first_name
   *   User's first name.
   * @param string $last_name
   *   User's last name.
   * @param string $email_id
   *   User's email id.
   * @param string $password
   *   User's password.
   */
  public function validateRegister(
    string $first_name,
    string $last_name,
    string $email_id,
    string $password
  ) {
    // Checking for valid email and password.
    if (
      $this->validator->validateEmail($email_id) &&
      $this->validator->validateName($first_name) &&
      $this->validator->validateName($last_name) &&
      $this->validator->validatePassword($password)
    ) {
      // Checking if email id already registered or not.
      if ($this->operation->UserExist($email_id)) {
        session_start();
        $_SESSION['email_id'] = $email_id;
        $_SESSION['password'] = $password;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        // Sending Otp.
        $this->sendOtp($email_id);
      }
      else {
        echo 'User Exists';
      }
    }
    else {
      echo 'Invalid UserInput';
    }
  }

  /**
   * Function to validate login.
   *
   * @param string $email_id
   *   User's email id.
   * @param string $password
   *   User's password.
   *
   * @return boolean
   *   True if success.
   */
  public function validateLogin(string $email_id, string $password): bool {
    // Checking if email id exists or not and verifying email and password matches or not.
    if (!$this->operation->UserExist($email_id) && $this->operation->isPasswordCorrect($email_id, $password)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to reset password.
   *
   * @param string $email_id
   *   User's email id.
   */
  public function resetPassword(string $email_id) {
    // Checking if email id exists or not.
    if (!$this->operation->UserExist($email_id)) {
      session_start();
      $_SESSION['email_id'] = $email_id;
      // Sending Otp
      $this->sendResetOtp($email_id);
    }
    else {
      echo "Email Id doesn't exists";
    }
  }

  /**
   * Function to send otp for verification
   *
   * @param string $email_id
   *   User's email id.
   */
  public function sendOtp(string $email_id) {
    session_start();
    $OTP = rand(1000, 9999);
    $_SESSION['OTP'] = $OTP;
    // Creating an object of PHP-Mailer to send Otp via Mail.
    $Mail = new Mailer($email_id);
    // Calling class method and passing in the Otp to be send.
    if ($Mail->register($OTP)) {
      require_once __DIR__ . '/../View/otp.php';
    }
  }

  /**
   * Function to send otp for verification
   *
   * @param string $email_id
   *   User's email id.
   */
  public function sendResetOtp(string $email_id) {
    session_start();
    $OTP = rand(1000, 9999);
    $_SESSION['OTP'] = $OTP;
    // Creating an object of PHP-Mailer to send Otp via Mail.
    $Mail = new Mailer($email_id);
    // Calling class method and passing in the Otp to be send.
    if ($Mail->reset($OTP)) {
      require_once __DIR__ . './../View/OtpReset.php';
    }
  }

  /**
   * Function to insert User
   *
   * @param string $first_name
   *   User's first name.
   * @param string $last_name
   *   User's last name.
   * @param string $email_id
   *   User's email id.
   * @param string $password
   *   User's password.
   */

  public function insertIntoUser(
    string $first_name,
    string $last_name,
    string $email_id,
    string $password
  ) {
    $this->operation->insertUser($first_name, $last_name, $email_id, $password);
  }

  /**
   * Function to update user details.
   *
   * @param string $email_id
   *   User's email id.
   * @param string $password
   *   User's password.
   */
  public function updateUser(string $email_id, string $password) {
    $this->operation->resetPassword($email_id, $password);
  }

  /**
   * Function to get user.
   *
   * @param string $Email_id
   *   User's Email.
   *
   * @return array|null
   *   Returns array on success and null on failure.
   */
  public function getUser(string $email_id):array {
    return $this->operation->getUser($email_id);
  }

  /**
   * Function to select user.
   *
   * @param int $user_id
   *   User's id.
   *
   * @return array|null
   *   Returns array on success and null on failure.
   */
   public function selectedUser(int $user_id) {
    return $this->operation->selectedUser($user_id);
  }

  /**
   * Function to select the person to chat.
   *
   * @param string $email_id
   *  User's Email.
   */

  public function selectToChat(string $email_id){
    return $this->operation->selectToChat($email_id);
  }

  /**
   * Function to insert message.
   *
   * @param string $sender_email
   *  Sender's email.
   * @param string $receiver_email
   *   Receiver's email
   * @param string $message
   *   Message to be send.
   */
  public function insertMessage(string $sender_email, string $receiver_email,
   string $message):void {
    $this->operation->insertMessage($sender_email, $receiver_email, $message);
  }

  /**
   * Function to fetch chat.
   *
   * @param string $sender_email
   *  Sender's email.
   * @param string $receiver_email
   *   Receiver's email.
   */
  public function fetchChat(string $sender_email, string $receiver_email){
    return $this->operation->fetchChat($sender_email, $receiver_email);
  }
}
