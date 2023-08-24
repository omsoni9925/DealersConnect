<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        body {
            background-image: url(3064464.jpg);
            background-size: cover;
            font-family: Lora;
        }

        .card {
            border-radius: 1rem;
            background-image: url(365451.jpg);
            background-size: cover;
            box-shadow: 5px 10px 18px #655421;
            color: white;
        }
    </style>
</head>

<body>
    <section class="vh-100">
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

        function fetchVehicleList(){
            $conn = connectToDatabase();
            // Fetch vehicles from the database
            $sql = "SELECT vehicle_name FROM vehicles";
            $result = $conn->query($sql);

            // Check if there are any vehicles
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"" . $row['vehicle_name'] . "\">" . $row['vehicle_name'] . "</option>";
                }
            } else {
                echo "<option value=\"\">No vehicles found</option>";
            }

            // Close the database connection
            $conn->close();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $firstName = $_POST['first_name'];
            $lastName = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $age = $_POST['DOB'];
            $age = date('Y-m-d', strtotime($age));
            $gender = $_POST['gender'];
            $vehicleName = $_POST['vehicle_name'];

            $conn = connectToDatabase();
            
            // Check if the entered vehicle name exists in the vehicles table
            $vehicleQuery = $conn->prepare("SELECT vehicle_id FROM vehicles WHERE vehicle_name = ?");
            $vehicleQuery->bind_param("s", $vehicleName);
            $vehicleQuery->execute();
            $vehicleResult = $vehicleQuery->get_result();

            if ($vehicleResult->num_rows == 1) {
                $vehicleRow = $vehicleResult->fetch_assoc();
                $vehicleId = $vehicleRow['vehicle_id'];

                //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                // Prepare the SQL query
                $stmt = $conn->prepare("INSERT INTO registration (first_name, last_name, email, password, age, gender, vehicle_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssi", $firstName, $lastName, $email, $password, $age, $gender, $vehicleId);

                // Execute the query
                if ($stmt->execute()) {
                    echo '<script>alert("Registration Successful :)")</script>';
                } else {
                    echo "Error: " . $stmt->error;
                }

            } else {
                echo "Invalid vehicle name";
            }

            // Close the statements and the database connection
            $vehicleQuery->close();
            $stmt->close();
            $conn->close();
        }

        ?>
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card">
                        <div class="container p-4">
                            <h2 class="text-center">Registration Form</h2>
                            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                                <div class="form-group">
                                    <label for="first_name">First Name:</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        placeholder="Enter First Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="last_name">Last Name:</label>
                                    <input type="text" class="form-control" id="last_name" placeholder="Enter Last Name" name="last_name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter Email" name="email"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password:</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter Password" required>
                                </div>
                                <div class="form-group">
                                    <label for="DOB">DOB:</label>
                                    <input type="date" class="form-control" id="DOB" name="DOB"
                                        placeholder="Enter DOB" required>
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender:</label>
                                    <div class="container ">
                                        <div class="row">
                                            <div class="col-md">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender" id="male"
                                                        value="male" required>
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="female" value="female" required>
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="gender"
                                                        id="other" value="other" required>
                                                    <label class="form-check-label" for="other">Other</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="vehicles">Vehicles Connect:</label>
                                    <select class="form-control" id="vehicleDropdown" name="vehicle_name" required>
                                        <option value="">Select Vehicle</option>
                                        <?php fetchVehicleList(); ?>
                                    </select>
                                </div>


                                <button type="submit" class="btn btn-primary btn-block"
                                    style="background-color: #1b1b1b; box-shadow: 5px 10px 20px #44391a inset; border-color: #44391a;">Submit</button>
                                <div class="form-check d-flex justify-content-end mb-4 py-2">
                                    Already have an account? &nbsp;<a href="index.php" class="" style="color: white;">
                                        Sign
                                        In</a>
                                </div>
                            </form>
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


