<form action="" method="POST">
<label>Enter employee_id:</label><br />
<input type="text" name="employee_id" placeholder="Enter employee_id" required/>
<br /><br />
<button type="submit" name="submit">Submit</button>
</form>
<?php
if (isset($_POST['employee_id']) && $_POST['employee_id']!="") {
	$employee_id = $_POST['employee_id'];
	$url = "http://localhost:8030/controllers/Employee/updateEmployee?employee_id=".$employee_id;
	
	$client = curl_init($url);
	curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
	$response = curl_exec($client);
	
	$result = json_decode($response);
	
	echo "<table>";
	echo "<tr><td>Order ID:</td><td>$result->employee_id</td></tr>";
	echo "<tr><td>Amount:</td><td>$result->amount</td></tr>";
	echo "<tr><td>Response Code:</td><td>$result->response_code</td></tr>";
	echo "<tr><td>Response Desc:</td><td>$result->response_desc</td></tr>";
	echo "</table>";
}
    ?>
