<?php

class DatabaseHelper
{
    public function connect(){

        $conn = mysqli_connect("mariadb", "user", "user", "db");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {

        }
        return $conn;
    }

    public function selectAllCostumers($conn, $email, $phone, $fname, $lname, $locid)
    {
        $sql = "SELECT * FROM COSTUMER
            WHERE EMAIL LIKE '%{$email}%'
            and PHONE_NUMBER LIKE '%{$phone}'
            and FIRSTNAME LIKE '%{$fname}'
            and SURNAME LIKE '%{$lname}'
            and LOCATIONID LIKE '%{$locid}'
            ORDER BY surname ASC";

        $result = mysqli_query($conn, $sql);

        return $result;
    }


    public function selectAllBill($conn,$billnr, $total, $date, $c_email)
    {
        $sql = "SELECT * FROM BILLING
            WHERE BILL_NUMBER LIKE '%{$billnr}%'
            and TOTAL_PRICE LIKE '%{$total}'
            and BILLDATE LIKE '%{$date}'
            and C_EMAIL LIKE '%{$c_email}'
            ORDER BY BILL_NUMBER ASC";

        $result = mysqli_query($conn, $sql);

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

    public function selectAllCars($conn,$reg_num, $model, $price)
    {
        $sql = "SELECT * FROM CAR
            WHERE REGISTRATION_NUMBER LIKE '%{$reg_num}%'
            and CAR_MODEL LIKE '%{$model}'
            and DAILY_PRICE LIKE '%{$price}'
            ORDER BY REGISTRATION_NUMBER ASC";

        $result = mysqli_query($conn, $sql);

        return $result;
    }

    public function selectAllReservations($conn,$resnr, $from, $return, $amount, $bill)
    {
        $sql = "SELECT * FROM RESERVATION
            WHERE RESERVATION_NUMBER LIKE '%{$resnr}%'
            and FROM_DATE LIKE '%{$from}'
            and RETURN_DATE LIKE '%{$return}'
            and AMOUNT LIKE '%{$amount}'
            and RESERVATION_BILL_NUMBER LIKE '%{$bill}'
            ORDER BY RESERVATION_NUMBER ASC";

        $result = mysqli_query($conn, $sql);

        return $result;
    }


    public function selectAllRents($conn, $email, $car, $res)
    {
        $sql = "SELECT * FROM RENT";

        $result = mysqli_query($conn, $sql);

        return $result;
    }


   public function insertIntoCostumer($conn, $email, $phone, $name, $surname, $location)
   {
       $sql = "INSERT INTO Costumer (EMAIL, PHONE_NUMBER, FIRSTNAME, SURNAME, LOCATIONID) VALUES ('{$email}', '{$phone}', '{$name}','{$surname}', '{$location}')";

       if (mysqli_query($conn, $sql)) {
           echo "Insert successfully!";
       } else {
           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
       }
   }


    public function insertIntoBilling($conn, $total, $date, $c_mail)
    {
        $sql = "INSERT INTO BILLING (TOTAL_PRICE, BILLDATE, C_EMAIL) VALUES ('{$total}', '{$date}','{$c_mail}')";

        if (mysqli_query($conn, $sql)) {
            echo "Insert successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    public function insertIntoReservation($conn, $RESERVATION_NUMBER, $FROM_DATE, $RETURN_DATE, $AMOUNT)
    {
        $sql = "INSERT INTO RESERVATION (reservation_number, from_date, return_date, amount, reservation_bill_number) VALUES ('{$RESERVATION_NUMBER}', '{$FROM_DATE}','{$RETURN_DATE}','{$AMOUNT}','{$RESERVATION_NUMBER}')";

        if (mysqli_query($conn, $sql)) {
            echo "Insert successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }

    public function insertIntoCAR($conn, $REGISTRATION_NUMBER, $CAR_MODEL, $MODEL_YEAR, $DAILY_PRICE)
    {
        $sql = "INSERT INTO CAR (registration_number, car_model, model_year, daily_price) VALUES ('{$REGISTRATION_NUMBER}', '{$CAR_MODEL}','{$MODEL_YEAR}','{$DAILY_PRICE}')";

        if (mysqli_query($conn, $sql)) {
            echo "Insert successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }

    public function insertIntoRent($conn, $RENT_EMAIL, $RENT_CAR, $RENT_RESERVATION)
    {
        $sql = "INSERT INTO RENT (rent_email, rent_car, rent_reservation) VALUES ('{$RENT_EMAIL}', '{$RENT_CAR}','{$RENT_RESERVATION}')";

        if ($conn->query($sql) === TRUE) {
            echo "Insert successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

    }


}