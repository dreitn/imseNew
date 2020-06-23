<?php

// Show all information, defaults to INFO_ALL
phpinfo();


// connect to mongodb
$m = new MongoClient();

echo "Connection to database successfully";
// select a database
$db = $m->mydb;

echo "Database mydb selected";
?>
