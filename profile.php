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
		/* Reset some default styles for better consistency */
body, h1, h2, h3, h4, h5, h6, p, ul, li {
    margin: 0;
    padding: 0;
}

body {
    font-family: Arial, sans-serif;
    background-image: url(3064464.jpg);
    background-size: cover;
}

.card {
    border-radius: 1rem;
    background-image: url(365451.jpg);
    background-size: cover;
    box-shadow: 5px 10px 18px #655421;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.text-center {
    text-align: center;
}

.profile-photo {
    width: 125px;
    height: 125px;
    border-radius: 50%;
    background-color: #ccc;
    margin: 0 auto;
    overflow: hidden;
}

/* Center the welcome message */
.welcome-msg {
    text-align: center;
    margin-bottom: 20px;
}

/* Customize the navigation bar */
nav {
    background-color: #333;
    padding: 10px;
}

nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
}

nav li {
    margin-right: 20px;
}

nav a {
    color: #fff;
    text-decoration: none;
    padding: 10px 15px;
    display: block;
}

nav a:hover {
    background-color: #555;
	text-decoration: none;
}

/* Login form styles */
.form-outline {
    margin-bottom: 1.5rem;
}

.btn-login {
    background-color: #1b1b1b;
    box-shadow: 5px 10px 20px #44391a inset;
    border-color: #44391a;
}

.btn-signup {
    background-color: #1b1b1b;
    box-shadow: 5px 10px 20px #44391a inset;
    border-color: #44391a;
}

.profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
        }

	</style>
</head>

<body>
	<?php 
		// Start the session to access the session data
		session_start();

		// Check if the user is logged in (i.e., if the username is set in the session data)
		if (isset($_SESSION['email'])) {
			// User is logged in, get the username from the session data
			$first_name = $_SESSION['first_name'];
		} else {
			// Redirect to the login page if the user is not logged in
			header("Location: index.php");
			exit();
		}
						
		// Check if the user has uploaded a profile picture
		if (isset($_SESSION['profile_picture'])) {
			$profilePicture = $_SESSION['profile_picture'];
		} else {
			// Set a default profile picture if the user hasn't uploaded one
			$profilePicture = "default_profile_picture.png"; // Replace with the path to your default profile picture
		}
	?>
	 <!-- Navigation Bar -->
	 <nav>
        <ul>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="index.php">Sign-In</a></li>
            <li><a href="index.php">Logout</a></li>
        </ul>
    </nav>

	<section class="vh-100">

		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col-12 col-md-8 col-lg-6 col-xl-5">
					<div class="card shadow-2-strong">
						<div class="card-body p-5 text-center">
							<div class="text-center">
								
								<div class="text-center">
									<img src="<?php echo $profilePicture; ?>" class="profile-picture" alt="Profile Picture">
								</div>


								<form action="upload.php" method="post" enctype="multipart/form-data">
									<input type="file" name="profile_picture" id="profile_picture">
									<button type="submit" name="upload">Upload Profile Picture</button>
								</form>
							</div>
							<h1 style="color: white">Welcome <?php echo $first_name; ?></h1>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
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