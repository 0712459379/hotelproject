 <?php 
 require_once "db_connect.php";

if (isset($_POST['reset-password'])) {
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    // ensure that the user exists on our system
    $query = "SELECT email FROM users WHERE email='$email'";
    $results = mysqli_query($mysqli, $query);
    ///dont forget to check whether they have input the meal, check for error
    if(mysqli_num_rows($results) <= 0) {
       var_dump('no such email');
       exit();
      }
  
    
    // generate a unique random token of length 100
    $token = bin2hex(random_bytes(50));
  
  
      // store token in the password-reset database table against the user's email
      $sql = "INSERT INTO password_resets(email, token) VALUES ('$email', '$token')";
      $results = mysqli_query($mysqli, $sql);


      //send email
      $to = $email;
      $subject = "Reset your password on examplesite.com";
      $msg = "Hi there, click on this <a href=\"reset-password.php?token=" . $token . "\">link</a> to reset your password on our site";
      $msg = wordwrap($msg,70);
      $headers = "From: info@examplesite.com";
      mail($to, $subject, $msg, $headers);



      //end of stop email
      header('location: reset-password.php?token=".$token .');
  
      // Send email to user with the token in a link they can click on
    //   $to = $email;
    //   $subject = "Reset your password on examplesite.com";
    //   $msg = "Hi there, click on this <a href=\"reset_password.php?token=" . $token . "\">link</a> to reset your password on our site";
    //   $msg = wordwrap($msg,70);
    //   $headers = "From: info@examplesite.com";
    //   mail($to, $subject, $msg, $headers);
    //   header('location: pending.php?email=' . $email);
    
  }




?> 
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset PHP</title>
	<link rel="stylesheet" href="main.css">
</head>
<body>
	<form class="login-form" action="enter_email.php" method="post">
		<h2 class="form-title">Reset password</h2>
		

		<div class="form-group">
			<label>Your email address</label>
			<input type="email" name="email">
		</div>
		<div class="form-group">
			<button type="submit" name="reset-password" class="login-btn">Submit</button>
		</div>
	</form>
</body>
</html>