<?php

class DatabaseHelper
{

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

    public function selectAllLocations($conn,$locid, $zip_code, $street, $city)
    {
        $sql = "SELECT * FROM BILLING
            WHERE LOCATION_ID LIKE '%{$locid}%'
            and ZIP_CODE LIKE '%{$zip_code}'
            and STREET LIKE '%{$street}'
            and CITY LIKE '%{$city}'
            ORDER BY LOCATION_ID ASC";

        $result = mysqli_query($conn, $sql);


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