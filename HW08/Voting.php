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
        <form id="voteForm" action="Voting.php" method="post">
        
        </form>
    </body>
</html>


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