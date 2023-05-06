<?php
include_once("SearchOrderController.php"); // include create account Controller to call function
session_start();
if (!isset($_SESSION['userID'])) {
	die(header("location: index.php"));
}

$orders = new SearchOrderController();
$temp = $orders->viewOrders();

$orderID = array();
$created_at = array();
$tableNumber = array();
$customerPhone = array();
$total = array();
$status = array();

while ($row = $temp->fetch_assoc()) {
	array_push($orderID, $row["orderID"]);
	array_push($created_at, $row["created_at"]);
	array_push($tableNumber, $row["tableNumber"]);
	array_push($customerPhone, $row["customerPhone"]);
	array_push($total, $row["total"]);
	array_push($status, $row["status"]);
}
?>


<div class="contentBox">
	<h1>Search Order</h1>
	<br />
	<form class="form-horizontal" action="" method="post">

		<div class="form-group">
			<label name="orderID" class="control-label col-sm-4">Order ID:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="orderID">
			</div>
		</div>

		<div class="form-group">
			<label for="tableNumber" class="control-label col-sm-4">Table Number:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="tableNumber">
			</div>
		</div>

		<div class="form-group">
			<label for="created_at" class="control-label col-sm-4">Created at:</label>
			<div class="col-sm-4">
				<input type="date" class="form-control" name="created_at">
			</div>
		</div>

		<div class="form-group">
			<label for="customerPhone" class="control-label col-sm-4">Customer Phone:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="customerPhone">
			</div>
		</div>

		<div class="form-group">
			<label for="total" class="control-label col-sm-4">Total:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="total">
			</div>
		</div>

		<div class="form-group">
			<label for="status" class="control-label col-sm-4">Status:</label>
			<div class="col-sm-4">
				<select class="form-control" name="status">
					<option value="">-</option>
					<option value="Processing">Processing</option>
					<option value="Payment Pending">Payment Pending</option>
					<option value="Paid">Paid</option>
				</select>
				<br>
				<input type="submit" name="submit" value="Search" class="btn btn-primary" style="background-color:#696969">
			</div>
		</div>
	</form>
	<br>

	<div class="table-responsive" style="text-align: left;">
		<?php
		if (isset($_POST['submit'])) {
			$result = $orders->searchOrder($_POST['orderID'], $_POST['created_at'], $_POST['tableNumber'], $_POST['customerPhone'], $_POST['total'], $_POST['status']);
		} else
			$result = $orders->searchOrder(null, null, null, null, null, null, null);

		if (!$result) {
			trigger_error('Invalid query: ' . $conn->error);
		}

		if ($result->num_rows > 0) {
			echo "<table class='table table-striped'>
			<tr>
			<th align = left>OrderID&nbsp</th>
			<th align = left>Created at&nbsp</th>
			<th align = left>Table Number&nbsp</th>
			<th align = left>Customer Phone&nbsp</th>
			<th align = left>Total&nbsp</th>
			<th align = left>Status&nbsp</th>
			</tr>";

			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>" . $row["orderID"] .
					"</td><td>" . $row["created_at"] .
					"</td><td>" . $row["tableNumber"] .
					"</td><td>" . $row["customerPhone"] .
					"</td><td>" . $row["total"] .
					"</td><td>" . $row["status"];
				echo "</td></tr>";
			}

			echo "</table>";
		} else
			echo "<div class='text-center'><h4>No results found</h4></div>";
		?>
	</div>
</div>