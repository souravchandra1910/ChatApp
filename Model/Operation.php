<?php

require_once 'Database.php';

/**
 * Class for Inserting Data into Database.
 */
class Operation extends Database {

  /**
   * Constructor function to initialise objects of the class.
   *
   * @param string $username
   *   User's name.
   * @param string $password
   *   Database password.
   * @param string $dbname
   *   Database name.
   */
  function __construct(string $username, string $dbpassword, string $dbname) {
    parent::__construct($username, $dbpassword, $dbname);
  }

  /**
   * Function to enter data into database.
   *
   * @param string $email_id
   *   User's Email.
   * @param string $user_firstname
   *   User's firstname.
   * @param string $user_lastname
   *   User's lastname.
   * @param string $password
   *   User's password.
   */
  public function insertUser(
    string $first_name,
    string $last_name,
    string $email_id,
    string $password
  ) {
    $sql_insert = $this->getConnection()->prepare("INSERT INTO user
    (first_name,last_name,email_id,password) values (?,?,?,?)");
    $sql_insert->execute([
      $first_name, $last_name,$email_id,
      password_hash($password, PASSWORD_DEFAULT)
    ]);
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
  public function getUser(string $email_id): array {
    $sql_select = $this->getConnection()->prepare("SELECT first_name,last_name from
    user where email_id = ?");
    $sql_select->execute([$email_id]);
    $rows = $sql_select->fetch(PDO::FETCH_ASSOC);
    if (!count($rows)) {
      return null;
    }
    else {
      return $rows;
    }
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
  public function selectToChat(String $email_id): array {
    $sql_select = $this->getConnection()->prepare("SELECT user_id,first_name,last_name,email_id FROM user WHERE email_id!=(?)");
    $sql_select->execute([$email_id]);
    $rows = $sql_select->fetchAll(PDO::FETCH_ASSOC);
    if (!count($rows)) {
      return null;
    }
    else {
      return $rows;
    }
  }

  /**
   * Function to check existance of user.
   *
   * @param string $Email_id
   *   User's Email.
   *
   * @return bool
   *   Returns true on success.
   */
  public function UserExist(string $email_id): bool {
    $sql_select = $this->getConnection()->prepare("SELECT email_id from
    user where email_id = ?");
    $sql_select->execute([$email_id]);
    $rows = $sql_select->fetchAll(PDO::FETCH_ASSOC);
    if (!count($rows)) {
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * Function to check password matching
   *
   * @param string $Email_id
   *   User's email.
   * @param string $Password
   *   User entered password.
   *
   * @return bool
   *   Returns true on success.
   */
  public function isPasswordCorrect(string $email_id, string $password): bool {
    $sql_select = $this->getConnection()->prepare("SELECT * from
    user where email_id = ?");
    $sql_select->execute([$email_id]);
    $rows = $sql_select->fetch(PDO::FETCH_ASSOC);
    if (password_verify($password, $rows['password'])) {
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * Function to reset password.
   *
   * @param string $token
   *   Token send on Email.
   * @param string $Email_id
   *   User's Email.
   * @param string $Password
   *   User's new password.
   *
   * @return bool
   *  Returns true on success.
   */
  public function resetPassword(string $email_id, string $password): bool {
    $update = $this->getConnection()->prepare("UPDATE user
        SET Password = ?
        WHERE email_id = ?");
    $update->execute([password_hash($password, PASSWORD_DEFAULT), $email_id]);
    return true;
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
  string $message) : void {
    $insert = $this->getConnection()->prepare("INSERT
    INTO chat_messages (sender_email, receiver_email, message) VALUES (?,?,?)");
    $insert->execute([$sender_email, $receiver_email, $message]);
  }

  /**
   * Function to fetch chat.
   *
   * @param string $sender_email
   *  Sender's email.
   * @param string $receiver_email
   *   Receiver's email.
   */
  public function fetchChat(string $sender_email, string $receiver_email) {
    $sql_select = $this->getConnection()->prepare(
      "SELECT * FROM chat_messages
        WHERE (sender_email = ? AND receiver_email = ?)
        OR (sender_email = ? AND receiver_email = ?)"
    );
    $sql_select->execute([$sender_email, $receiver_email, $receiver_email, $sender_email]);
    $rows = $sql_select->fetchAll(PDO::FETCH_ASSOC);

    if (count($rows)) {
      return $rows;
    }
    else {
      return null;
    }
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
    $sql_select = $this->getConnection()->prepare(
      "SELECT first_name,last_name,email_id FROM user
        WHERE user_id=?");
    $sql_select->execute([$user_id]);
    $row = $sql_select->fetch(PDO::FETCH_ASSOC);
    return $row;
  }
}
