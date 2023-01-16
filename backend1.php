<?php 
$dbname = "test";
$servername = "localhost";
$username = "root";
$password = "root";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

extract($_POST);

if(isset($_POST['readrecord'])) {

	$data = '<table class="table table-bordered table-striped">
			<tr>
				<th>S.no</th>
				<th>Firstname</th>
				<th>LastName</th>
				<th>Email Address</th>
				<th>Mobile</th>
				<th>Edit Action</th>
				<th>Delete Action</th>
			</tr>';

	$displayquery = "SELECT * FROM `user`";
	$result = mysqli_query($conn, $displayquery);

	if(mysqli_num_rows($result) > 0) {
		$number = 1;

		while ($row = mysqli_fetch_array($result)) {

			$data .= '<tr>
					<td>'.$number.'</td>
					<td>'.$row['firstname'].'</td>
					<td>'.$row['lastname'].'</td>
					<td>'.$row['email'].'</td>
					<td>'.$row['mobile'].'</td>
					<td><button onclick="GetUserDetails('.$row['id'].')" class="btn btn-warning" data-toggle="modal">Edit</button
					</td>
					<td><button onclick="DeleteUser('.$row['id'].')" class="btn btn-danger">Delete</button
					</td>
				</tr>';
				$number++;
		}
	}
	$data .= '</table>';
	echo $data;
}

if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['mobile']) ) {
	$query = "INSERT INTO `user`(`firstname`, `lastname`, `email`, `mobile`) VALUES ('$firstname','$lastname','$email','$mobile')";
	mysqli_query($conn, $query);
}

if(isset($_POST['deleteid'])) {
	$userid = $_POST['deleteid'];

	$deletequery = " delete from `user` where id = '$userid' "; 
	mysqli_query($conn, $deletequery);
}

if(isset($_POST['id']) && isset($_POST['id']) != "") {
	$user_id = $_POST['id'];
	$query = " SELECT * FROM `user` WHERE `id` = $user_id ";
	if(!$result = mysqli_query($conn, $query)) {
		exit(mysqli_error());
	}

	$response = array();
	
	if(mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$response = $row;
		}
	}
	else {
		$response['status'] = 200;
		$response['message'] = "Data not found!"; 
	}
	echo json_encode($response); 
}
else {
	$response['status'] = 200;
	$response['message'] = "Invalid Request!";
}


if(isset($_POST['hidden_user_id'])) {
	$hidden_user_id = $_POST['hidden_user_id'];
	$firstname = $_POST['update_firstname'];
	$lastname = $_POST['update_lastname'];
	$email = $_POST['update_email'];
	$mobile = $_POST['update_mobile'];

	$query = " UPDATE `user` SET `firstname`='$firstname',`lastname`='$lastname',`email`='$email',`mobile`='$mobile' WHERE `id`='$hidden_user_id' ";
	mysqli_query($conn, $query);
}

?>

