<?php
session_start();
if (!isset($_SESSION['userID'])) {
	die(header("location: index.php"));
}

include_once("SearchUserController.php");
$user = new SearchUserController();
$temp = $user->viewProfiles();
$profileid = array();
$profilename = array();
while ($row = $temp->fetch_assoc()) {
	array_push($profileid, $row["profileID"]);
	array_push($profilename, $row["profileName"]);
}
?>

<div class="contentBox">
	<h1>Search user</h1>
	<br>
	<form class="form-horizontal" action="" method="post">

		<div class="form-group">
			<label name="userId" class="control-label col-sm-4">User ID:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="userID">
			</div>
		</div>

		<div class="form-group">
			<label for="username" class="control-label col-sm-4">Username:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="username">
			</div>
		</div>

		<div class="form-group">
			<label for="name" class="control-label col-sm-4">Name:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="name">
			</div>
		</div>

		<div class="form-group">
			<label for="email" class="control-label col-sm-4">Email:</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="email">
			</div>
		</div>

		<div class="form-group">
			<label for="phoneNumber" class="control-label col-sm-4">Phone Number:</label>
			<div class="col-sm-4">
				<input type="number" class="form-control" name="phoneNumber">
			</div>
		</div>

		<div class="form-group">
			<label for="userprofile" class="control-label col-sm-4">User Profile:</label>
			<div class="col-sm-4">
				<select class="form-control" name="userprofile">
					<option value="">All</option>
					<?php
					for ($i = 0; $i < count($profilename); $i++) {
						echo "<option value=$profileid[$i]>$profilename[$i]</option>";
					}
					?>
				</select>
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
	<br>

	<div class="table-responsive" style="text-align: left; ">
		<?php
		if (isset($_POST['submit'])) {
			$result = $user->searchUser($_POST['userID'], $_POST['username'], $_POST['name'], $_POST['email'], $_POST['phoneNumber'], $_POST['userprofile'], $_POST['status']);
		} else
			$result = $user->searchUser(null, null, null, null, null, null, null);

		if ($result->num_rows > 0) {
			echo "<table class='table table-striped'>
			<tr>
			<th align = left>UserID&nbsp</th>
			<th align = left>Username&nbsp</th>
			<th align = left>Password&nbsp</th>
			<th align = left>Name&nbsp</th>
			<th align = left>Email&nbsp</th>
			<th align = left>Phone Number&nbsp</th>
			<th align = left>User Profile ID&nbsp</th>
			<th align = left>Status&nbsp</th>
			</tr>";

			while ($row = $result->fetch_assoc()) {
				echo "<tr><td>" . $row["userID"] .
					"</td><td>" . $row["username"] .
					"</td><td>" . $row["password"] .
					"</td><td>" . $row["name"] .
					"</td><td>" . $row["email"] .
					"</td><td>" . $row["phoneNumber"] .
					"</td><td>" . $row["userProfile"] .
					"</td><td>" . $row["status"];
				echo "</td></tr>";
			}

			echo "</table>";
		} else
			echo "<div class='text-center'><h4>No results found</h4></div>";
		?>
	</div>
</div>