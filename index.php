<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
		integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Tilt+Prism&display=swap" rel="stylesheet">
	<style>
		.vh-100 {
			height: 100vh;
		}

		body {
			background-image: url(3064464.jpg);
			background-size: cover;
			font-family: Verdana;
		}

		.card {
			border-radius: 1rem;
			background-image: url(365451.jpg);
			background-size: cover;
			box-shadow: 5px 10px 18px #655421;
		}

		.form-outline {
			margin-bottom: 1.5rem;
		}
	</style>
</head>

<body>
	<?php 
	
	function connectToDatabase() {
            try{
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "dealers_connect";
        
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
        
                // Check connection
                if ($conn->connect_error) {
                    throw new Exception("Cannot connect to the database: " . $conn->connect_error);
                }

                return $conn;

             }catch (Exception $e) {
                echo "Cannot connect to the database: " . $e->getMessage();
             }
     }

		session_start();

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Retrieve form data
			$email = $_POST['email'];
			$password = $_POST['password'];
			$first_name = $POST['first_name'];
			
			// Display the entered email and hashed password for debugging
			echo "Entered email: " . $email . "<br>";
			echo "Entered password (plain text): " . $password . "<br>";
		
			// Call the connectToDatabase() function to get the database connection
			$conn = connectToDatabase();
		
			// Query the database for the user with the entered email
			$stmt = $conn->prepare("SELECT client_id, email, password, first_name FROM registration WHERE email = ?");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$result = $stmt->get_result();
		
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				$storedPassword = $row['password'];
		
				// Verify the entered password using password_verify()
				if ($password == $storedPassword) {
					// Passwords match, user is authenticated
					// Store relevant user details in session or cookies
					$_SESSION['client_id'] = $row['client_id'];
					$_SESSION['email'] = $row['email'];
					$_SESSION['first_name'] = $row['first_name'];
		
					// Redirect the user to the profile page or any other page
					header("Location: profile.php");
					exit();
				} else {
					// Passwords don't match, display error message
					$error = "Invalid email or password";
				}
			} else {
				// User not found, display error message
				$error = "Invalid email or password";
			}
		}
		
	?>

	<section class="vh-100">

		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-8 col-lg-6 col-xl-5">
					<div class="card shadow-2-strong">
						<div class="card-body p-5 text-center">

							<div class="text-center">
								<img src="logo.png" style="height: 125px; width: 125px;" class="rounded" alt="...">
							</div>

							<h2 class="mb-5" style="color: white; font-weight:600; font-family: 'Tilt Prism', cursive;">
								Dealers
								Connect</h2>
								<?php if (isset($error)) { ?>
        								<p><?php echo $error; ?></p>
    							<?php } ?>

							<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
								<div class="form-outline mb-4">
									<input type="email" id="typeEmailX-2" class="form-control form-control-lg"
										placeholder="Username" required="true" name="email"/>
								</div>

								<div class="form-outline mb-4">
									<input type="password" id="typePasswordX-2" class="form-control form-control-lg"
										placeholder="Password" required="true" name="password"/>
								</div>

								<div class="form-check d-flex justify-content-end mb-4">
									<a href="index.php" class="" style="color: white;">Forgot your password? </a>
								</div>

								<div class="row">
									<div class="col">
										<button class="btn btn-primary btn-lg btn-block" type="submit"
											style="background-color: #1b1b1b; box-shadow: 5px 10px 20px #44391a inset; border-color: #44391a;">Login</button>
									</div>
									<div class="col">
										<button class="btn btn-primary btn-lg btn-block"
											onclick="window.location.href='registration.php'"
											style="background-color: #1b1b1b; box-shadow: 5px 10px 20px #44391a inset; border-color: #44391a;">
											Sign-Up</button>
									</div>
								</div>
							</form>

						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="

https://code.jquery.com/jquery-3.4.1.slim.min.js"
		integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
		integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
		crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
		integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
		crossorigin="anonymous"></script>
</body>

</html>