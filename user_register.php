<!doctype html>
<html lang="en">
  <head>
  	<title>User Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">

</head>
<style>
	body {
		background-color: black;
		overflow-x: hidden;
	}
</style>
<body>
	<section class="ftco-section">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
						<div class="img" style="background-image: url(https://imgs.search.brave.com/mFEnaxKce2nC7raRRZ7VUb7puYhd6V898qvq6pc5RjA/rs:fit:860:0:0/g:ce/aHR0cHM6Ly9ndHJu/aXNzYW5za3lsaW5l/LmNvbS93cC1jb250/ZW50L3VwbG9hZHMv/MjAyMy8wOS9yMzVw/aWM2LTEwMjQtNzY4/LmpwZw);">
			        </div>
					<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Sign Up</h3>
			      		</div>
						<div class="w-100">
						</div>
			      	</div>
						<form action="" class="signin-form" method="POST">
			      		<div class="form-group mb-3">
                            <label for="first_name">First Name:</label> 
                            <input type="text" class="form-control" id="first_name" name="first_name" required> 
			      		</div>
		                <div class="form-groups mb-3">
                            <label for="last_name">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
		                </div>
                        <div class="form-group mb-3">
                            <label for="phone">Phone Number:</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
		                </div>
						<div class="form-group mb-3">
							<label for="address">Address:</label>
                        	<input type="text" class="form-control" id="address" name="address" required>
		                </div>
						<div class="form-group mb-3">
                        	<label for="city">City:</label>
                        	<input type="text" class="form-control" id="city" name="city" required>
                    	</div>
						<div class="form-group mb-3">
							<label for="email">Username:</label>
                        	<input type="text" class="form-control" id="email" name="email" required>
		                </div>
						<div class="form-group">
                        	<label for="password">Password:</label>
                        	<input type="password" class="form-control" id="password" name="password" required>
                    	</div>
		            	<div class="form-group">
                  			<button type="submit" onclick="window.location.href='user_login.php'" class="form-control btn btn-primary rounded submit px-3">Register</button>
		            	</div>
		            <!-- <div class="form-group d-md-flex">
		            	<div class="w-50 text-left">
			            	<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
									  <input type="checkbox" checked>
									  <span class="checkmark"></span>
										</label>
									</div>
		            </div> -->
		          </form>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<?php
    session_start(); 
    include "dbconn.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
        $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $city = isset($_POST['city']) ? $_POST['city'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if (!empty($first_name) && !empty($last_name) && !empty($phone) && !empty($address) && !empty($city) && !empty($email) && !empty($password)) {
            $sql = "INSERT INTO user_info (first_name, last_name, phone, address, city, email, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
           
			$stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $first_name, $last_name, $phone, $address, $city, $email, $password);

            if ($stmt->execute()) {
				header('Location: user_login.php');
				echo '<div class="alert alert-success" role="alert">Registration successful!</div>';
            } else {
                echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
            }
            $stmt->close();
        } else {
            echo '<div class="alert alert-warning" role="alert">Please fill all the fields.</div>';
        }
    }

    $conn->close();
    ?>

	<script src="js/jquery.min.js"></script>
  	<script src="js/popper.js"></script>
  	<script src="js/bootstrap.min.js"></script>
  	<script src="js/main.js"></script>

 
</body>
</html>

