<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MY orders</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="restaurant.css">
  <link rel="stylesheet" href="assets/styles/nav_home.css">
  <link rel="stylesheet" href="fontawesome/css/all.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
  <style>

.hide{
  display: none;
}


  </style>
</head>

<body>
<?php  include 'includes/header.php';?>

   <div class="container">
       
       <div class="jumbotron">
           <div class="card">
           <h5 class="cardtitle text-center mt-3">FOOD ORDERS</h5>
                   <div class="card-body">
                   <table class="table table-dark table-hover table-bordered">
                   <caption>My food orders</caption>
                     <thead>
                       <tr>
                         <th scope="col">Order Id</th>
                         
                         <th scope="col">Date</th>
                         <th scope="col">Total Amount</th>
                         <th scope="col">Total Amount</th>
                         
                       </tr>
                     </thead>
                   
                     <tbody>
                     <?php
                     $email = $_SESSION['user_email'];
                $sql = "SELECT * FROM foodorders WHERE email = '$email'";
                $conn = mysqli_connect('localhost', 'root', '', 'restaurant');
                
                $query = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($query)) {; ?>
                  <tr >
                    <td><?php echo $row['id']; ?> </td>
                  
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['order_total'];?></td>
                    <td class="d-flex ">




<button class="btn btn-primary badge-pill" onclick="showOrder(event)" >VIEW</button>



</td>

                   



                      
                      </tr>
                    
                      <td colspan="5">
                     <?php $sql="SELECT * FROM food_order_items WHERE order_id = '".$row['id']."'";
                       $result = mysqli_query($conn, $sql);?>

<table style="width: 100%; color:royalblue; background-color:yellow;">
<tr>
<th>number</th>
<th>food name</th>
<th>quantity</th>
<th>price</th>
<th>price total</th>
</tr>

<?php while($row = mysqli_fetch_array($result)) { ?>
  
<tr>
<td> <?php echo $row['id'] ; ?></td>
<td> <?php echo $row['food_name'] ; ?></td>
<td> <?php echo $row['quantity'] ; ?></td>
<td> <?php echo $row['food_price'] ; ?></td>
<td> <?php echo $row['foodprice_total'] ; ?></td>
 
  </tr>
<?php } ?>
</table>
                      
        </td>
                      
                    
                      <?php }?>
                      
                     </tbody>
                   </table>
                   
                </div>
             </div>
            </div>
     </div>
     <script>
     
function showOrder(e) {
  e.target.parentElement.parentElement.nextElementSibling.classList.toggle("hide");
  
  // e.target.parentElement.parentElement.nextElementSibling.className = "show"
  // if(e.target.parentElement.parentElement.nextElementSibling.style.display == "none"){
 
  //   e.target.parentElement.parentElement.nextElementSibling.style.display = "block";
   
  // }else{
    
  //   e.target.parentElement.parentElement.nextElementSibling.style.display = "none"
  // }



  // if (order_id == "") {
  //   document.getElementById("order_items").;
  //   return;
  // } else {
  //   var xmlhttp = new XMLHttpRequest();
  //   xmlhttp.onreadystatechange = function() {
  //     if (this.readyState == 4 && this.status == 200) {
  //       e.target.parentElement.parentElement.nextElementSibling.innerHTML = this.responseText;
  //     }
  //   };
  //   xmlhttp.open("GET","customer_order.php?q="+order_id,true);
  //   xmlhttp.send();
  // }
}
</script>
   <script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
   <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
