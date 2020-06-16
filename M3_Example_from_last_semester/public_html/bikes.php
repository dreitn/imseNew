<html>
<?php
  // establish database connection
  $mng = new MongoDB\Driver\Manager("mongodb://admin:imse@mongo:27017");
  $query = new MongoDB\Driver\Query([]); 
  $rows = $mng->executeQuery("imse.Bike", $query);
?>
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
    <form id='searchform' action='index.php' method='get'>
      <p style = "margin-left: 15px;">
      <a href='index.php'>All Employees</a> ---
      <a href='shop.php'>All Shops</a>---
      <a href='customers.php'>All Customers</a>---
      <a href='bikes.php'>All Bikes</a>---
      <a href='register.php'>New Registration</a>---
    </p>
      <p style = "display:none">
      <input id='search' name='search' type=integer value='<?php echo $_GET['search']; ?>' />
      <input id='submit' type='submit' value='Los!' />
    </p>
    </form>
  </div>
  <?php
  if (isset($_GET['search'])) {
    $filter = [ '_id' => $_GET['search'] ]; 
    $query = new MongoDB\Driver\Query($filter);
    $res = $mng->executeQuery("imse.Bike", $query);
    $searchedBike = current($res->toArray());
  }
  ?>
  <table class="table table-bordered table-hovered dt-responsive nowrap" id="myTable" >
    <thead>
      <tr>
      	<th>ID</th>
        <th>Price</th>
        <th>ModelName</th>
        <th>Repaired by(EmployeeID)</th>
      </tr>
    </thead>
    <tbody>
<?php
  // fetch rows of the executed sql query
if(!isset($_GET['search'])){
  foreach ($rows as $row){
    echo "<tr>";
    echo "<td>" . $row->_id . "</td>";
    echo "<td>" . $row->Price . "</td>";
    echo "<td>" . $row->Modelname . "</td>";
    echo "<td>";
    foreach($row->RepairdByEmployeeIDs as $Employee){
       echo "<a href=index.php?search=". $Employee. ">". $Employee. "</a>.&nbsp;&nbsp;";
    }
    echo "</td>";

    echo "</tr>";
  }
}else{
    echo "<tr>";
    echo "<td>" . $searchedBike->_id . "</td>";
    echo "<td>" . $searchedBike->Price . "</td>";
    echo "<td>" . $searchedBike->Modelname . "</td>";
    echo "<td>";
    foreach($searchedBike->RepairdByEmployeeIDs as $Employee){
       echo "<a href=index.php?search=". $Employee. ">". $Employee. "</a>.&nbsp;&nbsp;";
    }
    echo "</td>";
    echo "</tr>";
}
?>
</tbody>
</table>
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
</body>
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