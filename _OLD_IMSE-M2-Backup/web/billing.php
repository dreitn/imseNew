<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

$conn = $database->connect();

if (isset($_GET['billnr'])) {
    $sql = "SELECT BILL_NUMBER FROM BILLING". $_GET['billnr'];
}
else {
    $sql = "SELECT * FROM BILLING".$_GET['email'];
}

$billnr = '';
if (isset($_GET['BILL_NUMBER'])) {
    $billnr = $_GET['BILL_NUMBER'];
}

$total = '';
if (isset($_GET['TOTAL_PRICE'])) {
    $total = $_GET['TOTAL_PRICE'];
}

$date = '';
if (isset($_GET['BILLDATE'])) {
    $date = $_GET['BILLDATE'];
}

$c_mail = '';
if (isset($_GET['C_EMAIL '])) {
    $c_mail  = $_GET['C_EMAIL '];
}

//Fetch data from database
$costumer_array = $database->selectAllBill($conn, $billnr, $total, $date, $c_mail);

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
<h1>USE CASE 1: SEARCH A SPECIFIC BILL AND SEE THE DETAILS </h1>
<div>
    <form id='searchform' action='billing.php' method='get'>
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
            <input id='bill' name='bill' type=int value='<?php echo $_GET['billnr']; ?>' />
        </p>
    </form>
</div>
<?php
// check if search view of list view

if (isset($_GET['search'])) {
    $sql = "SELECT * FROM BILLING WHERE BILL_NUMBER =  '" . $_GET['search'] . "'";
}
else{
    $sql = "SELECT * FROM BILLING JOIN COSTUMER C2 on BILLING.C_EMAIL = C2.EMAIL";
}

// execute sql statement
$stmt = mysqli_query($conn,$sql);
?>
<table class="table table-bordered table-hovered dt-responsive nowrap" id="myTable" >
    <thead>
    <tr>
        <th>Bill number</th>
        <th>Total Price</th>
        <th>Bill Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
    // fetch rows of the executed sql query
    while ($row = mysqli_fetch_array($stmt)) {
        echo "<tr>";
        echo "<td>" . $row['BILL_NUMBER'] . "</td>";
        echo "<td>" . $row['TOTAL_PRICE'] . "</td>";
        echo "<td>" . $row['BILLDATE'] . "</td>";
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



