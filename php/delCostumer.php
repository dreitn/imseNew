<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variable id from POST request
$email = '';
if(isset($_POST['email'])){
    $email = $_POST['email'];
}

// Delete method
$error_code = $database->deleteCostumer($email);

// Check result
if ($error_code == 1){
    echo "Costumer with Email: '{$email}' successfully deleted!'";
}
else{
    echo "Error can't delete Costumer with email: '{$email}'. Errorcode: {$error_code}";
}
?>

<!-- link back to index page-->
<br>
<a href="index.php">
    go back
</a>