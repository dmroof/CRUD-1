<?php
/**
 * filename	: assignment.php
 * author	: David Roof 
 * course	: CIS 355
 * purpose	: this program displays a list of people (customers)
 * 			  assigned to events 
 * design	: 
 *			1. ensure user is properly logged in 
 *			2. Display all assignments
*/
// Start the session
	session_start(); // Create $_SESSION[]
	if(!isset($_SESSION["user"])){
		header('Location: login.php');
exit;		
		
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<link   href="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/2.3.2/js/bootstrap.min.js"></script>
</head>
 
<body>
    <div class="container">
            <div class="row">
                <h3>PHP CRUD Grid Assignment</h3>
            </div>
            <div class="row">
			<p>
				<a href="createAssignment.php" class="btn btn-success">Create</a>
            </p>


				<table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Person ID</th>
                      <th>Event ID</th>
                      <th>Comments</th>
					  <th>Action</th>
                    </tr>
                </thead>
                <tbody>
					<?php
					include 'database.php';
					$pdo = Database::connect();
		                 
					$sql ='SELECT assignments.id, customers.name, events.description, assignments.comment
							FROM assignments
							INNER JOIN customers ON assignments.assign_customer_id = customers.id
							INNER JOIN events ON assignments.assign_event_id = events.id;';
				  
					foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['name'] . '</td>';
                            echo '<td>'. $row['description'] . '</td>';
                            echo '<td>'. $row['comment'] . '</td>';
							echo '<td width=250>';
                            echo '<a class="btn" href="readAssignment.php?id='.$row['id'].'">Read</a>';
                            echo ' ';
                            echo '<a class="btn btn-success" href="updateAssignment.php?id='.$row['id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="deleteAssignment.php?id='.$row['id'].'">Delete</a>';
                            echo '</td>';
							echo '</tr>';
					}
					Database::disconnect();
					?>
					</tbody>
            </table>
        </div>
    </div> <!-- /container -->
	
	<a href="logout.php" style="text-decoration: none;"><span class="glyphicon glyphicon-arrow-left" style="padding-right:3px;"></span> Back to Home</a>
		
  </body>
</html>
