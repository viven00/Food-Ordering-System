<?php
session_start();
if (!isset($_SESSION['userID'])) {
	die(header("location: index.php"));
}

include_once("WeeklyCustomerReportController.php");
$user = new WeeklyCustomerReportController();
?>

<div class="contentBox">
	<h1>Weekly Customers Visit Report</h1>
	<br>
	<form class="form-horizontal" action="" method="post">
		<div class="form-group">
			<label for="date" class="control-label col-sm-4">Week:</label>
			<div class="col-sm-4">
				<input type="week" class="form-control" name="date" required>
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
			$result = $user->weeklyCustomerReport($_POST['date']);

			if ($result->num_rows > 0) {
				echo "<div class='text-center'><h3> Report for the week: " . $_POST['date'] . "</h3></div><br>";
				echo "<table class='table table-striped'>
			<tr>
			<th align = left>Year&nbsp</th>
			<th align = left>Week&nbsp</th>
			<th align = left>CustomerPhone&nbsp</th>
            <th align = left>Visits&nbsp</th>
			</tr>";

				while ($row = $result->fetch_assoc()) {
					echo "<tr><td>" . $row["year"] .
						"</td><td>" . $row["week"] .
						"</td><td>" . $row["customerPhone"] .
						"</td><td>" . $row["visits"];
					echo "</td></tr>";
				}
				echo "</table>";
			} else
				echo "<div class='text-center'><h4>No results found</h4></div>";
		}
		?>
	</div>
</div>