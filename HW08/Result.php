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
		<meta charset = "utf-8">
		<title>Result</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h1>Results for all Users:</h1>
		<div style="width: 500px">
            <!-- Logout Button -->
            <form action="logoutResult.php" method="post">
            	<?php
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
					
					/* Get sum of all votes */
					$sql = 'SELECT SUM(Count) FROM VOTE';
					$result = $conn->query($sql);
					$row = $result->fetch_assoc();
					$sum = $row[0];
					
					/* Calculate voting percentages of each cuisine */
					$sql = 'SELECT Cuisine FROM VOTE';
					$result = $conn->query($sql);
					while($row = $result->fetch_assoc()) {
						echo '' . ucwords($row['Cuisine']) . ':<br><br>';
	            		$sql = 'SELECT Count FROM VOTE WHERE Cuisine="'. $row['Cuisine'] . '"';
	            		$query = $conn->query($sql);
						$entry = $query->fetch_assoc();
						$percent = round(100*($entry[0]/$sum), 2);
						echo '<div class="bar" style="width:'. 5*$percent .'px"></div>' . $percent . '%<br><br>';
					}
            	?>
                <input type="submit" class="submit" value="Log Out">
            </form>
        </div>
	</body>
</html>