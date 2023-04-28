<?php
// Initialize the session
session_start();

?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="fontawesome/css/all.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.css">
    <link rel="stylesheet" href="fontawesome/css/fontawesome.min.css">

    <title>Hotel_home</title>
</head>
<body data-spy="scroll" data-target="#navbarNav">


  <!-- navigation -->
  <div id="home_page">
  <?php
  include 'includes/header.php';
  ?>

  <!-- navigation end -->

   <!-- courosel -->
   <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="6000">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
  </ol>

    <div class="carousel-inner" role="listbox">
          <!-- slide1 -->
    <div class="carousel-item active">
      <img src="admin/img_dir/hotel5.jpg" class="w-100" style="height: 90vh;" alt="First slide">
          <div class="carousel-caption text-center">
          <h1>Welcome to Our Hotel</h1>
          <h5>Thank You For chosing E-Hotel</h5>
          <a class="btn btn-outline-light btn-lg" href="#about"> About Us</a>
      </div>
    </div>
    <div class="carousel-item text-center">
      <img class="w-100" src="assets/image/food1.webp" style="height: 90vh;" alt="Second slide">
          <div class="carousel-caption text-center">
          <h1>RESTAURANT</h1>
          <h5>Hungry? Make orders here</h5>
          <a class="btn btn-outline-light btn-lg" href="restaurant.html"> ORDER NOW</a>
    </div>
    </div>
    <div class="carousel-item text-center">
      <img class="w-100" src="assets/image/bed1.webp" style="height: 90vh;" alt="Third slide">
          <div class="carousel-caption text-center">
          <h1>ROOMS</h1>
          <h5>Tired. Book a room here</h5>
          <a class="btn btn-outline-light btn-lg" href="rooms.html"> BOOK ROOM</a>
          </div>
    </div>
    <div class="carousel-item text-center">
      <img class= "w-100" src="assets/image/swim1.webp" style="height: 90vh;" alt="Forth slide">
          <div class="carousel-caption text-center">
          <h1>RESERVATIONS</h1>
          <h5>To make a reservation</h5>
          <a class="btn btn-outline-light btn-lg" href="#">RESERVE</a>
          </div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon  bg-secondary p-4" style=" border-radius:50%;" aria-hidden="true"></span>
    <span class="sr-only p-4">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon bg-secondary p-4" style=" border-radius:50%;" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
</div>
<!-- home div iishie end carry's nav and carousel -->
</div>
   <!-- courosel end -->

  <section id="services" >
    <div class="container">

        <div class="section-header">
            <h2 class="section-title wow fadeInDown">Our Services<hr class="w-25 mx-auto"> </h2>
            <p class="wow fadeInDown">We offer the following services:</p>
        </div>

        <div class="row">

                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="0ms">
                    <div class="card">
                        <div class="card-img">
                          <img class="img-fluid" src="assets/images/food/13.jpg" style="height: 30vh;"  alt="" >
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Restaurant & Bar</h4>
                            <p>At E-Hotel we have all sorts of nutritious, and delicious meals and drinks prepared for you by the best chefs. Make your order today</p>
                        </div>
                        <div class="btn-wrap">
                            <a href="#" class="btn-buy">Order</a>
                        </div>
                    </div>
                </div><!--/.col-md-4-->

                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="100ms">
                    <div class="card">
                      <div class="card-img">
                        <img class="img-fluid" src="assets/images/rooms/4.jpg" style="height: 30vh;" alt="" >
                      </div>
                        <div class="card-body">
                            <h4 class="card-title">Luxurious Rooms</h4>
                            <p>Book our clean and spacious rooms for a night or days. We have the perfect rooms to suit your needs. Book today</p>
                        </div>
                        <div class="btn-wrap">
                          <a href="#" class="btn-buy">Book</a>
                      </div>
                    </div>
                </div><!--/.col-md-4-->

                <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="300ms" data-wow-delay="200ms">
                    <div class="card">
                      <div class="card-img">
                        <img class="img-fluid" src="assets/image/swim1.webp" style="height: 30vh;" alt="" >
                      </div>
                        <div class="card-body">
                            <h4 class="card-title">Reservation </h4>
                            <p>Get to reserve our swimming pools and conference halls today. </p>
                        </div>
                        <div class="btn-wrap">
                          <a href="#" class="btn-buy">Reserve</a>
                      </div>
                    </div>
                </div><!--/.col-md-4--> 

        </div><!--/.row-->    
    </div><!--/.container-->
</section><!--/#services-->

<!-- aboutus -->
<section id="about">
  <div class="container">

      <div class="section-header">
          <h2 class="section-title wow fadeInDown">About Us<hr class="w-25 mx-auto"></h2>
      </div>

      <div class="row">
          <div class="col-sm-6 wow fadeInLeft">
            <img class="img-fluid" src="assets/images/res.webp" alt="">
          </div>

          <div class="col-sm-6 wow fadeInRight">
              <h3 class="column-title">Our Hotel</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eget risus vitae massa semper aliquam quis mattis quam. Morbi vitae tortor tempus, placerat leo et, suscipit lectus. Phasellus ut euismod massa, eu eleifend ipsum.</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eget risus vitae massa semper aliquam quis mattis quam adipiscing elit. Praesent eget risus vitae massa.Praesent eget risus vitae massa semper aliquam quis mattis quam. Morbi vitae tortor tempus, placerat leo et, suscipit lectus. Phasellus ut euismod massa, eu eleifend ipsum.</p>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eget risus vitae massa semper aliquam quis mattis quam. Morbi vitae tortor tempus, placerat leo et, suscipit lectus. Phasellus ut euismod massa, eu eleifend ipsum.</p>

          </div>
      </div>
    </section><!--/#aboutus-->



<div class="team-boxed">
        <div class="container">
            <div class="intro">
                <h2 class="text-center">Team<hr class="w-25 mx-auto pb-1p"></h2>
                
                <p class="text-center">Nunc luctus in metus eget fringilla. Aliquam sed justo ligula. Vestibulum nibh erat, pellentesque ut laoreet vitae.</p>
            </div>
            <div class="row people">
                <div class="col-md-6 col-lg-4 item">
                    <div class="box h-100"><img class="rounded-circle" src="assets/images/team/mn2.jpg">
                        <h3 class="name">John Doe</h3>
                        <p class="title">Manager</p>
                        <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, et interdum justo suscipit id. Etiam dictum feugiat tellus, a semper massa. </p>
                        <div class="social"><a href="#"><i class="fa fa-facebook-official"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 item">
                    <div class="box h-100" ><img class="rounded-circle w-100" src="assets/images/team/recep.jpg">
                        <h3 class="name">Jane Doe</h3>
                        <p class="title">Receptionist</p>
                        <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, et interdum justo suscipit id. Etiam dictum feugiat tellus, a semper massa. </p>
                        <div class="social"><a href="#"><i class="fa fa-facebook-official"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 item">
                    <div class="box h-100"><img class="rounded-circle" src="assets/images/team/chef.jpg">
                        <h3 class="name">jane john</h3>
                        <p class="title">Chef</p>
                        <p class="description">Aenean tortor est, vulputate quis leo in, vehicula rhoncus lacus. Praesent aliquam in tellus eu gravida. Aliquam varius finibus est, et interdum justo suscipit id. Etiam dictum feugiat tellus, a semper massa. </p>
                        <div class="social"><a href="#"><i class="fa fa-facebook-official"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
                    </div>
                </div>
            </div>
        </div>
</div>

<footer>
    <div class="container" id="foot">
        <div class="row">

          <!-- map -->
            <div class="col-lg-6 col-md-4 col-sm-6">
                <h6 class="heading7">Location</h6>
                     <div class="map">
                     <iframe src="https://www.google.com/maps/embed?pb=!1m23!1m12!1m3!1d63836.29718747875!2d35.25924610487084!3d0.2861153465582143!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0x1780f4719c503e4b%3A0x7b41a26061f36e5!2sAdministration%20Block%2C%20Moi%20University%20Main%20Campus%2C%20Academic%20Highway!3m2!1d0.28611539999999996!2d35.2942657!5e0!3m2!1sen!2ske!4v1613163955878!5m2!1sen!2ske"
                      width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
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
                  <span itemprop="streetAddress">Eldoret,Kenya</span></p>
              <p><i class="fa fa-phone"></i> Phone (Kenya) :
                  <span itemprop="telephone"><a href="tel:+(254) 712345678" class="fields"
                    title="E-HOTEL"> +(254) 712345678</a></span></p>
              <p><i class="fa fa-envelope"></i> E-mail :
                  <span itemprop="email"><a href="mailto:ehotel@gmail.com" class="fields"
                    title="E-Hotel">ehotel@gmail.com</a></span></p>

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
   <script src="bootstrap/js/bootstrap.js"></script> 
</body>
</html>