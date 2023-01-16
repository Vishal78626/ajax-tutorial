<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<style type="text/css">
	#myModal, #update_user_modal {
/*		background-color: blue;*/
/*opacity: 0.5	;*/
/*backdrop-filter: blur(2px);*/

	}
</style>

</head>
<body>

<div class="container">
	<h1 class="text-primary text-uppercase"> ajax crud operation</h1>
	<div class="d-flex justify-content-end">
		<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#myModal">
			Open modal
		</button>
	</div>
	<h2 class="text-danger">All Records</h2>
	<div id='records_contant'>
		
	</div>

	<!-- The Modal -->
	<div class="modal" id="myModal">
	  <div class="modal-dialog">
	    <div class="modal-content">

	      <!-- Modal Header -->
	      <div class="modal-header">
	        <h4 class="modal-title">Ajax Crud Operation</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>

	      <!-- Modal body -->
	      <div class="modal-body">
	        <div class="form-group">
	        	<label>Firstname: </label>
	        	<input type="text" name="" id="firstname" class="form-control" placeholder="First Name">
	        </div>
	        <div class="form-group">
	        	<label>Lastname: </label>
	        	<input type="text" name="" id="lastname" class="form-control" placeholder="Last Name">
	        </div>
	        <div class="form-group">
	        	<label>Email Id: </label>
	        	<input type="email" name="" id="email" class="form-control" placeholder="Email">
	        </div>
	        <div class="form-group">
	        	<label>Mobile No: </label>
	        	<input type="text" name="" id="mobile" class="form-control" placeholder="Mobile No">
	        </div>
	      </div>

	      <!-- Modal footer -->
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="addRecord()">Save</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>

	    </div>
	  </div>
	</div>

<!-- update model -->
	<!-- The Modal -->
	<div class="modal" id="update_user_modal">
	  <div class="modal-dialog">
	    <div class="modal-content">

	<!-- Modal Header -->
	      <div class="modal-header">
	        <h4 class="modal-title">Update Ajax Crud Operation</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>

	      <!-- Modal body -->
	      <div class="modal-body">
	        <div class="form-group">
	        	<label>Firstname: </label>
	        	<input type="text" name="" id="update_firstname" class="form-control" placeholder="First Name">
	        </div>
	        <div class="form-group">
	        	<label>Lastname: </label>
	        	<input type="text" name="" id="update_lastname" class="form-control" placeholder="Last Name">
	        </div>
	        <div class="form-group">
	        	<label>Email Id: </label>
	        	<input type="email" name="" id="update_email" class="form-control" placeholder="Email">
	        </div>
	        <div class="form-group">
	        	<label>Mobile No: </label>
	        	<input type="text" name="" id="update_mobile" class="form-control" placeholder="Mobile No">
	        </div>
	      </div>

	      <!-- Modal footer -->
	      <div class="modal-footer">
	        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="updateuserdetail()">Update</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	        <input type="hidden" name="" id="hidden_user_id">
	      </div>

	    </div>
	  </div>
	</div>

</div>

<script type="text/javascript">
	
	$(document).ready(function(){
		readRecords();
	});

	function readRecords() {
		var readrecord = "readrecord";

		$.ajax({
			url: 'backend1.php',
			type: 'post',
			data: { readrecord: readrecord },
			success: function(data, status) {
				$('#records_contant').html(data);
			}
		});
	}

	function addRecord() {
		var firstname = $('#firstname').val();
		var lastname = $('#lastname').val();
		var email = $('#email').val();
		var mobile = $('#mobile').val();

		$.ajax({
			url:"backend1.php",
			type: 'post',
			data: { firstname: firstname,
				lastname: lastname,
				email: email,
				mobile: mobile
			},
			success: function(data, status) {
				readRecords();
			}
		});
	}

	function DeleteUser(deleteid) {
		var conf = confirm("Are you sure you want to delete?")
		if(conf == true) {
			$.ajax({
				url: 'backend1.php',
				type: 'post',
				data: {deleteid: deleteid},
				success: function(data, status) {
					readRecords();
				}
			});
		}
	}

	function GetUserDetails(id) {
		$('#hidden_user_id').val(id);
		$.post('backend1.php', {
			id: id
		},function(data, status){
			var user = JSON.parse(data);
			console.log(user);
			$('#update_firstname').val(user.firstname);
			$('#update_lastname').val(user.lastname);
			$('#update_email').val(user.email);
			$('#update_mobile').val(user.mobile);
		});
		$('#update_user_modal').modal("show");
	}

	function updateuserdetail() {
		var update_firstname = $('#update_firstname').val();
		var update_lastname = $('#update_lastname').val();
		var update_email = $('#update_email').val();
		var update_mobile = $('#update_mobile').val();

		var hidden_user_id = $('#hidden_user_id').val();

		$.post("backend1.php", {
			hidden_user_id: hidden_user_id,
			update_firstname: update_firstname,
			update_lastname: update_lastname,
			update_email: update_email,
			update_mobile: update_mobile
		},
		function(data, status) {
			$('#update_user_modal').modal("hide");
			readRecords();
		});
	}

</script>
</body>
</html>