<?php

class DatabaseHelper
{
    const username = "user";
    const password = "user";
    const hostname = 'mariadb';
    const db = "db";

    protected $conn;

    public function set_connection($conn)
    {


        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "Connected successfully";
        }
    }

    public function closeConnection() {
        //mysqli_close($conn);
    }


    public function selectAllCostumers($conn, $email, $phone, $fname, $lname, $locid)
    {
        echo "<br> email: $email --- <br>";

        $sql = "SELECT * FROM COSTUMER
            WHERE EMAIL LIKE '%{$email}%'
            and PHONE_NUMBER LIKE '%{$phone}'
            and FIRSTNAME LIKE '%{$fname}'
            and SURNAME LIKE '%{$lname}'
            and LOCATIONID LIKE '%{$locid}'
            ORDER BY surname ASC";

        $result = mysqli_query($conn, $sql);
/*

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "Name: " . $row["EMAIL"]. "<br>";
                echo "Phone: " . $row["PHONE_NUMBER"]. "<br>";
                echo "First Name: " . $row["FIRSTNAME"]. "<br>";
                echo "Family Name: " . $row["SURNAME"]. "<br>";
            }
        } else {
            echo "0 results";
        }
*/
        return $result;

    }

    /*
    public function insertIntoCostumer($email, $phone, $name, $surname, $location)
    {
        $sql = "INSERT INTO Costumer (EMAIL, PHONE_NUMBER, FIRSTNAME, SURNAME, LOCATIONID) VALUES ('{$email}', '{$phone}', '{$name}','{$surname}', '{$location}')";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }

*/
    public function selectAllBill($conn,$billnr, $total, $date, $c_email)
    {
        $sql = "SELECT * FROM BILLING
            WHERE BILL_NUMBER LIKE '%{$billnr}%'
            and TOTAL_PRICE LIKE '%{$total}'
            and BILLDATE LIKE '%{$date}'
            and C_EMAIL LIKE '%{$c_email}'
            ORDER BY BILL_NUMBER ASC";

        $result = mysqli_query($conn, $sql);

/*
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo "Bill number: " . $row["BILL_NUMBER"]. "<br>";
                echo "Total Price: " . $row["TOTAL_PRICE"]. "<br>";
                echo "Date: " . $row["BILLDATE"]. "<br>";
            }
        } else {
            echo "0 results";
        }
*/
        return $result;
    }
/*
    public function insertIntoBilling($total, $date, $c_mail)
    {
        $sql = "INSERT INTO BILLING (TOTAL_PRICE, BILLDATE, C_EMAIL) VALUES ('{$total}', '{$date}','{$c_mail}')";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }


*/
}