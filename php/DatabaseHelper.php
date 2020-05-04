<?php

class DatabaseHelper
{

    const username = 'a11728483'; // use a + your matriculation number
    const password = 'dbs19'; // use your oracle db password
    const con_string = 'lab';

    // Since we need only one connection object, it can be stored in a member variable.
    // $conn is set in the constructor.
    protected $conn;

    // Create connection in the constructor
    public function __construct()
    {
        try {

            $this->conn = @oci_connect(
                DatabaseHelper::username,
                DatabaseHelper::password,
                DatabaseHelper::con_string
            );

            //check if the connection object is != null
            if (!$this->conn) {
                // die(String(message)): stop PHP script and output message:
                die("DB error: Connection can't be established!");
            }

        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }

    public function __destruct()
    {
        // clean up
        @oci_close($this->conn);
    }


    public function selectAllCostumers($email, $phone, $fname, $lname, $locid)
    {

        $sql = "SELECT * FROM costumer
            WHERE email LIKE '%{$email}%'
            and PHONE_NUMBER LIKE '%{$phone}'
            and FIRSTNAME LIKE '%{$fname}'
            and SURNAME LIKE '%{$lname}'
            and LOCATIONID LIKE '%{$locid}'
            ORDER BY surname ASC";


        $statement = @oci_parse($this->conn, $sql);

        // Executes the statement
        @oci_execute($statement);

        @oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        //clean up;
        @oci_free_statement($statement);

        return $res;
    }

    public function insertIntoCostumer($email, $phone, $name, $surname, $location)
    {
        $sql = "INSERT INTO Costumer (EMAIL, PHONE_NUMBER, FIRSTNAME, SURNAME, LOCATIONID) VALUES ('{$email}', '{$phone}', '{$name}','{$surname}', '{$location}')";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }

    public function deleteCostumer($email)
    {
        $errorcode = 0;

        $sql = 'BEGIN DELETE_COSTUMER:email, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        //  Bind the parameters
        @oci_bind_by_name($statement, ':email', $email);
        @oci_bind_by_name($statement, ':errorcode', $errorcode);

        // Execute Statement
        @oci_execute($statement);

        @oci_free_statement($statement);

        return $errorcode;
    }

    public function selectAllBill($billnr, $total, $date, $c_email)
    {
        $sql = "SELECT * FROM BILLING
            WHERE BILL_NUMBER LIKE '%{$billnr}%'
            and TOTAL_PRICE LIKE '%{$total}'
            and BILLDATE LIKE '%{$date}'
            and C_EMAIL LIKE '%{$c_email}'
            ORDER BY BILL_NUMBER ASC";

        $statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement);

        @oci_fetch_all($statement, $res, null, null, OCI_FETCHSTATEMENT_BY_ROW);

        @oci_free_statement($statement);

        return $res;
    }

    public function insertIntoBilling($total, $date, $c_mail)
    {
        $sql = "INSERT INTO BILLING (TOTAL_PRICE, BILLDATE, C_EMAIL) VALUES ('{$total}', '{$date}','{$c_mail}')";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }

    public function deleteBill($billnr)
    {
        $errorcode = 0;

        $sql = 'BEGIN DELETE_BILL(:bill_number, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        @oci_bind_by_name($statement, ':bill_number', $billnr);
        @oci_bind_by_name($statement, ':errorcode', $errorcode);

        @oci_execute($statement);

        @oci_free_statement($statement);

        return $errorcode;
    }

}