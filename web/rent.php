<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

$conn = $database->connect();

$email = '';
if (isset($_GET['RENT_EMAIL'])) {
    $sql = "SELECT RENT_EMAIL FROM RENT". $_GET['RENT_EMAIL'];
}
else {
    $sql = "SELECT * FROM RENT".$_GET['RENT_EMAIL'];
}

$car = '';
if (isset($_GET['RENT_CAR'])) {
    $car = $_GET['RENT_CAR'];
}

$res = '';
if (isset($_GET['RENT_RESERVATION'])) {
    $res = $_GET['RENT_RESERVATION'];
}


//Fetch data from database
$rent_array = $database->selectAllRents($conn, $email, $car, $res);

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
    <form id='searchform' action='rent.php' method='get'>
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
            <input id='email' name='email' type=String value='<?php echo $_GET['RENT_EMAIL']; ?>' />
            <input id='car' name='car' type=String value='<?php echo $_GET['RENT_CAR']; ?>' />
            <input id='res' name='res' type=String value='<?php echo $_GET['RENT_RESERVATION']; ?>' />
        </p>
    </form>
</div>
<?php
// check if search view of list view

if (isset($_GET['search'])) {
    $sql = "SELECT * FROM RENT WHERE RENT_EMAIL =  '" . $_GET['search'] . "'";
}
else{
    $sql = "SELECT * FROM RENT JOIN CAR C2 on RENT.RENT_CAR = C2.REGISTRATION_NUMBER";
}

// execute sql statement
$stmt = mysqli_query($conn,$sql);
?>
<table class="table table-bordered table-hovered dt-responsive nowrap" id="myTable" >
    <thead>
    <tr>
        <th>Email of Costumer</th>
        <th>Rented Car Id</th>
        <th>Reservation Number</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // fetch rows of the executed sql query
    while ($row = mysqli_fetch_array($stmt)) {
        echo "<tr>";
        echo "<td>" . $row['RENT_EMAIL'] . "</td>";
        echo "<td>" . $row['RENT_CAR'] . "</td>";
        echo "<td>" . $row['RENT_RESERVATION'] . "</td>";
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




