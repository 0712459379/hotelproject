<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
$mysqli =  mysqli_connect('localhost', 'root', '', 'restaurant');
 
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = ""; 
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter Email.";
    } else{
        $email = trim($_POST["email"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
        
    } else{
        $password = trim($_POST["password"]);
    }
   
    
    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
      
        $sql = "SELECT user_id, tel_no, email, password FROM users WHERE email = ?";
        //var_dump('here');
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $email);
            
            // Set parameters
           $email = $email;
           
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    
                    $stmt->bind_result($user_id, $tel_no, $email, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            
                            $_SESSION["user_email"] = $email; 
                            $_SESSION["tel_no"] = $tel_no;                             
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    // Close connection
    $mysqli->close();
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
<title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/styles/log.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<div class="log-form">
<div class="container">
    <div class="wrap">
    <div class="login-form-title" style="background-image: url(assets/images/food/8.jpeg);">
        <span class="login-form-title-1">Login here</span>
            </div>
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="wrap-input validate-input m-b-">
            <span class="label-input">Email</span>
                <input type="email" name="email" class="form-control  <?php echo (!empty($email_err)) ? 'border border-danger ' : ''; ?>" value="<?php echo $email; ?>">
                <span class="focus-input"><?php echo $email_err; ?></span>
            </div>    
            <div class="wrap-input validate-input m-b-26 ">
            <span class="label-input">Password</span>
                <input type="password" name="password" class="form-control<?php echo (!empty($password_err)) ? ' border border-danger' : ''; ?>">
                <span class="focus-input"><?php echo $password_err; ?></span>
            </div>
            <div class="container-login-form-btn">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>  
    </div>
    </div>  
    <script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
   <script src="bootstrap/js/bootstrap.min.js"></script> 
   <script src="bootstrap/js/bootstrap.js"></script> 
</body>
</html>