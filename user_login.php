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
		overflow-x: hidden;
		overflow-y: hidden;
	}
</style>

<body>
	<section class="ftco-section">
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10">
					<div class="wrap d-md-flex">
					<video width="700px" height="470px" autoplay loop muted playsinline style="object-fit: fill;">
    <source src="uploads/LoginVid.mp4" type="video/mp4">
    Your browser does not support the video tag.
</video>
						<div class="login-wrap p-4 p-md-5">
			      	<div class="d-flex">
			      		<div class="w-100">
			      			<h3 class="mb-4">Sign In</h3>
			      		</div>
								<div class="w-100">
								</div>
			      	</div>
							<form action="" class="signin-form" method="POST">
			      		<div class="form-group mb-3">
			      			<label class="label" for="name">Username </label>
							<input type="text" class="form-control" name="email" id="email" placeholder="Username" required>
                  
			      		</div>
		            <div class="form-group mb-3">
		            	<label class="label" for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
		            </div>
		            <div class="form-group">
                  <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
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
		          <p class="text-center">Don't have an account? <a data-toggle="tab" href="user_register.php">Register Here</a></p>
		        </div>
		      </div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  	<script src="js/popper.js"></script>
  	<script src="js/bootstrap.min.js"></script>
  	<script src="js/main.js"></script>
  <?php
    session_start(); 
    include "connection.php";

    $action = "user_login.php"; 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['email'];
        $password = $_POST['password'];
    
        $admin_stmt = $conn->prepare("SELECT * FROM admin_account WHERE email = ? AND password = ?");
        $admin_stmt->bind_param("ss", $username, $password);
        $admin_stmt->execute();
        $admin_result = $admin_stmt->get_result();
    
        $customer_stmt = $conn->prepare("SELECT * FROM user_info WHERE email = ? AND password = ?");
        $customer_stmt->bind_param("ss", $username, $password);
        $customer_stmt->execute();
        $customer_result = $customer_stmt->get_result();
    
        if ($admin_result->num_rows > 0) {
            $_SESSION['admin_id'] = $username; 
            header("Location: admin_dash.php");
        } elseif ($customer_result->num_rows > 0) {    
            $customer_row = $customer_result->fetch_assoc();
            $_SESSION['user_id'] = $customer_row['user_id'];
            header("Location: ui.php");
        } else {
            echo "Invalid username or password";
        }
    }
    ?>
</body>
</html>

