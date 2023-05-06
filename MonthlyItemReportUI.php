<?php
session_start();
if (!isset($_SESSION['userID'])) {
	die(header("location: index.php"));
}

include_once("MonthlyItemReportController.php");
$user = new MonthlyItemReportController();
?>

<div class="contentBox">
	<h1>Monthly Item Report</h1>
	<br>
	<form class="form-horizontal" action="" method="post">
		<div class="form-group">
			<label for="date" class="control-label col-sm-4">Month:</label>
			<div class="col-sm-4">
				<input type="month" class="form-control" name="month" required>
				<br>
				<input type="submit" name="submit" value="Generate" class="btn btn-primary" style="background-color:#696969">
				<br>
			</div>
		</div>
	</form>
	<br>

	<div class="table-responsive" style="text-align: left;">
		<?php
		if (isset($_POST['submit'])) {
			$result = $user->monthlyItemReport($_POST['month']);

			if ($result->num_rows > 0) {
				echo "<div class='text-center'><h3> Report for the month: " . date('F Y',strtotime($_POST['month'])) . "</h3></div><br>";
				echo "<table class='table table-striped'>
			<tr>
			<th align = left>Year&nbsp</th>
			<th align = left>Month&nbsp</th>
			<th align = left>ItemID&nbsp</th>
			<th align = left>Item Name&nbsp</th>
			<th align = left>Quantity&nbsp</th>
			</tr>";

				while ($row = $result->fetch_assoc()) {
					echo "<tr><td>" . $row["year"] .
						"</td><td>" . $row["month"] .
						"</td><td>" . $row["itemID"] .
						"</td><td>" . $row["itemName"] .
						"</td><td>" . $row["quantity"];
					echo "</td></tr>";
				}
				echo "</table>";
			} else
				echo "<div class='text-center'><h4>No results found</h4></div>";
		}
		?>
	</div>
</div>