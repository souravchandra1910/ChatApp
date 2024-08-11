<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
  <div class="outer-box">
    <div class="inner-box">
      <header class="signup-header">
        <h1>Signup</h1>
      </header>
      <main class="signup-body">
        <p id="msg" class=<?= $cls ?>><?= $msg ?></p>
        <form action="" method="post" id='register-form'>
          <p>
            <label for="firstname">First Name</label>
            <input type="text" id="first_name" name="first_name" placeholder="Enter your First name" pattern="\b([A-Z][a-z. ]+[ ]*)+" required>
          </p>
          <p>
            <label for="lastname">Last Name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Enter your Last name" pattern="\b([A-Z][a-z. ]+[ ]*)+" required>
          </p>
          <p>
            <label for="email">Your Email</label>
            <input type="email" id="email_id" name="email_id" placeholder="email@gmail.com" required>
          </p>
          <p>
            <label for="password">Your New Password</label>
            <input type="password" id="password" name="password" placeholder="at least 8 characters" required>
          </p>
          <p>
            <input type="submit" id="submit" name="submit" value="Create Account">
          </p>
        </form>
      </main>
      <footer class="signup-footer">
        <p>Already have an Account? <a href="/">Login</a> </p>
      </footer>
    </div>
    <div class="circle c1"></div>
    <div class="circle c2"></div>
  </div>
  <script src='script/ajax.js'></script>
</body>

</html>
