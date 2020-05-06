<?php


//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request

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

// Insert method
$success = $database->insertIntoCostumer($email, $phone, $fname, $surname, $locid);

// Check result
if ($success) {
    echo "Costumer '{$fname} {$surname} {$email}' successfully added!'";
} else {
    echo "Error can't insert Costumer '{$fname} {$surname} {$email}'!";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>



<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
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

// Insert method
$success = $database->insertIntoBilling($billnr, $total, $date, $c_mail);

// Check result
if ($success){
    echo "Bill for costumer '{$total}' on '{$date}' successfully added!";
}
else{
    echo "Error can't insert Bill '{$total}' on '{$date}'!";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>
