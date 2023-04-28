
<!DOCTYPE html>
<html>
<head>
<style>
table {
  width: 100%;
  border-collapse: collapse;
  background: grey;
}

table, td, th {
  border: 1px solid black;
  padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$q = intval($_GET['q']);
$mysqli = mysqli_connect('localhost', 'root', '', 'restaurant');


if (!$mysqli) {
  die('Could not connect: ');
}


$sql="SELECT * FROM food_order_items WHERE order_id = '".$q."'";
$result = mysqli_query($mysqli,$sql);

echo "<table>
<tr>
<th scope='col-12'>number</th>
<th>food name</th>
<th>quantity</th>
<th>price</th>
<th>price total</th>
</tr>";
while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['id'] . "</td>";
  echo "<td>" . $row['food_name'] . "</td>";
  echo "<td>" . $row['quantity'] . "</td>";
  echo "<td>" . $row['food_price'] . "</td>";
  echo "<td>" . $row['foodprice_total'] . "</td>";
 
  echo "</tr>";
}
echo "</table>";
mysqli_close($mysqli);
?>
</body>
</html>


