<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

// Get parameter 'person_id', 'surname' and 'name' from GET Request
// Btw. you can see the parameters in the URL if they are set
$email = '';
if (isset($_GET['email'])) {
    $email = $_GET['email'];
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

$billnr = '';
if (isset($_GET['billnr'])) {
    $billnr = $_GET['billnr'];
}

$total = '';
if (isset($_GET['total'])) {
    $total = $_GET['total'];
}

$date = '';
if (isset($_GET['date '])) {
    $date = $_GET['date '];
}

$c_mail = '';
if (isset($_GET['c_mail '])) {
    $c_mail  = $_GET['c_mail '];
}

//Fetch data from database
$costumer_array = $database->selectAllCostumers($email, $phone, $fname, $surname, $locid);
$bill_array = $database->selectAllBill($billnr, $total, $date, $c_mail);
?>

<html>
<head>
    <title>MY PHP-HTML PAGE</title>
</head>

<body>
<br>
<h1>CAR RENTAL DATABASE</h1>

<!-- Add Person -->
<h1>1) first handling costumers!</h1>
<h2>Add Costumer: </h2>
<form method="post" action="addCostumer.php">
    <!-- ID is not needed, because its autogenerated by the database -->

    <!-- Name textbox -->
    <div>
        <label for="new_email">Email:</label>
        <input id="new_email" name="email" type="text" maxlength="30">
    </div>
    <br>

    <div>
        <label for="new_phone">Phone number:</label>
        <input id="new_phone" name="phone_number" type=number min="10">
    </div>
    <br>

    <div>
        <label for="new_fname">Firstname:</label>
        <input id="new_fname" name="fname" type="text" maxlength="20">
    </div>
    <br>

   <div>
    <label for="new_surname">Surname:</label>
    <input id="new_surname" name="surname" type="text" maxlength="20">
    </div>
    <br>

    <div>
    <label for="new_locid">Location id:</label>
    <input id="new_locid" name="locid" type="text" maxlength="20">
    </div>
    <br>

    <!-- Submit button -->
    <div>
        <button type="submit">
            Add Costumer
        </button>
    </div>
</form>
<br>
<hr>


<!-- Search form -->
<h2>Costumer Search:</h2>
<form method="get">
    <!-- ID textbox:-->
    <div>
        <label for="email">Email:</label>
        <input id="email" name="email" type="text" value='<?php echo $email; ?>'>
    </div>
    <br>

    <!-- Surname textbox:-->
    <div>
        <label for="surname">Surname:</label>
        <input id="surname" name="surname" type="text" value='<?php echo $surname; ?>' maxlength="20">
    </div>
    <br>

    <!-- Submit button -->
    <div>
        <button id='submit' type='submit'>
            Search
        </button>
    </div>
</form>
<br>
<hr>

<!-- Search result -->
<h2>Costumer Search Result:</h2>
<table>
    <tr>
        <th>Email</th>
        <th>Phone number</th>
        <th>Name</th>
        <th>Surname</th>
        <th>Location</th>
    </tr>
    <?php foreach ($costumer_array as $costumer) : ?>
        <tr>
            <td><?php echo $costumer['EMAIL']; ?>  </td>
            <td><?php echo $costumer['PHONE_NUMBER']; ?>  </td>
            <td><?php echo $costumer['FIRSTNAME']; ?>  </td>
            <td><?php echo $costumer['SURNAME']; ?>  </td>
            <td><?php echo $costumer['LOCATIONID']; ?>  </td>
        </tr>
    <?php endforeach; ?>
</table>



<h1>2) Bills!</h1>
<h2>Add Bill: </h2>
<form method="post" action="addBilling.php">

    <div>
        <label for="new_total">total price:</label>
        <input id="new_total" name="otal" type=number min="10">
    </div>
    <br>

    <div>
        <label for="new_date">Date:</label>
        <input id="new_date" name="date" type="text" maxlength="20">
    </div>
    <br>

    <div>
        <label for="new_c_email">Costumer Email:</label>
        <input id="new_c_email" name="c_email" type="text">
    </div>
    <br>
    <!-- Submit button -->
    <div>
        <button type="submit">
            Add Billing
        </button>
    </div>
</form>
<br>
<hr>

<!-- Search form -->
<h2>Bill Search:</h2>
<form method="get">
    <!-- ID textbox:-->
    <div>
        <label for="bill">Bill number:</label>
        <input id="bill" name="bill" type="number" value='<?php echo $billnr; ?>'>
    </div>
    <br>

    <!-- Submit button -->
    <div>
        <button id='submit' type='submit'>
            Search
        </button>
    </div>
</form>
<br>
<hr>

<!-- Search result -->
<h2>Bill Search Result:</h2>
<table>
    <tr>
        <th>Bill number</th>
        <th>total price
        <th>date<th>
        <th>costumer email</th>
    </tr>
    <?php foreach ($bill_array as $bill) : ?>
        <tr>
            <td><?php echo $bill['BILL_NUMBER']; ?>  </td>
            <td><?php echo $bill['TOTAL_PRICE']; ?>  </td>
            <td><?php echo $bill['BILLDATE']; ?>  </td>
            <td><?php echo $bill['C_EMAIL']; ?>  </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>