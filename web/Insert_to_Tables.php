<?php
// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

const username = "user";
const password = "user";
const hostname = 'mariadb';
const db = "db";

$conn = mysqli_connect(hostname, password, username, db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();


$email = '';
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

$phone = '';
if (isset($_POST['phone_number'])) {
    $phone = $_POST['phone_number'];
}

$fname = '';
if (isset($_POST['firstname'])) {
    $fname = $_POST['firstname'];
}

$surname = '';
if (isset($_POST['surname'])) {
    $surname = $_POST['surname'];
}

$locid = '';
if (isset($_POST['locationid'])) {
    $locid = $_POST['locationid'];
}


$billnr = '';
if (isset($_POST['billnr'])) {
    $billnr = $_POST['billnr'];
}

$total = '';
if (isset($_POST['total'])) {
    $total = $_POST['total'];
}

$date = '';
if (isset($_POST['date '])) {
    $date = $_POST['date '];
}

$c_mail = '';
if (isset($_POST['c_mail '])) {
    $c_mail  = $_POST['c_mail '];
}


?>


<html>
<head>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

</head>
<body>
  <style>
</style>
  <div>
    <form id='searchform' action='Insert_to_Tables.php' method='get'>
       <p style = "margin-left: 15px;">
           <a href='index.php'>All Locations</a> ---
           <a href='billing.php'>All Bills</a>---
           <a href='costumers.php'>All Customers</a>---
           <a href='car.php'>All Cars</a>---
           <a href="reservations.php">All Reservations</a>---
           <a href='Insert_to_Tables.php'>Insert to Tables</a>---
     </p>
      <p style = "display:none">
      </p>
    </form>
  </div>
<div>
  <form id='insertform' action='Insert_to_Tables.php' method='get'>
    <p style = "margin-left: 15px;">
    <strong>Insert a new Customer to Database:</strong>
    <p style = "margin-left: 30px;">
  <table style='border: none'>
    <thead>
      <tr>
        <th>Email Adress</th>
        <th>Phone Number</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Location</th>
      </tr>
    </thead>
    <tbody>
       <tr>
        <td>
          <p style = "margin-right: 10px;">
             <input id='email' name='email' type='text' value='<?php echo $_GET['EMAIL']; ?>' />
              </p>
                </td>
          <td>
            <p style = "margin-right: 10px;">
             <input id='phone' name='phone' type='text' size='20' value='<?php echo $_GET['PHONE_NUMBER']; ?>' />
           </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='fname' name='fname' type='text' size='20' value='<?php echo $_GET['FIRSTNAME']; ?>' />
                 </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='lname' name='lname' type='text' size='20' value='<?php echo $_GET['SURNAME']; ?>' />
                 </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='loc' name='loc' type=int value='<?php echo $_GET['LOCATIONID']; ?>' />
                 </p>
                </td>
        </tr>
           </tbody>
        </table>
        <input id='submit' type='submit' value='Insert' />
      </p>
      </p>
  </form>
</div>


<?php
  //Handle insert


  if (isset($_GET['EMAIL']))
  {
      //Handle insert
      if (isset($_GET['EMAIL'])) {
          $sql = $database->insertIntoCostumer($conn, $email, $phone, $fname, $surname, $locid);
  }
  }
?>
<script type="text/javascript">
                $(document).ready(function() {
                $('#myTable').DataTable();
                } );
            </script>
            <script type="text/javascript" src=" https://code.jquery.com/jquery-3.3.1.js "></script>
            <script type="text/javascript" src=" https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js "></script>
            <script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
            <script type="text/javascript" src=" https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js "></script>
            <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
            <script type="text/javascript">
                $('#myTable').DataTable( {
                  colReorder: true
                } );
            </script>
  <head>
<style>
.button {
  display: inline-block;
  border-radius: 4px;
  background-color: #00a6ff ;
  border: none;
  color: #FFFFFF;
  text-align: center;
  font-size: 20px;
  padding: 0px;
  width: 100px;
  height:30px;
  transition: all 0.5s;
  cursor: pointer;
  margin-left: 5px;
  position: absolute;
  top: 5px;
  right: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00AB';
  position: absolute;
  opacity: 0;
  top: 0;
  left: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-left: 25px;
}

.button:hover span:after {
  opacity: 1;
  left: 0;
}
</style>
</head>
<body>

<button class="button" onclick="history.back(-1)"><span>Back </span></button>

</body>
</html>



