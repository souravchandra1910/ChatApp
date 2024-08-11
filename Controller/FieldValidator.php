<?php


require_once __DIR__ . '/../Core/Dotenv.php';
require_once __DIR__ . '/../vendor/autoload.php';

$env = new Dotenv();
/**
 * Class for validating user credentials.
 */
class FieldValidator {

  /**
   * Function to validate email.
   *
   * @param string $email
   *   User's email
   * @return boolean
   *   Return true if email is  a valid email
   */
  public function validateEmail(string $email): bool {
     $url = "https://emailvalidation.abstractapi.com/v1/?api_key={$_ENV['api_key']}&email={$email}&auto_correct=false";

    // Calls the API and Decode the response received.
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $data = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($data, TRUE);

    // Validating the format and smtp.
    // If both condition satisfies it prints the email is valid , else it is not.
    if (
      $result['is_valid_format']['value'] &&
      $result['is_smtp_valid']['value']
    ) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to validate password.
   *
   * @param string $password
   *   User's password.
   * @return boolean
   *   Return true if password is valid.
   */
  public function validatePassword(string $password): bool {
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,16}$/';

    if (preg_match($pattern, $password)) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Function to validate name.
   *
   * @param string $name
   *   User's name
   *
   * @return boolean
   *   Returns true if name is valid.
   */
  public function validateName(string $name): bool {
    if (!preg_match("/^[a-z A-z]*$/", $name)) {
      return FALSE;
    }
    return TRUE;
  }
}
