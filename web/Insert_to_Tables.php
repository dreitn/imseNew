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
             <input id='email' name='email' type='text', value='email' />
              </p>
                </td>
          <td>
            <p style = "margin-right: 10px;">
             <input id='phone' name='phone' type='number' size='20', value='1234567' />
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
              <input id='resnr' name='resnr' type='text' size='10' value='<?php echo $_POST['RESERVATION_NUMBER']; ?>' />
          </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='from' name='from' type='text' size='20' value='<?php echo $_POST['FROM_DATE']; ?>' />
              </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='return' name='return' type='text' size='20' value='<?php echo $_GET['RETURN_DATE']; ?>' />
              </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='amount' name='amount' type='text' size='20' value='<?php echo $_GET['AMOUNT']; ?>' />
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
  if (isset($_GET['RESERVATION_NUMBER']))
  {
      $sql = $database->insertIntoReservation($conn, $_GET['RESERVATION_NUMBER'], $_GET['FROM_DATE'], $_GET['RETURN_DATE'], $_GET['AMOUNT']);
  }
  ?>

  <div>
      <form id='insertform3' action='Insert_to_Tables.php' method='get'>
          <p style = "margin-left: 15px;margin-top: 50px;">
              <strong>Insert a new Car</strong>
          <p style = "margin-left: 30px;">
              <table style='border: none'>
                  <thead>
                  <tr>
                      <th>Registration number</th>
                      <th>Model</th>
                      <th>Year</th>
                      <th>Price per Day</th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr>
                      <td>
          <p style = "margin-right: 10px;">
              <input id='regnr' name='regnr' type=number size='10' value='<?php echo $_POST['REGISTRATION_NUMBER']; ?>' />
          </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='model' name='model' type='text' size='20' value='<?php echo $_POST['CAR_MODEL']; ?>' />
              </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='year' name='year' type=number size='20' value='<?php echo $_POST['MODEL_YEAR']; ?>' />
              </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='price' name='price' type=number size='20' value='<?php echo $_POST['DAILY_PRICE']; ?>' />
              </p>
          </td>
          </tr>
          </tbody>
          </table>
          <input id='submit3' type='submit' value='Insert' />
          </p>
          </p>
      </form>
  </div>


  <?php
  //insert

  $regnr = '';
  if (isset($_POST['REGISTRATION_NUMBER'])) {
      $regnr = $_POST['REGISTRATION_NUMBER'];
  }

  $model = '';
  if (isset($_POST['CAR_MODEL'])) {
      $model = $_POST['CAR_MODEL'];
  }

  $year = '';
  if (isset($_POST['MODEL_YEAR'])) {
      $year = $_POST['MODEL_YEAR'];
  }

  $price = '';
  if (isset($_POST['DAILY_PRICE'])) {
      $price = $_POST['DAILY_PRICE'];
  }



  ?>

  <div>
      <form id='insertform4' action='Insert_to_Tables.php' method='get'>
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
              <input id='remail' name='remail' type='text' size='10' value='<?php echo $_GET['RENT_EMAIL']; ?>' />
          </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='rcar' name='rcar' type='text' size='20' value='<?php echo $_GET['RENT_CAR']; ?>' />
              </p>
          </td>
          <td>
              <p style = "margin-right: 10px;">
                  <input id='rres' name='rres' type='text' size='20' value='<?php echo $_GET['RENT_RESERVATION']; ?>' />
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
  //insert
  if (isset($_GET['RENT_RESERVATION']))
  {
      $sql = $database->insertIntoRent($conn, $_GET['RENT_EMAIL'], $_GET['RENT_CAR'], $_GET['RENT_RESERVATION']);
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



