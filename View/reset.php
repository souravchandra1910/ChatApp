<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <div class="outer-box">
    <div class="inner-box">
      <header class="signup-header">
        <h1>Reset</h1>
      </header>
      <main class="signup-body">
        <p id="msg" class=<?= $cls ?>><?= $msg ?></p>
        <form method="post" id='reset-form'>
          <p>
            <label for="email">Your Email</label>
            <input type="email" id="email_id" name="email_id" placeholder="email@gmail.com" required>
          </p>
          <p>
            <input type="submit" id="submit" name="submit" value="submit password">
          </p>
        </form>
        <footer class="signup-footer">
          <p>Don't have an Account? <a href="/register">signup</a></p>
        </footer>
    </div>
    <div class="circle c1"></div>
    <div class="circle c2"></div>
  </div>
  <script src='script/ajax.js'></script>
</body>

</html>
