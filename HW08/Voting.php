<?php
session_start();
	/* Check if a user is in session */
    if(!isset($_SESSION['name'])){
        header('Location: credentials.php');
    }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Voting Form</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Voting Question</h1>
        <p>What is your favourite cuisine?</p>
        <div class="voteFormDiv">
            <?php
            
                submitVote();
            
                function submitVote() {
		    	    /* Check if form was set */
					if (isset($_POST['submit'])) {
							
						/* Check if anything was selected */
						$selected_radio = $_POST['Cuisine'];
						if (empty($_POST['cuisine'])) {
							echo '<p class="error">Please make a selection</p>';
							return;
						}
						
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
							
						/* Check if VOTE table exists. If doesn't, create it
						 * and initialize table values (all votes to zero).
						 */
						
						if ($conn->query("SHOW TABLES LIKE 'VOTE'")->num_rows==0) {
						     
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
                            $conn->query($sql);
                            $sql = "INSERT INTO VOTE(Cuisine, Count)
                                    VALUES ('Chinese', 0);";
                            $conn->query($sql);
                            $sql = "INSERT INTO VOTE(Cuisine, Count)
                                    VALUES ('Mexican', 0);";
                            $conn->query($sql);
                            $sql = "INSERT INTO VOTE(Cuisine, Count)
                                    VALUES ('Italian', 0);";
                            $conn->query($sql);
                            $sql = "INSERT INTO VOTE(Cuisine, Count)
                                    VALUES ('Thai', 0);";
                            $conn->query($sql);
                            $sql = "INSERT INTO VOTE(Cuisine, Count)
                                    VALUES ('Japanese', 0);";
                            $conn->query($sql);
                            $sql = "INSERT INTO VOTE(Cuisine, Count)
                                    VALUES ('Korean', 0);";
                            $conn->query($sql);
						}
							
						/* Record vote in DB and go to result page */
						$sql = "UPDATE VOTE SET Count = Count + 1 WHERE Cuisine = '$selected_radio'";
						$conn->query($sql);
						$conn->close();
						header('Location: Result.php');
					}
		        }
            ?>
            <form id="voteForm" action="Voting.php" method="post">
                <input type="radio" name="Cuisine" value="Indian">
    			Indian
    			<br>
			    <input type="radio" name="Cuisine" value="Chinese">
    			Chinese
    			<br>
    			<input type="radio" name="Cuisine" value="Mexican">
    			Mexican
    			<br>
    			<input type="radio" name="Cuisine" value="Italian">
    			Italian
    			<br>
    			<input type="radio" name="Cuisine" value="Thai">
    			Thai
    			<br>
    			<input type="radio" name="Cuisine" value="Japanese">
    			Japanese
    			<br>
    			<input type="radio" name="Cuisine" value="Korean">
    			Korean
    			<br>
    			<input type="submit" value="Submit">
            </form>
        </div>
    </body>
</html>
           