<?php
session_start();
if (!isset($_SESSION['userID'])) {
	die(header("location: index.php"));
}

include_once("MonthlySalesReportController.php");
$user = new MonthlySalesReportController();
?>

<div class="contentBox">
	<h1>Monthly Sales Report</h1>
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
			$result = $user->monthlySalesReport($_POST['month']);

			if ($result->num_rows > 0) {
				echo "<table class='table table-striped'>
			<tr>
			<th align = left>Date&nbsp</th>
			<th align = left>OrderID&nbsp</th>
			<th align = left>Gst&nbsp</th>
			<th align = left>Service Charge &nbsp</th>
			<th align = left>Total&nbsp</th>
			</tr>";
				$totalRow = $result->num_rows;
				$total = 0;
				while ($row = $result->fetch_assoc()) {
					echo "<tr><td>" . $row["date"] .
						"</td><td>" . $row["orderID"] .
						"</td><td>" . number_format($row["gst"], 2) .
						"</td><td>" . number_format($row["serviceCharge"], 2) .
						"</td><td>" . number_format($row["total"], 2);
					echo "</td></tr>";
					$total += $row["total"];
				}
				$avg = $total/$totalRow;
				echo "<div class='text-center'>
				<h3> Report for the month: " . date('F Y',strtotime($_POST['month'])) .
				"</h3>
				<br>
				<h4> Total sales: $" . number_format($total, 2) .
				"<br>
				Average sales: $" . number_format($avg, 2) .
					"</h4></div>";
				echo "</table>";
				echo "</table>";
			} else
				echo "<div class='text-center'><h4>No results found</h4></div>";
		}
		?>
	</div>
</div>