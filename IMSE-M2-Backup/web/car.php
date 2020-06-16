<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();
$conn = $database->connect();



if (isset($_GET['registration_number'])) {
    $sql = "SELECT REGISTRATION_NUMBER FROM CAR". $_GET['registration_number'];
}
else {
    $sql = "SELECT * FROM CAR".$_GET['registration_number'];
}

$regnr = '';
if (isset($_GET['REGISTRATION_NUMBER'])) {
    $regnr = $_GET['REGISTRATION_NUMBER'];
}

$model = '';
if (isset($_GET['CAR_MODEL'])) {
    $model = $_GET['CAR_MODEL'];
}

$year = '';
if (isset($_GET['MODEL_YEAR'])) {
    $year = $_GET['MODEL_YEAR'];
}

$price = '';
if (isset($_GET['DAILY_PRICE'])) {
    $price = $_GET['DAILY_PRICE'];
}

//Fetch data from database
$costumer_array = $database->selectAllCars($conn, $regnr, $model, $year, $price);

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
    <form id='searchform' action='car.php' method='get'>
        <p style = "margin-left: 15px;">
            <a href='index.php'>All Locations</a>  |
            <a href='billing.php'>All Bills</a>  |
            <a href='costumers.php'>All Customers</a>  |
            <a href='car.php'>All Cars</a>  |
            <a href="reservations.php">All Reservations</a>  |
            <a href="rent.php">All Rents</a>  |
            <a href='Insert_to_Tables.php'>Insert to Tables</a>
        </p>
        <p style = "display:none">
            <input id='regnum' name='regnum' type=int value='<?php echo $_GET['regnum']; ?>' />
        </p>
    </form>
</div>
<?php
// check if search view of list view

if (isset($_GET['search'])) {
    $sql = "SELECT * FROM CAR WHERE CAR.REGISTRATION_NUMBER =  '" . $_GET['search'] . "'";
}

// execute sql statement
$stmt = mysqli_query($conn,$sql);
?>
<table class="table table-bordered table-hovered dt-responsive nowrap" id="myTable" >
    <thead>
    <tr>
        <th>Car Registration Number</th>
        <th>Model Of the Car</th>
        <th>Model Year</th>
        <th>Price per Day</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // fetch rows of the executed sql query
    while ($row = mysqli_fetch_array($stmt)) {
        echo "<tr>";
        echo "<td>" . $row['REGISTRATION_NUMBER'] . "</td>";
        echo "<td>" . $row['CAR_MODEL'] . "</td>";
        echo "<td>" . $row['MODEL_YEAR'] . "</td>";
        echo "<td>" . $row['DAILY_PRICE'] . "</td>";
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
            background-color: orangered;
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



