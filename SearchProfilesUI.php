<?php
include_once("SearchProfileController.php");
session_start();
if (!isset($_SESSION['userID'])) {
	die(header("location: index.php"));
}
$profile = new SearchProfileController();
?>

<div class="contentBox">
	<h1>Search User Profile</h1>
	<br>
	<form class="form-horizontal" action="" method="post">

		<div class="form-group">
			<label for="profileID" class="control-label col-sm-4">Profile ID:</label>
			<div class="col-sm-4">
				<input type="number" class="form-control" name="profileID">
			</div>
		</div>

		<div class="form-group">
			<label for="profileName" class="control-label col-sm-4">Profile Name:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="profileName">
			</div>
		</div>

		<div class="form-group">
			<label for="status" class="control-label col-sm-4">Status:</label>
			<div class="col-sm-4">
				<select class="form-control" name="status">
					<option value="">All</option>
					<option value="Active">Active</option>
					<option value="Suspended">Suspended</option>
				</select>
				<br>
				<input type="submit" name="submit" value="Search" class="btn btn-primary" style="background-color:#696969">
			</div>
		</div>
	</form>
	<br><br>

	<div class="table-responsive" style="text-align: left;">
		<?php
		if (isset($_POST['submit'])) {
			$result = $profile->searchProfile($_POST['profileID'], $_POST['profileName'], $_POST['status']);
		} else
			$result = $profile->searchProfile(null, null, null);

		if ($result->num_rows > 0) {
			echo "<table class='table table-striped'>
			<tr>
			<th align = left>ProfileID&nbsp</th>
			<th align = left>ProfileName&nbsp</th>
			<th align = left>Status&nbsp</th>
			</tr>";

			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>" . $row["profileID"] .
					"</td><td>" . $row["profileName"] .
					"</td><td>" . $row["status"];
				echo "</td></tr>";
			}

			echo "</table>";
		} else
			echo "<div class='text-center'><h4>No results found</h4></div>";

		?>
	</div>
</div>