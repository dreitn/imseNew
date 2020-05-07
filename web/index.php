<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');
// Instantiate DatabaseHelper class
$database = new DatabaseHelper();
$conn = $database->connect();





$locationid = '';
if (isset($_GET['locationid'])) {
    $sql = "SELECT LOCATION_ID FROM LOCATIONS". $_GET['LOCATION_ID'];
}
else {
    $sql = "SELECT * FROM LOCATIONS".$_GET['LOCATION_ID'];
}


$zip_code = '';
if (isset($_GET['ZIP_CODE'])) {
    $zip_code = $_GET['ZIP_CODE'];
}

$street = '';
if (isset($_GET['STREET'])) {
    $street = $_GET['STREET'];
}

$city = '';
if (isset($_GET['CITY'])) {
    $city = $_GET['CITY'];
}



//Fetch data from database
$loc_array = $database->selectAllLocations($conn, $locationid, $zip_code, $street, $city);

?>

<html>
<head>
    <title>CAR RENTAL DATABASE</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

</head>
<body>
<style>
</style>
<br>
<h1>CAR RENTAL DATABASE</h1>

<div>
    <form id='searchform' action='index.php' method='get'>
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
            <input id='location' name='location' type=integer value='<?php echo $_GET['location']; ?>' />
        </p>
    </form>
</div>
<?php
if (isset($_GET['search'])) {
    $sql = "SELECT * FROM LOCATIONS WHERE LOCATION_ID =  '" . $_GET['search'] . "'";
}
else{
    $sql = "SELECT * FROM LOCATIONS JOIN COSTUMER on LOCATIONS.LOCATION_ID = COSTUMER.LOCATIONID";
}

// execute sql statement
$stmt = mysqli_query($conn,$sql);
?>

<table class="table table-bordered table-hovered dt-responsive nowrap" id="myTable" >
    <thead>
    <tr>
        <th>Location ID</th>
        <th>Zip Code</th>
        <th>Street</th>
        <th>City</th>
    </tr>
    </thead>
    <tbody>


    <?php
    // fetch rows of the executed sql query
    while ($row = mysqli_fetch_array($stmt)) {
        echo "<tr>";
        echo "<td>" . $row['LOCATION_ID'] . "</td>";
        echo "<td>" . $row['ZIP_CODE'] . "</td>";
        echo "<td>" . $row['STREET'] . "</td>";
        echo "<td>" . $row['CITY'] . "</td>";
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



