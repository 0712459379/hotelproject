
<?php 



// session_start();
 // $filename= $_GET[user_email];
// $mysqli = mysqli_connect('localhost', 'root', '', 'restaurant');
$json_response = file_get_contents('php://input');
$logfile = "mpesaresponse.txt";
$mpesajson = json_decode($json_response, true);
$log = fopen($logfile, "a");
fwrite($log,$mpesajson);

fclose($log);

// things to do, add a payment status field in the foodorders by includin that in the database design and in the code for entering food

 if(){ 

  $amount_paid_to_saf = $json_response["Body"]["stkCallback"]["CallbackMetadata"]["Item"][0]["Value"];
  $phonenumber_to_check = $json_response["Body"]["stkCallback"]["CallbackMetadata"]["Item"][3]["Value"];
  $sql = "UPDATE foodorders SET payment_status = 'paid' WHERE tel_no='$order_id'"; //this will update the food order  total in the database
  
  $mysqli = mysqli_connect('localhost', 'root', '', 'restaurant');
  mysqli_query($mysqli, $sql);
  
}




// $json=file_get_contents('php://input');/*acquire responsr from safaricom MPESA*/
// $JSON_STRING = '{"Body":{"stkCallback":
//     {"MerchantRequestID":"46431-19418583-1","CheckoutRequestID":"ws_CO_070520211100282805",
//         "ResultCode":0,"ResultDesc":"The service request is processed successfully.",
//         "CallbackMetadata":{"Item":[{"Name":"Amount","Value":1.00},
//         {"Name":"MpesaReceiptNumber","Value":"PE71NZSURN"},{"Name":"TransactionDate","Value":20210507110056},
//         {"Name":"PhoneNumber","Value":254796268817}]}}}}';
// $json_response=json_decode($JSON_STRING,true); // decode json file to readable
// //echo $json_response["Body"]->ResultCode;
// echo $json_response["Body"]["stkCallback"]["ResultCode"];
// echo "<br>";
// if (1 ==1 ){// $json_response["Body"]["stkCallback"]["ResultCode"] == 0
//     if (isset($_SESSION["user_ammount"])) { //when the customer clicks the submit order button
//         if (isset($_SESSION['cart'])) { //checks whether the cart has any existing food items
//           if (!isset($_SESSION['order_id'])) // checks for wether the order_id has been set which will be for the first item not but will be true because of !isset
//           { // if there isn't an order, make new order in orders table and save its id in session array
//             $user_email = $_SESSION['user_email'];
//             $tel_no = $_SESSION['tel_no'];
//             $today = date('Y-m-d : h-i-s');
//             $sql_order = "INSERT INTO foodorders (date, email, tel_no,order_total) VALUES ('$today','$user_email', '$tel_no','')"; //insert in the foodorders tabel the date
//             $result = mysqli_query($mysqli, $sql_order) or die(mysqli_error($mysqli));
//             $order_id = mysqli_insert_id($mysqli); // i think this inserts a primary key or an id to the orderid variable, though am not really sure
//             $_SESSION['order_id'] = $order_id; // assign that id to the session variable order id
//             $order_total = 0; // this will help us incalculating the total ammount spent for that order
//             foreach ($_SESSION['cart'] as $item) { //loop through the session variable then put in food_order_items db
//               $foodid = $item['foodid'];
//               $foodname = $item['foodname'];
//               $quantity = $item['quantity'];
//               $foodprice = $item['foodprice'];
//               $foodprice_total = $item['quantity'] * $item['foodprice']; // this is to ensure we insert the total price for the orded quantity
//               $sql_add_item = "INSERT INTO food_order_items (order_id,email, food_id,food_name,quantity,food_price, foodprice_total ) VALUES ($order_id, '$tel_no','$foodid','$foodname','$quantity','$foodprice', '$foodprice_total')";
//               $query = mysqli_query($mysqli, $sql_add_item) or die(mysqli_error($mysqli));
//               $order_total = $_SESSION["user_ammount"];
//             }
      
//             $sql = "UPDATE foodorders SET order_total = '$order_total' WHERE id='$order_id'"; //this will update the food order  total in the database
//             mysqli_query($mysqli, $sql);
//           } //we have to delete the sessions set so that a person can make a new order without cleosing the browser and refer them to the same page
//           unset($_SESSION['order_id']);
//           unset($_SESSION['cart']);
//           header("Location: food.php");
//         } else {
//           echo "<script>alert('the cart is empty')</script>";
//         }
//       }
// }
// foreach($json_response as $product){
//     //echo $product, "\n";
//     foreach($product as $products){
//         echo $products, "\n";
//     }
// }


// $logFile='../mpesalogs/testing.txt';
// $log=fopen($logFile,"a");
// fwrite($log,$json);
// fclose($log);


// https://github.com/movetechke/mpesa
// https://www.movesms.co.ke/tag/lipa-na-mpesa-online-checkout/

// header("Content-Type: application/json");
// $response = '
// "ResultCode":0,
//  "ResultDesc":"The service request has been accepted successfully.",
// ';

// if (file_get_contents('php://input')){
//     echo "kuna data";
//     var_dump( file_get_contents('php://input'));
// }else {
//     echo "we msi";
// }

// $varname = file_get_contents('php://input');
// $logfile = "mpesaresponse.txt";
// $mpesajson = json_decode($varname, true);
// $log = fopen($logfile, "a");
// fwrite($log,$varname);
// fclose($log)



// $_SESSION['yes'] = $varname;
// print_r($_SESSION['yes']);
// print_r( $varname );

?>
