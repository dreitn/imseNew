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


if (isset($_GET['resnr'])) {
    $sql = "SELECT RESERVATION_NUMBER FROM RESERVATION". $_GET['resnr'];
}
else {
    $sql = "SELECT * FROM RESERVATION".$_GET['resnr'];
}

$resnr = '';
if (isset($_GET['RESERVATION_NUMBER'])) {
    $resnr = $_GET['RESERVATION_NUMBER'];
}

$from = '';
if (isset($_GET['FROM_DATE'])) {
    $from = $_GET['FROM_DATE'];
}

$return = '';
if (isset($_GET['RETURN_DATE'])) {
    $date = $_GET['RETURN_DATE'];
}

$amount = '';
if (isset($_GET['AMOUNT'])) {
    $amount  = $_GET['AMOUNT'];
}

$bill = '';
if (isset($_GET['RESERVATION_BILL_NUMBER'])) {
    $bill  = $_GET['RESERVATION_BILL_NUMBER'];
}

//Fetch data from database
$reservation_array = $database->selectAllReservations($conn, $resnr, $from, $return, $amount, $bill);

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
    <form id='searchform' action='reservations.php' method='get'>
        <p style = "margin-left: 15px;">
            <a href='index.php'>All Locations</a> ---
            <a href='billing.php'>All Bills</a>---
            <a href='costumers.php'>All Customers</a>---
            <a href='car.php'>All Cars</a>---
            <a href="reservations.php">All Reservations</a>---
            <a href='Insert_to_Tables.php'>Insert to Tables</a>---
        </p>
        <p style = "display:none">
            <input id='resnr' name='resnr' type=int value='<?php echo $_GET['resnr']; ?>' />
        </p>
    </form>
</div>
<?php
// check if search view of list view

if (isset($_GET['search'])) {
    $sql = "SELECT * FROM RESERVATION WHERE RESERVATION_NUMBER =  '" . $_GET['search'] . "'";
}

// execute sql statement
$stmt = mysqli_query($conn,$sql);
?>
<table class="table table-bordered table-hovered dt-responsive nowrap" id="myTable" >
    <thead>
    <tr>
        <th>Reservation Number</th>
        <th>From Date</th>
        <th>Return Date</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // fetch rows of the executed sql query
    while ($row = mysqli_fetch_array($stmt)) {
        echo "<tr>";
        echo "<td>" . $row['RESERVATION_NUMBER'] . "</td>";
        echo "<td>" . $row['FROM_DATE'] . "</td>";
        echo "<td>" . $row['RETURN_DATE'] . "</td>";
        echo "<td>" . $row['AMOUNT'] . "</td>";
        echo "</tr>";
    }
    ?>
    </tbody>
</table>
<?php
// clean up connections
mysqli_close($conn);
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
</body>
<head>
    <style>
        .button {
            display: inline-block;
            border-radius: 4px;
            background-color: orangered ;
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



