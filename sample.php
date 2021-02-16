
<?php include "../inc/dbinfo.inc"; ?>
<html>
<body>
<h1>Enter you information here</h1>
<?php

  /* Connect to MySQL and select the database. */
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    $database = mysqli_select_db($connection, DB_DATABASE);

      /* Ensure that the EMPLOYEES table exists. */
      VerifyEmployeesTable($connection, DB_DATABASE);

      /* If input fields are populated, add a row to the EMPLOYEES table. */
      $employee_name = htmlentities($_POST['NAME']);
        $employee_address = htmlentities($_POST['ADDRESS']);

        if (strlen($employee_name) || strlen($employee_address)) {
		    AddEmployee($connection, $employee_name, $employee_address);
		      }
?>

<!-- Input form -->
<form action="<?PHP echo $_SERVER['SCRIPT_NAME'] ?>" method="POST">
  <table border="0">
    <tr>
      <td>First Name</td>
      <td>Last Name</td>
	  <td>Line One</td>
	  <td>City</td>
	  <td>State</td>
	  <td>Zip</td>
    </tr>
    <tr>
      <td>
        <input type="text" name="First Name" maxlength="45" size="30" />
      </td>
      <td>
        <input type="text" name="Last Name" maxlength="90" size="60" />
      </td>
	  <td>
        <input type="text" name="Line one" maxlength="45" size="30" />
      </td>
	  <td>
        <input type="text" name="City" maxlength="45" size="30" />
      </td>
	  <td>
        <input type="text" name="State" maxlength="45" size="2" />
      </td>
      <td>
	  <td>
        <input type="text" name="Zip" maxlength="45" size="5" />
      </td>
	  <td>
        <input type="submit" value="Add Data" />
      </td>
    </tr>
  </table>
</form>

<!-- Display table data. -->
<table border="1" cellpadding="2" cellspacing="2">
  <tr>
    <td>ID</td>
    <td>First Name</td>
    <td>Last Name</td>
	<td>line one</td>
	<td>City</td>
	<td>State</td>
	<td>Zip</td>
  </tr>

<?php

	$result = mysqli_query($connection, "SELECT * FROM EMPLOYEES");

	while($query_data = mysqli_fetch_row($result)) {
		  echo "<tr>";
		    echo "<td>",$query_data[0], "</td>",
			           "<td>",$query_data[1], "</td>",
				          "<td>",$query_data[2], "</td>";
		    echo "</tr>";
		  }
?>

</table>

<!-- Clean up. -->
<?php

	  mysqli_free_result($result);
	  mysqli_close($connection);

?>

</body>
</html>


<?php

	  /* Add an employee to the table. */
	  function AddEmployee($connection, $fname, $lname,$address_street,$address_city,$address_state,$address_zip) {
		     $n = mysqli_real_escape_string($connection, $fname);
		        $l = mysqli_real_escape_string($connection, $lname);
					$s= mysqli_real_escape_string($connection,$address_street);
						$ct= mysqli_real_escape_string($connection,$address_city);
							$st= mysqli_real_escape_string($connection,$address_state);
								$zip= mysqli_real_escape_string ($connection,$zip)
		        $query = "INSERT INTO customers (First Name, Last Name, Line one, City, State, Zip) VALUES ('$n', '$l', $s, $ct, $st, $zip);";

			   if(!mysqli_query($connection, $query)) echo("<p>Error adding employee data.</p>");
	  }

	  /* Check whether the table exists and, if not, create it. */
	  function VerifyEmployeesTable($connection, $dbName) {
		    if(!TableExists("EMPLOYEES", $connection, $dbName))
			      {
				           $query = "CREATE TABLE EMPLOYEES (
						            ID int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
							             NAME VARCHAR(45),
								              ADDRESS VARCHAR(90)
									             )";

     if(!mysqli_query($connection, $query)) echo("<p>Error creating table.</p>");
  }
	  }

	  /* Check for the existence of a table. */
	  function TableExists($tableName, $connection, $dbName) {
		    $t = mysqli_real_escape_string($connection, $tableName);
		      $d = mysqli_real_escape_string($connection, $dbName);

		      $checktable = mysqli_query($connection,
			            "SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_NAME = '$t' AND TABLE_SCHEMA = '$d'");

		        if(mysqli_num_rows($checktable) > 0) return true;

		        return false;
			}
?>                        
                
