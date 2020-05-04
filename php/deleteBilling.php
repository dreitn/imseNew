<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variable id from POST request
$billnr = '';
if(isset($_POST['billnr'])){
    $billnr = $_POST['billnr'];
}

// Delete method
$error_code = $database->deleteBill($billnr);

// Check result
if ($error_code == 1){
    echo "Bill fo Costumer: '{$billnr}' successfully deleted!'";
}
else{
    echo "Error can't delete Bill: '{$billnr}'. Errorcode: {$error_code}";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>