<?php
include_once("SearchMenuItemController.php");
$user = new SearchMenuItemController();

session_start();
if (!isset($_SESSION['userID'])) {
	die(header("location: index.php"));
}
?>

<div class="contentBox">
	<h1>Search Menu Item</h1>
	<br />
	<form class="form-horizontal" action="" method="post">
		<div class="form-group">
			<label name="itemId" class="control-label col-sm-4">Item ID:</label>
			<div class="col-sm-4">
				<input type="number" class="form-control" name="itemID">
			</div>
		</div>

		<div class="form-group">
			<label name="itemName" class="control-label col-sm-4">Item Name:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="itemName">
			</div>
		</div>

		<div class="form-group">
			<label name="minPrice" class="control-label col-sm-4">Min Price:</label>
			<div class="col-sm-4">
				<input type="number" class="form-control" step="0.1" min="0" name="minPrice">
			</div>
		</div>

		<div class="form-group">
			<label name="maxPrice" class="control-label col-sm-4">Max Price:</label>
			<div class="col-sm-4">
				<input type="number" class="form-control" step="0.1" min="0" name="maxPrice">
			</div>
		</div>

		<div class="form-group">
			<label name="itemDesc" class="control-label col-sm-4">Item Description:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="itemDescription">
				<br>
				<input type="submit" name="submit" value="Search" class="btn btn-primary" style="background-color:#696969">
			</div>
		</div>
	</form>
	<br>

	<div class="table-responsive" style="text-align: left;">
		<?php
		$result = $user->searchMenuItem(null, null, null, null, null, null);
		if (isset($_POST['submit'])) {
			$validate = $user->validateSearch($_POST['itemID'], $_POST['itemName'], $_POST['minPrice'], $_POST['maxPrice'], $_POST['itemDescription']);
			if ($validate  == "success")
				$result = $user->searchMenuItem($_POST['itemID'], $_POST['itemName'], $_POST['minPrice'], $_POST['maxPrice'], $_POST['itemDescription']);
			else
				alert($validate);
		} else
			$result = $user->searchMenuItem(null, null, null, null, null, null);

		if ($result->num_rows > 0) {
			echo "<table class='table table-striped'>
			<th align = left>ItemID&nbsp</th>
			<th align = left>Item Image&nbsp</th>
			<th align = left>Item Name&nbsp</th>
			<th align = left>Item Price&nbsp</th>
            <th align = left>Item Description&nbsp</th>
			</tr>";

			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>" . $row["itemID"] .
					"</td><td>" . "<img src='ItemImages/" . $row['itemImage'] . "' class='imgSearch'>" .
					"</td><td>" . $row["itemName"] .
					"</td><td> $" . number_format($row["itemPrice"], 2) .
					"</td><td>" . $row["itemDescription"];
				echo "</td></tr>";
			}

			echo "</table>";
		} else
			echo "<div class='text-center'><h4>No results found</h4></div>";

		function alert($message)
		{

			echo "<script>alert('$message');</script>";
		}

		?>
	</div>
</div>