<?php
// Include config file
$mysqli =  mysqli_connect('localhost', 'root', '', 'restaurant');
 
// Define variables and initialize with empty values
$firstname =$secondname = $password = $confirm_password =$email = $tel_no= "";
$firstname_err = $secondname_err= $password_err = $confirm_password_err =$email_err =$tel_no_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate firstname
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter your firstname.";
    } else{
      
            $firstname = trim($_POST["firstname"]);
            
        
    }
    //validate the second name  check whther its only characters
    if(empty(trim($_POST["secondname"]))){
        $secondname_err = "Please enter your secondname.";
    } else{
      
            $secondname = trim($_POST["secondname"]);
            
        
    }
    //validate email
     
     if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    } else{
        // Prepare a select statement
        $sql = "SELECT email FROM users WHERE email = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);
            
            // Set parameters
            $param_email = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email= trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }
    //validate tel_no
    if(empty(trim($_POST["tel_no"]))){
        $tel_no_err = "Please enter your telephone number";
    } else{
        // Prepare a select statement
        $sql = "SELECT tel_no FROM users WHERE tel_no = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_tel_no);
            
            // Set parameters
            $param_tel_no = trim($_POST["tel_no"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $tel_no_err = "This telephone number is already taken.";
                } else{
                    $tel_no= trim($_POST["tel_no"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }




    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    //validate email

    
    // Check input errors before inserting in database
    if(empty($firstname_err)  && empty($secondname_err) && empty($email_err) && empty($tel_no_err) &&   empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (firstname, secondname, email,tel_no, password) VALUES (?,?,?,?,?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sssss",  $param_firstname, $param_secondname, $param_email,  $param_tel_no, $param_password);
            
            // Set parameters
           
            $param_firstname = $firstname;
            $param_secondname= $secondname;
            $param_email = $email;
            $param_tel_no = $tel_no;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
           
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
<title>Sign Up</title>
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
        <span class="login-form-title-1">Sign up here</span>
            </div>
        <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="wrap-input validate-input m-b-26 ">
            <span class="label-input">Firstname</span>
                <input type="text" name="firstname" class="form-control  <?php echo (!empty($firstname_err)) ? 'border border-danger' : ''; ?>" value="<?php echo $firstname; ?>">
                <span class="focus-input"><?php echo $firstname_err; ?></span>
            </div>    
            <div class="wrap-input validate-input m-b-26 ">
            <span class="label-input">Secondname</span>
                <input type="text" name="secondname" class="form-control <?php echo (!empty($secondname_err)) ? 'border border-danger' : ''; ?>" value="<?php echo $secondname; ?>">
                <span class="focus-input"><?php echo $secondname_err; ?></span>
            </div> 
            <div class="wrap-input validate-input m-b-26 ">
            <span class="label-input">Email</span>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'border border-danger' : ''; ?>" value="<?php echo $email; ?>">
                <span class="focus-input"><?php echo $email_err; ?></span>
            </div> 
            <div class="wrap-input validate-input m-b-26">
            <span class="label-input">Tel_num</span>
                <input type="number" name="tel_no" class="form-control <?php echo (!empty($tel_number_err)) ? 'border border-danger' : ''; ?>" value="<?php echo $tel_no; ?>">
                <span class="focus-input"><?php echo $tel_no_err; ?></span>
            </div> 
            <div class="wrap-input validate-input m-b-26 ">
            <span class="label-input">Password</span>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'border border-danger' : ''; ?>" value="<?php echo $password; ?>">
                <span class="focus-input"><?php echo $password_err; ?></span>
            </div>
            <div class="wrap-input validate-input m-b-26 ">
            <span class="label-input">Confirm Pass</span>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'border border-danger' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="focus-input"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="container-login-form-btn">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
    </div>
    </div>  
    <script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
   <script src="bootstrap/js/bootstrap.min.js"></script> 
   <script src="bootstrap/js/bootstrap.js"></script>  
</body>
</html>