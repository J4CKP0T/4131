<!DOCTYPE html>
<html>
    <head>
        <meta charset = "utf-8">
		<title>Credentials</title>
		<link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <header>
            <h1>Vote for your Favourite Cuisine</h1>
        </header>
        <p>To vote, enter your name and email, and click Submit! </p>
        <div class="formDiv">
            <form id='credentialsForm' action='credentials.php' method="post">
	            Name:
	            <input type="text" name="name" id="name" value="<?php echo $name;?>"><br>
	            Email:
	            <input type="email" name="email" id="email" value="<?php echo $email;?>"><br>
	            <br>
	            <input type="submit" value="Submit" value="Submit">
        	</form>
            <?php
            ini_set('display_error','1');
			error_reporting(E_ALL);
            
            //Create database
            $servername = "egon";
            $username = "C4131S15U17";
            $password = "3622";
            $dbname = "C4131S15U17";
            $port = "3307";

            // Create connection
            $conn = mysqli($servername, $username, $password, $dbname, $port);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } 

            //Create USER table
            $sql = "CREATE TABLE USER ( Name VARCHAR(30) NOT NULL, 
                                        Email VARCHAR(50) PRIMARY KEY )";

            if ($conn->query($sql) === TRUE) {
                echo "Table USER created successfully";
            } else {
                echo "Error creating table: " . $conn->error;
            }
            
            //Create VOTE table
            $sql = "CREATE TABLE VOTE ( Cuisine VARCHAR(20) PRIMARY KEY,
                                        Count INT NOT NULL)";
                                        
            if ($conn->query($sql) === TRUE) {
                echo "Table VOTE created successfully";
            } else {
                echo "Error creating table: " . $conn->error;
            }
            
            //Insert initial Cuisines into VOTE table
            $sql = "INSERT INTO VOTE(Cuisine, Count)
                    VALUES ('Indian', 0);";
            $sql = "INSERT INTO VOTE(Cuisine, Count)
                    VALUES ('Chinese', 0);";
            $sql = "INSERT INTO VOTE(Cuisine, Count)
                    VALUES ('Mexican', 0);";
            $sql = "INSERT INTO VOTE(Cuisine, Count)
                    VALUES ('Italian', 0);";
            $sql = "INSERT INTO VOTE(Cuisine, Count)
                    VALUES ('Thai', 0);";
            $sql = "INSERT INTO VOTE(Cuisine, Count)
                    VALUES ('French', 0);";
            $sql = "INSERT INTO VOTE(Cuisine, Count)
                    VALUES ('American', 0);";
            
            validateCredentials();
            pageReferral();
            $conn->close();
            
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            
            function validateCredentials(){
                // define variables and set to empty values
                $nameErr = $emailErr = "";
                $name = $email = "";
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                    //Validate name
                    if (empty($_POST["name"])) {
                        $nameErr = "Name is required";
                    } 
                    else {
                        $name = test_input($_POST["name"]);
                        // check if name only contains letters and whitespace
                        if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                            $nameErr = "Only letters and white space allowed"; 
                        }
                    }
                    
                    //Validate email
                    if (empty($_POST["email"])) {
                        $emailErr = "Email is required";
                    } 
                    else {
                        $email = test_input($_POST["email"]);
                        // check if e-mail address is well-formed
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $emailErr = "Invalid email format"; 
                        }
                    }
                    
                    
                }
            }
            
            function pageReferral(){
                $name = test_input($_POST["name"]);
                $email = test_input($_POST["email"]);
                
                $sql = "SELECT Email 
                        FROM USER
                        WHERE Email = '$email'";
                $conn->query($sql);
                $result = $conn->query($sql);
                
            //If they have registered before, the results screen is displayed with a message saying they have already voted.
                if($result->num_rows > 0 ){
                    header('Location: Result.php');
                }
            
            //If they have not registered before, they are sent to the Voting page, and their credentials are recorded in the USER table.
                else{
                    $sql = "INSERT INTO USER(Name, Email)
                            VALUES ('$name', '$email');";
                    header('Location: Voting.php');
                }
            }
            ?>
        </div>
    </body>
</html>