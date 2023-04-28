<?php
session_start();

$mysqli = mysqli_connect('localhost', 'kimathim_root', '#@Password123#', 'kimathim_restaurant');
if (isset($_POST['add'])) { //check whether the buttton has been added
  // checks whether a cart has been created
  if (isset($_SESSION['cart'])) {

    $item_array_id = array_column($_SESSION['cart'], "foodid"); //looks for the collumn foodid in the cart array and stores it in the variable

    if (in_array($_POST['foodid'], $item_array_id)) { //checks to see whether the cart has been previosly added to the cart
      echo "<script>alert('Product is already added in the cart..!')</script>";
      echo "<script>window.location = 'food.php'</script>";
    } else { //if the food has not been added to the cart 

      $count = count($_SESSION['cart']); //count the length pf the array cart eg if it is 3 items in the array
      $item_array = array( //create a new array with the following items in it
        'foodid' => $_POST['foodid'],
        'foodname' => $_POST['foodname'],
        'foodprice' => $_POST['foodprice'],
        'quantity' => $_POST['quantity']
      );

      $_SESSION['cart'][$count] = $item_array; // this one will add the new array to the cart item at index count which will be the next item eg, if count was 3, then the last item to be added will be at position 3
    }
  } else { //if previously the cart waas empty

    $item_array = array(
      'foodid' => $_POST['foodid'],
      'foodname' => $_POST['foodname'],
      'foodprice' => $_POST['foodprice'],
      'quantity' => $_POST['quantity']
    );

    // Create new session variable
    $_SESSION['cart'][0] = $item_array; /// this item will be at position 0 because it is the first
    //print_r($_SESSION['cart']);
  }
}
if (isset($_POST['submitorder'])) { //when the customer clicks the submit order button

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) { // this will chek whether the user is logged in or not
  header("location: login.php");
  exit;
}
//make sure the user is loggeed in
  if (isset($_SESSION['cart'])) { //checks whether the cart has any existing food items
    if (!isset($_SESSION['order_id'])) // checks for wether the order_id has been set which will be for the first item not but will be true because of !isset
    { // if there isn't an order, make new order in orders table and save its id in session array
      $user_email = $_SESSION['user_email'];
      $tel_no = $_SESSION['tel_no'];
      $today = date('Y-m-d : h-i-s');
      $sql_order = "INSERT INTO foodorders (date, email,tel_no,order_total) VALUES ('$today','$user_email', '$tel_no','0.00')"; //insert in the foodorders tabel the date
      $result = mysqli_query($mysqli, $sql_order) or die(mysqli_error($mysqli));
      $order_id = mysqli_insert_id($mysqli); // i think this inserts a primary key or an id to the orderid variable, though am not really sure
      $_SESSION['order_id'] = $order_id; // assign that id to the session variable order id
      $order_total = 0; // this will help us incalculating the total ammount spent for that order
      foreach ($_SESSION['cart'] as $item) { //loop through the session variable then put in food_order_items db
        $foodid = $item['foodid'];
        $foodname = $item['foodname'];
        $quantity = $item['quantity'];
        $foodprice = $item['foodprice'];
        $foodprice_total = $item['quantity'] * $item['foodprice']; // this is to ensure we insert the total price for the orded quantity
        $sql_add_item = "INSERT INTO food_order_items (order_id,email, food_id,food_name,quantity,food_price, foodprice_total ) VALUES ($order_id, '$tel_no','$foodid','$foodname','$quantity','$foodprice', '$foodprice_total')";
        $query = mysqli_query($mysqli, $sql_add_item) or die(mysqli_error($mysqli));
        $order_total = $order_total + $foodprice_total;
      }


      $sql = "UPDATE foodorders SET order_total = '$order_total' WHERE id='$order_id'"; //this will update the food order  total in the database
      mysqli_query($mysqli, $sql);
    } //we have to delete the sessions set so that a person can make a new order without cleosing the browser and refer them to the same page
    unset($_SESSION['order_id']);
    unset($_SESSION['cart']);
    
    
    // mpesa payment
    
    
 
 $ConsumerKey = 'MLgoQ3U7nbJ7a1F3cU1HmIajhYLGmLeV';
  $ConsumerSecret = 'gS921nWpc2e60z9r';
 

  $Header=['Content-Type:application/json; charset=utf8'];

  $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

  $curl = curl_init($access_token_url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $Header);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($curl, CURLOPT_HEADER, FALSE);
  curl_setopt($curl, CURLOPT_USERPWD, $ConsumerKey.":".$ConsumerSecret);

  $result = curl_exec($curl);
  $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  $Result = json_decode($result);
  $accesstoken = $Result->access_token;
  
  ###---variables---###
  $lipa_url='https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  $BusinessShortCode='174379';
  $Timestamp=date('YmdHis');
  $PartyA=254 . $tel_no;
  $CallBackURL='http://e-hotel.kimathi.me.ke/lipanampesacallback.php';
  $AccountReference='Customer';// clients username
  $TransactionDesc='E-hotel Payment';
  $Passkey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';//your passkey
  $Password=base64_encode($BusinessShortCode.$Passkey.$Timestamp);
  $Amount=$order_total;

  $curl = curl_init();
  curl_setopt($curl, CURLOPT_URL, $lipa_url);
  $lipa_header =['Content-Type:application/json','Authorization:Bearer '.$accesstoken];
  curl_setopt($curl, CURLOPT_HTTPHEADER,$lipa_header); //setting custom header


 $curl_post_data =[
                      //Fill in the request parameters with valid values
                      'BusinessShortCode' => $BusinessShortCode,
                      'Password' => $Password,
                      'Timestamp' => $Timestamp,
                      'TransactionType' => 'CustomerPayBillOnline',
                      'Amount' => $Amount,
                      'PartyA' => $PartyA,
                      'PartyB' => $BusinessShortCode,
                      'PhoneNumber' => $PartyA,
                      'CallBackURL' => $CallBackURL,
                      'AccountReference' => $AccountReference,
                      'TransactionDesc' => $TransactionDesc
                  ];

 $data_string = json_encode($curl_post_data);

 curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($curl, CURLOPT_POST, true);
 curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);

 $curl_response = curl_exec($curl);
//  print_r($curl_response);
//  echo $curl_response;
 
    // end of mpesa payment
  } else {
    echo "<script>alert('the cart is empty please add an item')</script>";
  }
}
//the below code will empty the cart by destroying the session cart that had all the cart items
if (isset($_POST['emptycart'])) {

  unset($_SESSION['order_id']);
  unset($_SESSION['cart']);
  header("Location: food.php");
}
//delete item one from cart
if (isset($_POST['delete_one'])) {
  $one = $_POST['delete_id'];

  unset($_SESSION['cart'][$one]);

  header("Location: food.php");
}






?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="restaurant.css">
  <link rel="stylesheet" href="assets/styles/nav_home.css">
  <link rel="stylesheet" href="fontawesome/css/all.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">

  <style>
    #myBtn {
      display: none;
      position: fixed;
      bottom: 20px;
      right: 30px;
      z-index: 99;
      font-size: 18px;
      border: none;
      outline: none;
      background-color: red;
      color: white;
      cursor: pointer;
      padding: 15px;
      border-radius: 50%;
    }

    #myBtn:hover {
      background-color: #555;
    }

    .shopping {
      text-align: center;
      height: 2em;
      width: 2em;
      border-radius: 50%;
      padding: 10px;
    }

    .shopcart {
      position: fixed;
      top: 50vh;
      border-radius: 5px;

      right: 10px;
      z-index: 99;
     
      color: white;
    }
  </style>

</head>

<body data-spy="scroll" data-target="#navbarNav">

  <!-- navigation -->
  <?php
  include 'includes/header.php';

  ?>
    <!-- search -->
    <div class="input-group my-3  col-xs-3 d-flex justify-content-end" style="position: fixed; z-index: 99;">
    <input type="text" class=" form-inline" id="myInput" onkeyup="myFunction()" placeholder="Search for food..">
    <div class="input-group-append">
      <span class="input-group-text"><i class="fas fa-search"></i>&nbsp Search</span>
    </div>
  </div>
  <!-- end of search -->
    
 
  <!-- button to open modal-->

  <div>
    <!-- Button to Open the Modal -->
    <button type="button" class="btn shopcart bg-dark" data-toggle="modal" data-target="#myModal">
      <span style="font-size: 2em; color: Tomato;"><i class="fas fa-shopping-cart"></i></span><?php if (isset($_SESSION['cart'])) {
                                                                                                echo count($_SESSION['cart']);
                                                                                              } else {
                                                                                                echo 0;
                                                                                              } ?>
    </button>
  </div>

  <!-- end button to open modal -->



  <div class="container-fluid">
    <!-- For demo purpose -->
    <div class="row">
      <div class="col-lg-12 mx-auto">
        <div class=" p-3 mt-3 text-center">
          <h1 class="menu-title shadow-sm rounded banner">Our Menu.</h1>
          <hr>
        </div>
      </div>
    </div>
    <!-- End -->


    <div class="text-center">
      <ul class="breadcrumb">
        <li class="breadcrumb-item active">All Meals</li>
        <li class="breadcrumb-item"><a href="#breakfast">Breakfast</a></li>
        <li class="breadcrumb-item"><a href="#lunch">Lunch</a></li>
        <li class="breadcrumb-item"><a href="#dinner">Supper</a></li>
        <li class="breadcrumb-item"><a href="#snacks">Snacks</a></li>
      </ul>
    </div>
    
      <p id="myfunctionmessage" class="display-4 text-center" style="display: none;" >
      No such food available
      </p>
     
   
    <div id="breakfast" class="px-lg-3">
      <div class="col-lg-12 mx-auto">
        <!-- <h3 class="head_t pb-3">Breakfast</h3> -->
      </div>
      <div class="row">
        <?php

        $sql = "SELECT * FROM foods WHERE food_category = 'breakfast'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = $result->fetch_assoc()) { ?>

          <!-- start -->
          <div class=" fooditem col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-1 border">
            <input type="hidden" name="foodnames" value=" <?php echo $row["food_name"]; ?>">

            <div class="bg-white rounded shadow-sm"><img src="admin/img_dir/<?php echo $row["food_image"]; ?> " alt="" class="img-fluid card-img-top">
              <div class="p-1">
                <div class="row">
                  <div class="col">
                    <h4> <a href="#" class="text-dark text-capitalize"> <?php echo $row["food_name"]; ?></a></h4>
                  </div>
                  <div class="col">
                    <p class="text-right font-weight-bold">Price:<?php echo $row["food_price"]; ?> ksh
                  </div>
                  </p>
                </div>


                <p class="small mb-0 p-1 bg-light lead"><?php echo $row["food_description"]; ?>
                </p>
                <div class="mt-4">
                  <div class="container">
                    <form action="" method="post">


                      <div class="row d-flex justify-content-between ">
                        <div class="">

                          <p>Quantity:
                            <input type="number" style="width:60px;" name="quantity" value="1">
                          </p>

                        </div>
                        <div class="">
                          <button class="btn btn-success" type="submit" name="add">Add to Cart</button>
                        </div>
                      </div>
                      <input type="hidden" name="foodid" value=" <?php echo $row["id"]; ?>">
                      <input type="hidden" name="foodname" value=" <?php echo $row["food_name"]; ?>">
                      <input type="hidden" name="foodprice" value="<?php echo $row["food_price"]; ?>">




                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End -->

        <?php
        }
        ?>


        <div id="lunch" class="col-lg-12 mx-auto">
          <!-- <h3 class="head_t pb-3">Lunch</h3> -->
        </div>

        <?php

        $sql = "SELECT * FROM foods WHERE food_category = 'lunch'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = $result->fetch_assoc()) { ?>
         <!-- start -->
         <div class=" fooditem col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-1 border">
            <input type="hidden" name="foodnames" value=" <?php echo $row["food_name"]; ?>">

            <div class="bg-white rounded shadow-sm"><img src="admin/img_dir/<?php echo $row["food_image"]; ?> " alt="" class="img-fluid card-img-top">
              <div class="p-1">
                <div class="row">
                  <div class="col">
                    <h4> <a href="#" class="text-dark text-capitalize"> <?php echo $row["food_name"]; ?></a></h4>
                  </div>
                  <div class="col">
                    <p class="text-right font-weight-bold">Price:<?php echo $row["food_price"]; ?> ksh
                  </div>
                  </p>
                </div>


                <p class="small mb-0 p-1 bg-light lead"><?php echo $row["food_description"]; ?>
                </p>
                <div class="mt-4">
                  <div class="container">
                    <form action="" method="post">


                      <div class="row d-flex justify-content-between ">
                        <div class="">

                          <p>Quantity:
                            <input type="number" style="width:60px;" name="quantity" value="1">
                          </p>

                        </div>
                        <div class="">
                          <button class="btn btn-success" type="submit" name="add">Add to Cart</button>
                        </div>
                      </div>
                      <input type="hidden" name="foodid" value=" <?php echo $row["id"]; ?>">
                      <input type="hidden" name="foodname" value=" <?php echo $row["food_name"]; ?>">
                      <input type="hidden" name="foodprice" value="<?php echo $row["food_price"]; ?>">




                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End -->

        <?php
        }
        ?>

        <div id="dinner" class="col-lg-12 mx-auto">
          <!-- <h3 class="head_t pb-3">Dinner.</h3> -->
        </div>
        <?php

        $sql = "SELECT * FROM foods WHERE food_category = 'dinner'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = $result->fetch_assoc()) { ?>

         <!-- start -->
         <div class=" fooditem col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-1 border">
            <input type="hidden" name="foodnames" value=" <?php echo $row["food_name"]; ?>">

            <div class="bg-white rounded shadow-sm"><img src="admin/img_dir/<?php echo $row["food_image"]; ?> " alt="" class="img-fluid card-img-top">
              <div class="p-1">
                <div class="row">
                  <div class="col">
                    <h4> <a href="#" class="text-dark text-capitalize"> <?php echo $row["food_name"]; ?></a></h4>
                  </div>
                  <div class="col">
                    <p class="text-right font-weight-bold">Price:<?php echo $row["food_price"]; ?> ksh
                  </div>
                  </p>
                </div>


                <p class="small mb-0 p-1 bg-light lead"><?php echo $row["food_description"]; ?>
                </p>
                <div class="mt-4">
                  <div class="container">
                    <form action="" method="post">


                      <div class="row d-flex justify-content-between ">
                        <div class="">

                          <p>Quantity:
                            <input type="number" style="width:60px;" name="quantity" value="1">
                          </p>

                        </div>
                        <div class="">
                          <button class="btn btn-success" type="submit" name="add">Add to Cart</button>
                        </div>
                      </div>
                      <input type="hidden" name="foodid" value=" <?php echo $row["id"]; ?>">
                      <input type="hidden" name="foodname" value=" <?php echo $row["food_name"]; ?>">
                      <input type="hidden" name="foodprice" value="<?php echo $row["food_price"]; ?>">




                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End -->

        <?php
        }
        ?>


        <div id="snacks" class="col-lg-12 mx-auto">
          <!-- <h3 class="head_t pb-3">Snacks.</h3> -->
          <hr width="6%">
        </div>

        <?php

        $sql = "SELECT * FROM foods WHERE food_category = 'snacks'";
        $result = mysqli_query($mysqli, $sql);
        while ($row = $result->fetch_assoc()) { ?>

         <!-- start -->
         <div class=" fooditem col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-1 border">
            <input type="hidden" name="foodnames" value=" <?php echo $row["food_name"]; ?>">

            <div class="bg-white rounded shadow-sm"><img src="admin/img_dir/<?php echo $row["food_image"]; ?> " alt="" class="img-fluid card-img-top">
              <div class="p-1">
                <div class="row">
                  <div class="col">
                    <h4> <a href="#" class="text-dark text-capitalize"> <?php echo $row["food_name"]; ?></a></h4>
                  </div>
                  <div class="col">
                    <p class="text-right font-weight-bold">Price:<?php echo $row["food_price"]; ?> ksh
                  </div>
                  </p>
                </div>


                <p class="small mb-0 p-1 bg-light lead"><?php echo $row["food_description"]; ?>
                </p>
                <div class="mt-4">
                  <div class="container">
                    <form action="" method="post">


                      <div class="row d-flex justify-content-between ">
                        <div class="">

                          <p>Quantity:
                            <input type="number" style="width:60px;" name="quantity" value="1">
                          </p>

                        </div>
                        <div class="">
                          <button class="btn btn-success" type="submit" name="add">Add to Cart</button>
                        </div>
                      </div>
                      <input type="hidden" name="foodid" value=" <?php echo $row["id"]; ?>">
                      <input type="hidden" name="foodname" value=" <?php echo $row["food_name"]; ?>">
                      <input type="hidden" name="foodprice" value="<?php echo $row["food_price"]; ?>">
                    </form>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- End -->

        <?php
        }
        ?>


      </div>
      <div class="py-5 text-center"><a href="#" class="btn btn-dark px-5 py-3 text-uppercase">More meals on the way</a></div>
    </div>
  </div>

  <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>


  <!-- The Modal -->
  <div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Order Cart</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">


          <table class="table">
            <thead>
              <tr>
                <th>No</th>
                <th>foodname</th>
                <th>price</th>
                <th>quantity</th>

                <th>total</th>
                <th></th>
              </tr>
            </thead>

            <tbody>
              <?php

              if (!empty($_SESSION['cart'])) { // if the cart have one item or more loop in it and make a list of items in cart

                $total = 0;
                $count = 0;
                $cart_item_number = 1;
                foreach ($_SESSION['cart'] as $item) {
              ?>
                  <tr>
                    <td><?php echo $cart_item_number ; ?></td>
                    <td><?php echo $item['foodname']; ?> </td>
                    <td><?php echo $item['foodprice']; ?></td>
                    <td><?php echo $item['quantity'];  ?> </td>

                    <td><?php echo $item['quantity'] * $item['foodprice'];  ?></td>
                    <td>

                      <form action="" method="post">
                        <?php $_SESSION['item_id'] = $count; ?>
                        <input type="hidden" value="<?php echo $count; ?>" name="delete_id">
                        <button type="submit" name="delete_one" style="all:unset; cursor:pointer;"><span><i class="fas fa-times" style="color:red;"></i></span></button>
                      </form>
                      
                      
                    </td>
                   
                  </tr>
                  <?php $total = $total + $item['quantity'] * $item['foodprice']; ?>
         



              <?php $count++;
              $cart_item_number ++;
                }
              } ?>

            </tbody>
            <tfoot>
              <tr>
                <th></th>
               
                <th></th>
                <th></th>
                <th>Total</th>
                <th class="font-weight-bolder border bg-primary text-center "><?php echo (@$total) ? $total : '0'; ?>$</th>
                <th></th>
              </tr>
              
            </tfoot>
          
          </table>
          <?php  if (empty($_SESSION['cart']))  { echo "  <p class='text-danger text-center'> shopping cart empty, please insert items !</p>";} ?>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">

          <div class="btn-group col-md-4" role="group">
            <form action="food.php" method="post">
              <input class="btn btn-danger" type="submit" name="emptycart" value="empty cart">
              <!-- <button type="submit" name="emptycart" class="btn btn-danger" data-dismiss="modal">empty cart</button> -->
            </form>

          </div>
          <div class="btn-group col-md-4" role="group">
                   <!-- lipa na mpesa -->
                   <form action="food.php" method="post">
                        
                      
                        <input type="hidden" value="<?php echo $_SESSION["user_email"] ; ?>" name="user_email">
                        <input type="hidden" value="<?php echo $_SESSION["tel_no"];  ?>" name="user_tel_no">
                          
                        
                        <input type="hidden" value="<?php echo (@$total); ?>" name="user_ammount">
                        <input class="btn btn-success" type="submit" name="submitorder" value="checkout">
                        <!-- <button class="bg-dark" type="submit" name="delete_one" style=" color: white; all:unset; cursor:pointer;"><span>lipa bro shemeji</span></button> -->
                      </form>
<!-- lipa na mpesa -->
            

          </div>
          <div class="btn-group col-md-4" role="group">

            <button type="button" class="btn btn-warning" data-dismiss="modal">Add more</button>
          </div>
<!-- 
          <div id="paypal-button" class="btn-group col-md-4" role="group">
          </div> -->


        </div>
      </div>
    </div>
    <script>
      function myFunction() {
        var input, filter, fooditem, fooditemname, txtValue, myfunctionmessage;
        let  counter=0;

        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        fooditem = document.getElementsByClassName("fooditem");
        myfunctionmessage = document.getElementById("myfunctionmessage");

        fooditemname = document.querySelectorAll('input[name=foodnames]');
        for (let j = 0; j < fooditemname.length; j++) {
          txtValue = fooditemname[j].value;

          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            fooditemname[j].parentElement.style.display = "";
            console.log("iko");
          } else {
            fooditemname[j].parentElement.style.display = "none";
            console.log("haiko");
            counter = counter+1;
            if(counter == fooditemname.length){
             myfunctionmessage.style.display = "block";
              console.log(myfunctionmessage);
              
            }
          
          }
        }



        // ul = document.getElementById("myUL");
        // li = ul.getElementsByTagName("li");
        // for (i = 0; i < li.length; i++) {
        //     a = li[i].getElementsByTagName("a")[0];
        //     txtValue = a.textContent || a.innerText;
        //     if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //         li[i].style.display = "";
        //     } else {
        //         li[i].style.display = "none";
        //     }
        // }
      }
    </script>
    <script>
      //Get the button
      var mybutton = document.getElementById("myBtn");

      // When the user scrolls down 20px from the top of the document, show the button
      window.onscroll = function() {
        scrollFunction()
      };

      function scrollFunction() {
        if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
          mybutton.style.display = "block";
        } else {
          mybutton.style.display = "none";
        }
      }

      // When the user clicks on the button, scroll to the top of the document
      function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
      }
    </script>
    <script src="https://www.paypal.com/sdk/js?client-id=AQ8ypnjAuGwDpsGBfCAys5DX2K7WbpSYnlSISrvm0kRMH1fyJktwCiVd7l_fcLJJWkFZE6aXFrRQ1gpl"></script>
    <script src="payment.js"></script>


    <script src="jQuery-3.3.1/jquery-3.3.1.min.js"></script>

    <script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/popper/popper.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

</body>

</html>