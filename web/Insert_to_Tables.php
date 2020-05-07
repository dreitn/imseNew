<?php
// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');


// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

$conn = $database->connect();

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
  <br>
  <h1>MAIN USE CASE: CREATE NEW RENT</h1>
  <div>
    <form id='searchform' action='Insert_to_Tables.php' method='post'>
       <p style = "margin-left: 15px;">
           <a href='index.php'>All Locations</a>  |
           <a href='billing.php'>All Bills</a>  |
           <a href='costumers.php'>All Customers</a>  |
           <a href='car.php'>All Cars</a>  |
           <a href="reservations.php">All Reservations</a>  |
           <a href="rent.php">All Rents</a>  |
           <a href='Insert_to_Tables.php'>Insert to Tables</a>
     </p>
    </form>
  </div>
<div>
  <form action='Insert_to_Tables.php' method='get'>
    <p style = "margin-left: 15px;">
    <strong>Insert a new Customer to Database:</strong>
    <p style = "margin-left: 30px;">
  <table style='border: none'>
    <thead>
      <tr>
        <th>Email Address</th>
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
             <input id='email' name='email' type='text', value='<?php $_GET['email'];?>' />
              </p>
                </td>
          <td>
            <p style = "margin-right: 10px;">
             <input id='phone' name='phone' type='number' size='20', value=<?php $_GET['phone']; ?> />
           </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='fname' name='fname' type='text' size='20', value='<?php $_GET['firstname']; ?>' />
                 </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='lname' name='lname' type='text' size='20', value='<?php $_GET['lnamw']; ?>' />
                 </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='locid' name='locid' type="number", value='<?php echo $_GET['locid']; ?>'  />
                 </p>
                </td>
        </tr>
           </tbody>
        </table>
        <input id='submit' type='Submit' value='Insert'>
      </p>
      </p>
  </form>
</div>


<?php
  //inserting
$email = '';
if (isset($_GET['email'])) {
    $email = $_GET['email'];
}

$phone = '';
if (isset($_GET['phone'])) {
    $phone = $_GET['phone'];
}

$fname = '';
if (isset($_GET['fname'])) {
    $fname = $_GET['fname'];
}

$surname = '';
if (isset($_GET['lname'])) {
    $surname = $_GET['lname'];
}

$locid = '';
if (isset($_GET['locid'])) {
    $locid = $_GET['locid'];
}

if (isset($_GET['email'])){
    $sql = $database->insertIntoCostumer($conn, $email, $phone,$fname, $surname, $locid);

}


?>
  <div>
      <form id='insertform2' action='Insert_to_Tables.php' method='get'>
          <p style = "margin-left: 15px;margin-top: 50px;">
              <strong>Insert a new Reservation</strong>
          <p style = "margin-left: 30px;">
              <table style='border: none'>
                  <thead>
                  <tr>
                      <th>Reservation number</th>
                      <th>From Date</th>
                      <th>Return Date</th>
                      <th>Amount</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <td>
          <p style = "margin-right: 10px;">
              <input id='resnr' name='resnr' type='text' size='10' value='<?php echo $_GET['resnr']; ?>' />
          </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='from' name='from' type='text' size='20' value='<?php echo $_GET['from']; ?>' />
              </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='return' name='return' type='text' size='20' value='<?php echo $_GET['return']; ?>' />
              </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='amount' name='amount' type='text' size='20' value='<?php echo $_GET['amount']; ?>' />
              </p>
          </td>
          </tr>
          </tbody>
          </table>
          <input id='submit2' type='submit' value='Insert' />
          </p>
          </p>
      </form>
  </div>


  <?php
  //insert
  $resnr = '';
  if (isset($_GET['resnr'])) {
      $resnr = $_GET['resnr'];
  }

  $from = '';
  if (isset($_GET['from'])) {
      $from = $_GET['from'];
  }

  $return = '';
  if (isset($_GET['return'])) {
      $return = $_GET['return'];
  }

  $amount = '';
  if (isset($_GET['amount'])) {
      $amount = $_GET['amount'];
  }

  if (isset($_GET['resnr']))
  {
      $sql = $database->insertIntoReservation($conn, $resnr, $from, $return, $amount);
  }
  ?>

  <div>
      <form id='insertform3' action='Insert_to_Tables.php' method='get'>
          <p style = "margin-left: 15px;margin-top: 50px;">
              <strong>Make a new Rent</strong>
          <p style = "margin-left: 30px;">
              <table style='border: none'>
                  <thead>
                  <tr>
                      <th>Email of Costumer</th>
                      <th>Car number</th>
                      <th>Reservation number</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <td>
          <p style = "margin-right: 10px;">
              <input id='remail' name='remail' type='text' size='10' value='<?php echo $_GET['remail']; ?>' />
          </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='rcar' name='rcar' type='text' size='20' value='<?php echo $_GET['rcar']; ?>' />
              </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='rres' name='rres' type='text' size='20' value='<?php echo $_GET['rres']; ?>' />
              </p>
          </td>
          </tr>
          </tbody>
          </table>
          <input id='submit4' type='submit' value='Insert' />
          </p>
          </p>
      </form>
  </div>


  <?php

  $remail = '';
  if (isset($_GET['remail'])) {
      $remail = $_GET['remail'];
  }

  $rcar = '';
  if (isset($_GET['rcar'])) {
      $rcar = $_GET['rcar'];
  }

  $rres = '';
  if (isset($_GET['rres'])) {
      $rres = $_GET['rres'];
  }

  //insert
  if (isset($_GET['remail']))
  {
      $sql = $database->insertIntoRent($conn,$remail, $rcar, $rres);
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



