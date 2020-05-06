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
if (isset($_GET['email'])) {
    $sql = "SELECT EMAIL FROM COSTUMER". $_GET['email'];
}
else {
    $sql = "SELECT * FROM COSTUMER".$_GET['email'];
}

$phone = '';
if (isset($_GET['phone_number'])) {
    $phone = $_GET['phone_number'];
}

$fname = '';
if (isset($_GET['firstname'])) {
    $fname = $_GET['firstname'];
}

$surname = '';
if (isset($_GET['surname'])) {
    $surname = $_GET['surname'];
}

$locid = '';
if (isset($_GET['locationid'])) {
    $locid = $_GET['locationid'];
}

//Fetch data from database
$costumer_array = $database->selectAllCostumers($conn, $email, $phone, $fname, $surname, $locid);

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
    <form id='searchform' action='customers.php' method='get'>
        <p style = "margin-left: 15px;">
            <a href='index.php'>All Locations</a> ---
            <a href='billing.php'>All Bills</a>---
            <a href='customers.php'>All Customers</a>---
            <a href='car.php'>All Cars</a>---
            <a href='rent.php'>New Rent</a>---
        </p>
        <p style = "display:none">
            <input id='email' name='email' type=String value='<?php echo $_GET['email']; ?>' />
        </p>
    </form>
</div>
<?php
// check if search view of list view

if (isset($_GET['search'])) {
    $sql = "SELECT * FROM COSTUMER WHERE EMAIL =  '" . $_GET['search'] . "'";
}
else{
    $sql = "SELECT * FROM COSTUMER JOIN LOCATIONS L on COSTUMER.LOCATIONID = L.LOCATION_ID";
}

// execute sql statement
$stmt = mysqli_query($conn,$sql);
?>
<table class="table table-bordered table-hovered dt-responsive nowrap" id="myTable" >
    <thead>
    <tr>
        <th>Customer Email</th>
        <th>Phone number</th>
        <th>Name</th>
        <th>Lastname</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // fetch rows of the executed sql query
    while ($row = mysqli_fetch_array($stmt)) {
        echo "<tr>";
        echo "<td>" . $row['EMAIL'] . "</td>";
        echo "<td>" . $row['PHONE_NUMBER'] . "</td>";
        echo "<td>" . $row['FIRStNAME'] . "</td>";
        echo "<td>" . $row['SURNAME'] .  "</td>";
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



