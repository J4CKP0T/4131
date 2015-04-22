<?php
	session_start();
?>

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
            <?php
            ini_set('display_error','1');
			error_reporting(E_ALL);
            
            submitCredentials();
            
            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            
            function submitCredentials(){
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                    // define variables and set to empty values
                    $nameErr = $emailErr = "";
                    $name = $email = "";
                    
                    /* Grab name and email from form */
					$name = $_POST['name'];
					$email = $_POST['email'];
					
					/* Validate fields */
					if(!validateCredentials($name, $email, $nameErr, $emailErr)) {
						return;
					}
					
					$name = test_input($_POST["name"]);
                    $email = test_input($_POST["email"]);
						
					$_SESSION['name'] = $name;
                    
                    //Set variables to connect with DB
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
                    
                    // Check if USER table exists. Create it if it doesn't.
                     if ($conn->query("SHOW TABLES LIKE 'USER'")->num_rows==0)
                     {
                        //Create USER table
                        $sql = "CREATE TABLE USER ( Name VARCHAR(30) NOT NULL, 
                                                    Email VARCHAR(50) PRIMARY KEY )";

                        if ($conn->query($sql) === TRUE) {
                            echo "Table USER created successfully";
                        } else {
                            echo "Error creating table: " . $conn->error;
                        }
                     }
                     
                     //Query USER table for credentials obtained in results.
                     $sql = "SELECT Email 
                             FROM USER
                             WHERE Email = '$email'";
                     $conn->query($sql);
                     $result = $conn->query($sql);
                     
                     //If they have registered before, the results screen is displayed with a message saying they have already voted.
                     if($result->num_rows > 0 ){
                         $conn->close();
                         header('Location: Result.php');
                     }
            
                     //If they have not registered before, they are sent to the Voting page, and their credentials are recorded in the USER table.
                     else{
                        $sql = "INSERT INTO USER(Name, Email)
                                VALUES ('$name', '$email')";
                        $conn->query($sql);
                        $conn->close();
                        header('Location: Voting.php');
                     }
                     
                }
            }
            
            function validateCredentials($_name, $_email, $_nameErr, $_emailErr){
                //Validate name
                if (empty($_name)) {
                    $nameErr = "Name is required";
                    return 0;
                } 
                else {
                    $name = test_input($_name);
                    // check if name only contains letters and whitespace
                    if (!preg_match("/^[a-zA-Z ]*$/",$_name)) {
                        $nameErr = "Only letters and white space allowed";                    
                        return 0;
                    }
                }
                    
                //Validate email
                if (empty($_email)) {
                    $emailErr = "Email is required";
                    return 0;
                } 
                else {
                    $email = test_input($_email);
                    // check if e-mail address is well-formed
                    if (!filter_var($_email, FILTER_VALIDATE_EMAIL)) {                   
                        $emailErr = "Invalid email format";
                        return 0;
                    }
                }
                return 1;
            }
            ?>
            <form id='credentialsForm' action='credentials.php' method="post">
	            Name:
	            <input type="text" name="name" id="name" value="<?php echo $name;?>">
	            <span class="error">* <?php echo $nameErr;?></span>
                <br><br>
	            Email:
	            <input type="email" name="email" id="email" value="<?php echo $email;?>">
	            <span class="error">* <?php echo $emailErr;?></span>
                <br><br>
	            <input type="submit" value="Submit" value="Submit">
        	</form>
        </div>
    </body>
</html>