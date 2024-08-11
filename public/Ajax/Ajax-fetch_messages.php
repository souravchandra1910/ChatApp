<?php

require_once __DIR__ . '/../../Controller/ActionController.php';

// Creating object of ActionController class.
$action = new ActionController();

$sender_email = $_POST['sender_email'];
$receiver_email = $_POST['receiver_email'];
$rows = $action->fetchChat($sender_email, $receiver_email);

// Fetch all rows.
foreach ($rows as $row) {
  $user = $action->getUser($row['sender_email'])
?>
    <div class="message"><strong><?= $user['first_name'] ?>:</strong>  <?= $row['message'] ?></div>
<?php
}
