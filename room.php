<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}


$mysqli = mysqli_connect('localhost', 'root', '', 'restaurant');

$sql = "SELECT * FROM rooms WHERE room_type='Single' AND room_status='Available'";
$result = mysqli_query($mysqli, $sql);


$sql = "SELECT * FROM rooms WHERE room_type='Double' AND room_status='Available'";
$res = mysqli_query($mysqli, $sql);



$sql = "SELECT * FROM rooms WHERE room_type='Master' AND room_status='Available'";
$rest = mysqli_query($mysqli, $sql);


// checking session and adding none exists
if (isset($_POST['book'])) {

  if (isset($_SESSION['room_cart'])) {

    $item_array_id = array_column($_SESSION['room_cart'], "room_id");
    if (in_array($_POST['room_id'], $item_array_id)) {
      echo "<script>alert('Room already added in the cart..!')</script>";
      echo "<script>window.location = 'room.php'</script>";
    } else {
      $count = count($_SESSION['room_cart']);
      $item_array = array(
        'room_id' => $_POST['room_id'],
        'room_name' => $_POST['room_name'],
        'room_price' => $_POST['room_price']
      );

      $_SESSION['room_cart'][$count] = $item_array;
    }
  } else {
    $item_array = array(
      'room_id' => $_POST['room_id'],
      'room_name' => $_POST['room_name'],
      'room_price' => $_POST['room_price']
    );
    $_SESSION['room_cart'][0] = $item_array;
  }
}

if (isset($_POST['submitbook'])) {
  // $room_id = $_GET['room_id'];
  //   $sql = "SELECT FROM rooms_ordered WHERE room_id = '$room_id'";
  //   $result = mysqli_query($mysqli,$sql);
  //   if($result){
  //     if(mysqli_num_rows($result) > 0)
  //     header("location:room.php?room already booked");
  //   }else{


  if (!isset($_SESSION['room_order_id'])) {
    $emailuser = $_SESSION['user_email'];

    $date = date('Y/m/d  h:i:s');
    $date_in = $_POST['date_in'];
    $date_out = $_POST['date_out'];
    $sql_order = "INSERT INTO room_orders (emailuser,date,date_in,date_out) VALUES ('$emailuser','$date','$date_in','$date_out')";
    $result = mysqli_query($mysqli, $sql_order) or die(mysqli_error($mysqli));
    $room_order_id = mysqli_insert_id($mysqli);
    $_SESSION['room_order_id'] = $room_order_id;
    $order_total = 0;
    foreach ($_SESSION['room_cart'] as $item) {
      $room_id = $item['room_id'];
      $emailuser = $_SESSION['user_email'];
      $room_name = $item['room_name'];
      $room_price = $item['room_price'];
      $roomprice_total = $item['room_price'];
      $sql_add_item = "INSERT INTO rooms_ordered (room_order_id,email,room_id,room_name,room_price,roomprice_total ) VALUES ('$room_order_id','$emailuser','$room_id','$room_name','$room_price', '$roomprice_total')";
      $query = mysqli_query($mysqli, $sql_add_item) or die(mysqli_error($mysqli));
      $order_total = $order_total + $roomprice_total;
    }

    $sql = "UPDATE room_orders SET order_total = '$order_total' WHERE id='$room_order_id";
    mysqli_query($mysqli, $sql);
  }
  // if(($date_out - $date_in)==0){
  //   $sql = "UPDATE room_orders SET order_status='Inactive'";
  //   mysqli_query($mysqli,$sql);
  // }
  unset($_SESSION['room_order_id']);
  unset($_SESSION['room_cart']);
  header("Location:room.php");
}
//  else {
//     echo "<script>alert('the cart is empty')</script>";
// }
// }
// }




// delting an item from the cart
if (isset($_POST['delete'])) {
  $room_id = $_POST['delete'];

  if (count($_SESSION['room_cart']) > 0) {
    foreach ($_SESSION['room_cart'] as $room => $val) {
      // if($room['room_id']== $room_id){
      if (($_SESSION['room_cart'][$room]['room_id'] == $room_id))
        unset($_SESSION['room_cart'][$room]);
      header("Location: room.php");
    }
  }
  //  if($_SESSION['room_cart'][0]['room_id'] == $room_id ){
  //   unset($_SESSION['room_cart'][0]);
  //   header("Location: room.php");
  //  }
}

// clearing the entire cart
if (isset($_POST['emptycart'])) {

  unset($_SESSION['book_id']);
  unset($_SESSION['room_cart']);
  header("Location: room.php");
}


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/rooms.css">
  <link rel="stylesheet" href="restaurant.css">
  <link rel="stylesheet" href="assets/styles/nav_home.css">
  <link rel="stylesheet" href="assets/style.css">
  <link rel="stylesheet" href="fontawesome/css/all.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.css">
  <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
  <title>E-Hotel rooms</title>

  <style>
    /* .form-control {
	background-color: #2d2d2d;
	height: 50px;
	padding: 0px 20px;
	border: none;
	-webkit-box-shadow: none;
	box-shadow: none;
	border-radius: 0px;
	color: #fff;
}
.form-group {
	position: relative;
	margin-bottom: 40px;
} */
  </style>
</head>

<body>

  <body data-spy="scroll" data-target="#navbarNav">
    <!-- navigation -->
    <!-- <div id="home_page"> -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
      <a class="navbar-brand" href="#">E-HOTEL</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="food.php">Restaurant</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="room.php">Rooms</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Reservations</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-danger" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- navigation end -->

    <!-- button to open modal-->

    <div>
      
      <button type="button" class="btn shopcart bg-dark" data-toggle="modal" data-target="#myModal">
        <span style="font-size: 2em; color: Tomato;"><i class="fas fa-shopping-cart"></i></span><?php if (isset($_SESSION['room_cart'])) {
                                                                                                  echo count($_SESSION['room_cart']);
                                                                                                } else {
                                                                                                  echo 0;
                                                                                                } ?>
      </button>
    </div>

    <!-- end button to open modal -->

    <!-- modal start -->
    <div class="modal" id="myModal">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">

          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Order Cart</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- modal body -->
          <div class="modal-body">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-dark table-hover">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Room name</th>
                    <th>Price</th>
                    <th>DateIn</th>
                    <th>DateOut</th>
                    <th>Action</th>
                    <th>Total</th>
                  </tr>
                </thead>

                <tbody>
                  <?php

                  if (!empty($_SESSION['room_cart'])) { // if the cart have one item or more loop in it and make a list of items in cart

                    $total = 0;
                    foreach ($_SESSION['room_cart'] as $item) {
                  ?>
                      <tr>
                        <td><?php echo $item['room_id']; ?></td>
                        <td><?php echo $item['room_name']; ?> </td>
                        <td><?php echo $item['room_price']; ?></td>
                        <td></td>
                        <td></td>
                        <form action="" method="post">
                          <td><button class="btn btn-danger" name="delete" value="<?php echo $item['room_id']; ?>">Remove</button></td>
                        </form>
                      </tr>
                      <?php $total += $item['room_price']; ?>

                  <?php  }
                  } ?>



                  <tr>
                    <th>#</th>
                    <th colspan="4"><B>Total</B></th>
                    <th>
                      <form action="" method="post">
                        <input type="submit" name="emptycart" class="btn btn-danger" value="Empty cart">
                      </form>
                    </th>
                    <th><?php echo (@$total) ? $total : '0'; ?>Ksh</th>
                  </tr>

                </tbody>
                <tfoot>
                  <!-- <div class="panel-body btn-group btn-group-justified"> -->
                  <th>
                    <div class="panel-footer">
                      <div class="btn-group col-md-4" role="group">
                        <form action="" method="post">


                          <!-- </form> -->

                      </div>
                  <th></th>
                  <th></th>


              </div>
            </th>
            <!-- </div> -->
            </tfoot>
            </table>
            </div>
          </div>

          <?php if (empty($_SESSION['room_cart'])) {
            echo "  <p class='text-danger text-center'> shopping cart empty, please insert items !</p>";
          } ?>
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
            <div class="btn-group col-md-4" role="group">
             <form>
                  <th><input type="date" name="date_in" required></th>
                <th><input type="date" name="date_out" required></th>
                <th><input type="submit" name="submitbook" class="btn btn-success" value="Book Now"></th>
            </form>
                  </div>
            <!-- lipa na mpesa -->


          </div>
          <div class="btn-group col-md-4" role="group">

            <button type="button" class="btn btn-warning" data-dismiss="modal">Add more</button>
          </div>


        </div>
      </div>
    </div>

    <!-- modal end -->


    <div class="cards">
      <!-- <div class="container"> -->
      <div class="page-header text-center">
        <h2>Our Special rooms</h2>
      </div>
      <h4 class="sub-title">Single rooms</h4>
      <div class="row text-center mx-3">
        <?php
        while ($rows = $result->fetch_assoc()) {
        ?>
          <div class="col-sm-6 col-md-3 mb-4">

            <div class="card">
              <img src="<?php echo  'room_images/' . $rows['name']; ?>" alt="">
              <div class="card-block">
                <h3 class="card-title"><?php echo $rows['room_price']; ?> Ksh/Night</h3>
                <p class="card-text"><?php echo $rows['room_details']; ?></p>
              </div>
              <div class="btn-wrap">
                <form action="" method="post">
                  <input type="hidden" name="room_id" value=" <?php echo $rows["room_id"]; ?>">
                  <input type="hidden" name="room_name" value=" <?php echo $rows["room_name"]; ?>">
                  <input type="hidden" name="room_price" value="<?php echo $rows["room_price"]; ?>">

                  <button class="btn btn-warning" type="submit" name="book">Book Now</button>
                </form>
              </div>


            </div>
          </div>
        <?php
        }
        ?>
      </div>
      <h4 class="sub-title space-left">Double rooms</h4>
      <div class="row text-center mx-3">
        <?php
        while ($rows = $res->fetch_assoc()) {

        ?>
          <div class="col-sm-6 col-md-3 mb-4">
            <div class="card">
              <img src="<?php echo  'room_images/' . $rows['name']; ?>" alt="">
              <div class="card-block">
                <h3 class="card-title"><?php echo $rows['room_price']; ?> Ksh/Night</h3>
                <p class="card-text"><?php echo $rows['room_details']; ?></p>
              </div>
              <div class="btn-wrap">
                <form action="" method="post">
                  <input type="hidden" name="room_id" value=" <?php echo $rows["room_id"]; ?>">
                  <input type="hidden" name="room_name" value=" <?php echo $rows["room_name"]; ?>">
                  <input type="hidden" name="room_price" value="<?php echo $rows["room_price"]; ?>">

                  <button class="btn btn-warning" type="submit" name="book">Book Now</button>
                </form>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
      <h4 class="sub-title space-left">Master rooms</h4>
      <div class="row text-center mx-3">
        <?php
        while ($rows = $rest->fetch_assoc()) {

        ?>
          <div class="col-sm-6 col-md-3 mb-4">
            <div class="card">
              <img src="<?php echo  'room_images/' . $rows['name']; ?>" alt="">
              <div class="card-block">
                <h3 class="card-title"><?php echo $rows['room_price']; ?> Ksh/Night</h3>
                <p class="card-text"><?php echo $rows['room_details']; ?></p>
              </div>
              <div class="btn-wrap">
                <form action="" method="post">
                  <input type="hidden" name="room_id" value=" <?php echo $rows["room_id"]; ?>">
                  <input type="hidden" name="room_name" value=" <?php echo $rows["room_name"]; ?>">
                  <input type="hidden" name="room_price" value="<?php echo $rows["room_price"]; ?>">

                  <button class="btn btn-warning" type="submit" name="book">Book Now</button>
                </form>
              </div>
            </div>
          </div>
        <?php
        }
        ?>
      </div>
    </div>
    </div>

    <a name="contact"></a>
    <footer>
      <div class="container">
        <div class="row">

          <!-- map -->
          <div class="col-lg-6 col-md-4 col-sm-6">
            <h6 class="heading7">Location</h6>
            <!-- <div class="fb-page" data-href="#" data-tabs="timeline"
                     data-small-header="true" data-width="270px" data-hide-cover="true"
                     data-height="260px"
                     data-show-facepile="true"> -->
            <div class="map">
              <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d63836.29718747875!2d35.25924610487084!3d0.2861153465582143!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x1780f4719c503e4b%3A0x7b41a26061f36e5!2sAdministration%20Block%2C%20Moi%20University%20Main%20Campus%2C%20Academic%20Highway!3m2!1d0.28611539999999996!2d35.2942657!5e0!3m2!1sen!2ske!4v1613163955878!5m2!1sen!2ske" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
          </div>

          <!-- comment form     -->
          <div class="col-lg-6 col-md-4 col-sm-6">
            <div class="container">
              <!-- replace with PHP script URL -->
              <form action="#" method="POST" target="_blank">
                <h6 class="heading7">Comments</h6>

                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text bg-white"><i class="fa fa-user"></i>&nbsp</span>
                    </div>
                    <input name="name" type="text" placeholder="Name" class="form-control border-left-0" required>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white"><i class="fa fa-envelope"></i></span>
                        </div>
                        <input name="email" type="email" placeholder="Email" class="form-control border-left-0" required>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <div class="form-group">
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text bg-white"><i class="fa fa-phone"></i></span>
                        </div>
                        <input name="phone" type="tel" placeholder="Phone" class="form-control border-left-0" required>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <textarea class="form-control" id="message" rows="4" placeholder="Enter message" required></textarea>
                </div>

                <button type="submit" class="btn btn-primary float-md-left">
                  <i class="fa fa-paper-plane"></i> Send</button>
              </form>
            </div>
          </div>

          <!-- contact info -->
          <div class="col-lg-6 col-md-4 col-sm-6 footerleft ">
            <h6 class="heading7">Contacts</h6>
            <p itemprop="address" itemscope itemtype="E-HOTEL"><i class="fa fa-map-pin"></i>
              <span itemprop="streetAddress">Eldoret,Kenya</span>
            </p>
            <p><i class="fa fa-phone"></i> Phone (Kenya) :
              <span itemprop="telephone"><a href="tel:+(254) 712345678" class="fields" title="E-HOTEL"> +(254) 712345678</a></span>
            </p>
            <p><i class="fa fa-envelope"></i> E-mail :
              <span itemprop="email"><a href="mailto:ehotel@gmail.com" class="fields" title="E-Hotel">ehotel@gmail.com</a></span>
            </p>

            <span itemprop="openingHoursSpecification" itemscope itemtype="#">
              <p><i class="fa fa-calendar" aria-hidden="true"></i>
                Work Days:<span itemprop="dayOfWeek" itemscope itemtype="#">
                  <span itemprop="name">OPEN ALL WEEK 24/7</span></span>
              </p>
            </span>
          </div>

          <!-- links -->
          <div class="col-lg-6 col-md-4 col-sm-6">
            <h6 class="heading7">Links</h6>
            <ul class="footer-ul">
              <li><a href="#" title="Book a room"></i>ACCOMODATION</a></li>
              <li><a href="#" title="Order food"></i>RESTAURANT</a></li>
              <li><a href="#" title="Make reservation"></i>RESERVATIONS</a></li>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>

    <div class="copyright">
      <div class="container">
        <div class="col-md-12 col-sm-12">
          <p>© 2021 - All Rights with <a href="#">E_HOTEL PROJECT</a> | DAN|VIC|KEV</p>
        </div>
      </div>
    </div>
    <script src="bootstrap/jquery/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="bootstrap/popper/popper.min.js"></script>
  
  </body>

</html>