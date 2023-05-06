<?php
include_once("SearchDiscountController.php");
$discount = new SearchDiscountController();

session_start();
if (!isset($_SESSION['userID'])) {
	die(header("location: index.php"));
}
?>

<div class="contentBox">
	<h1>Search Discount</h1>
	<form class="form-horizontal" action="" method="post">
		<div class="form-group">
			<label name="discountID" class="control-label col-sm-4">Discount ID:</label>
			<div class="col-sm-4">
				<input type="number" class="form-control" name="discountID">
			</div>
		</div>

		<div class="form-group">
			<label name="discountID" class="control-label col-sm-4">Discount Name:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="discountName">
			</div>
		</div>

		<div class="form-group">
			<label name="discountAmount" class="control-label col-sm-4">Discount Amount:</label>
			<div class="col-sm-4">
				<input type="number" class="form-control" name="discountAmount">
			</div>
		</div>

		<div class="form-group">
			<label name="discountStatus" class="control-label col-sm-4">Discount Status:</label>
			<div class="col-sm-4">
				<select class="form-control" name="discountStatus">
					<option value="">All</option>
					<option value="Active">Active</option>
					<option value="Inactive">Inactive</option>
				</select>
				<br>
				<input type="submit" name="submit" value="Search" class="btn btn-primary" style="background-color:#696969">
			</div>
		</div>
	</form>
	<br>

	<div class="table-responsive" style="text-align: left;">
		<?php
		if (isset($_POST['submit']))
			$result = $discount->searchDiscount($_POST['discountID'], $_POST['discountName'], $_POST['discountAmount'], $_POST['discountStatus']);
		else
			$result = $discount->searchDiscount(null, null, null, null);

		if ($result->num_rows > 0) {
			echo "<table class='table table-striped'>
			<tr>
			<th align = left>DiscountID&nbsp</th>
			<th align = left>DiscountName&nbsp</th>
			<th align = left>DiscountAmount&nbsp</th>
			<th align = left>DiscountStatus&nbsp</th>
			</tr>";

			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>" . $row["discountID"] .
					"</td><td>" . $row["discountName"] .
					"</td><td>" . $row["discountAmount"] .
					"</td><td>" . $row["discountStatus"];
				echo "</td></tr>";
			}
			echo "</table>";
		} else
			echo "<div class='text-center'><h4>No results found</h4></div>";
		?>
	</div>
</div>