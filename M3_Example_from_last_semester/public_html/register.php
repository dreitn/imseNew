<?php
  // establish database connection
  $mng = new MongoDB\Driver\Manager("mongodb://admin:imse@mongo:27017");
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
  <div>
    <form id='searchform' action='register.php' method='get'>
       <p style = "margin-left: 15px;">
      <a href='index.php'>All Employees</a> ---
      <a href='shop.php'>All Shops</a>---
      <a href='customers.php'>All Customers</a>---
      <a href='bikes.php'>All Bikes</a>---
      <a href='register.php'>New Registration</a>---
    </p>
    </form>
  </div>
<div>
  <form id='insertform' action='register.php' method='get'>
    <p style = "margin-left: 15px;">
    <strong>Register a new Customer:</strong>
    <p style = "margin-left: 30px;">
  <table style='border: none'>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Discountrate</th>
      </tr>
    </thead>
    <tbody>
       <tr>
        <td>
          <p style = "margin-right: 10px;">
             <input id='ID' name='ID' type='text' size='10' value='<?php echo $_GET['ID']; ?>' />
              </p>
                </td>
          <td>
            <p style = "margin-right: 10px;">
             <input id='Name' name='Name' type='text' size='20' value='<?php echo $_GET['Name']; ?>' />
           </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='LastName' name='LastName' type='text' size='20' value='<?php echo $_GET['LastName']; ?>' />
                 </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='PhoneNumber' name='PhoneNumber' type='text' size='20' value='<?php echo $_GET['PhoneNumber']; ?>' />
                 </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='Discountrate' name='Discountrate' type='text' size='20' value='<?php echo $_GET['Discountrate']; ?>' />
                 </p>
                </td>
        </tr>
           </tbody>
        </table>
        <input id='submit' type='submit' value='Register' />
      </p>
      </p>
  </form>
</div>


<?php
  //Handle insert
  if (isset($_GET['Name'])) 
  {
    $doc = ['_id' => $_GET['ID'] ,'Name'=> $_GET['Name'] ,'Lastname'=>$_GET['LastName'],'phonenumber'=>$_GET['PhoneNumber'],
    'Discountrate'=>$_GET['Discountrate']];
  $bulk = new MongoDB\Driver\BulkWrite;
  $bulk->insert($doc);
  $mng->executeBulkWrite('imse.Customer', $bulk);
  }
?>
<div>
  <form id='insertform2' action='register.php' method='get'>
    <p style = "margin-left: 15px;margin-top: 50px;">
    <strong>Register a new Bike:</strong>
    <p style = "margin-left: 30px;">
  <table style='border: none'>
    <thead>
      <tr>
        <th>CustomerID</th>
        <th>BikeID :</th>
        <th>Price :</th>
        <th>Modelname :</th>
        <th>ShopID :</th>
      </tr>
    </thead>
    <tbody>
       <tr>
        <td>
          <p style = "margin-right: 10px;">
             <input id='CustomerID' name='CustomerID' type='text' size='10' value='<?php echo $_GET['CustomerID']; ?>' />
           </p>
                </td>
        <td>
          <p style = "margin-right: 10px;">
             <input id='BikeID' name='BikeID' type='text' size='10' value='<?php echo $_GET['BikeID']; ?>' />
           </p>
                </td>
          <td>
            <p style = "margin-right: 10px;">
             <input id='Price' name='Price' type='text' size='20' value='<?php echo $_GET['Price']; ?>' />
           </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='Modelname' name='Modelname' type='text' size='20' value='<?php echo $_GET['Modelname']; ?>' />
                 </p>
                </td>
                <td>
                  <p style = "margin-right: 10px;">
                   <input id='ShopID' name='ShopID' type='text' size='20' value='<?php echo $_GET['ShopID']; ?>' />
                 </p>
                </td>
        </tr>
           </tbody>
        </table>
        <input id='submit2' type='submit' value='Register' />
      </p>
      </p>
  </form>
</div>


<?php
  //Handle insert
  if (isset($_GET['BikeID'])) 
  {
  $doc = ['_id' => $_GET['BikeID'] ,'Price'=> $_GET['Price'] ,'Modelname'=>$_GET['Modelname']];
  $bulk = new MongoDB\Driver\BulkWrite;
  $bulk->insert($doc);
  $mng->executeBulkWrite('imse.Bike', $bulk);
  
  $shopBulk = new MongoDB\Driver\BulkWrite;
  $filter = [ '_id' => $_GET['ShopID'] ]; 
  $query = new MongoDB\Driver\Query($filter);
  $res = $mng->executeQuery("imse.Shop", $query);
  $searchedShop = current($res->toArray());
  $newBikesArray = $searchedShop->Bikes;
  array_push($newBikesArray,$_GET['BikeID']);
  $shopBulk->update($filter,['$set' => ['Bikes' => $newBikesArray]],['multi' => false, 'upsert' => false]);
  $mng->executeBulkWrite('imse.Shop', $shopBulk);

  $customerBulk = new MongoDB\Driver\BulkWrite;
  $filter = [ '_id' => $_GET['CustomerID'] ]; 
  $query = new MongoDB\Driver\Query($filter);
  $res = $mng->executeQuery("imse.Customer", $query);
  $searchedCustomer = current($res->toArray());
  $newBikesArray = $searchedCustomer->Bikes;
  array_push($newBikesArray,$_GET['BikeID']);
  $customerBulk->update($filter,['$set' => ['Bikes' => $newBikesArray]],['multi' => false, 'upsert' => false]);
  $mng->executeBulkWrite('imse.Customer', $customerBulk);
  }
?>
<div>
  <form id='insertform3' action='register.php' method='get' >
     <p style = "margin-left: 15px; margin-top: 50px">
    <strong>Register a new Repairment:</strong>
    <p style = "margin-left: 30px;">
  <table style='border: none'>
    <thead>
      <tr>
        <th>Bike ID :</th>
        <th>Employee ID :</th>
      </tr>
    </thead>
    <tbody>
       <tr>
        <td>
          <p style = "margin-right: 10px;">
             <input id='RepairBikeID' name='RepairBikeID' type='text' size=10 value='<?php echo $_GET['RepairBikeID']; ?>' />
           </p>
                </td>
          <td>
            <p style = "margin-right: 10px;">
             <input id='EmployeeID' name='EmployeeID' type='text' size='10' value='<?php echo $_GET['EmployeeID']; ?>' />
           </p>
                </td>
        </tr>
           </tbody>
        </table>
        <input id='submit3' type='submit' value='Register' />
  </form>
</p>
</p>
</div>

<?php
  //Handle insert
  if (isset($_GET['RepairBikeID']) && isset($_GET['EmployeeID'])) 
  {
  $bikeBulk = new MongoDB\Driver\BulkWrite;
  $filter = ['_id' => $_GET['RepairBikeID'] ]; 
  $query = new MongoDB\Driver\Query($filter);
  $res = $mng->executeQuery("imse.Bike", $query);
  $searchedBike = current($res->toArray());
  $newEmployeeArray = $searchedBike->RepairdByEmployeeIDs;
  array_push($newEmployeeArray,$_GET['EmployeeID']);
  $bikeBulk->update($filter,['$set' => ['RepairdByEmployeeIDs' => $newEmployeeArray]],['multi' => false, 'upsert' => false]);
  $mng->executeBulkWrite('imse.Bike', $bikeBulk);
  }
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
                                   <head>
<style>
.button {
  display: inline-block;
  border-radius: 4px;
  background-color: #00a6ff ;
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
