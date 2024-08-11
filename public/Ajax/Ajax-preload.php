<?php

session_start();

require_once __DIR__ . '/../../Controller/ActionController.php';

// // Creating object of ActionController class.
$action = new ActionController();
$user = $action->getUser($_SESSION['email_id']);
$rows = $action->selectToChat($_SESSION['email_id']);
?>
<div class="container">
  <div class="header">
    <h1>My Account</h1>
  </div>
  <div class="account-info">
    <div class="welcome">
      <h2>Welcome, <?= $user['first_name'] . " " . $user['last_name'] ?>!</h2>
    </div>
    <div class="user-list">
      <h2>Select a User to Chat With:</h2>
      <ul>
        <?php
        foreach ($rows as $row) {
        ?>
          <li><a data-userid='<?= $row['user_id'] ?>' class='selected'><?= $row['first_name'] . " " . $row['last_name'] ?></a></li>
        <?php
        }
        ?>
      </ul>
    </div>
  </div>
  <div class="chat-box" id="chat-box">
    <div class="chat-box-header">
      <h2 class='selected-user'><?= $_SESSION['receiver_name']?></h2>
      <button class="close-btn" onclick="closeChat()">✖</button>
    </div>
    <div class="chat-box-body" id="chat-box-body">
      <!-- Chat messages will be loaded here -->
    </div>
    <form class="chat-form" id="chat-form">
      <input type="hidden" id="sender" value="<?= $_SESSION['email_id'] ?>">
      <input type="hidden" id="receiver" value="<?= $_SESSION['receiver_email'] ?>">
      <input type="text" id="message" placeholder="Type your message..." required>
      <button type="submit">Send</button>
    </form>
  </div>
</div>
</div>
