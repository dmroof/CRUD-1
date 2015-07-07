<?php
/**
 * filename	: Event.php
 * author	: David Roof 
 * course	: CIS 355
 * purpose	: this program displays a list of Events with the information associated with it
 * design	: 
 *			
 *			1. Display All Events		 
 *			
*/    
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
                <h3>PHP CRUD Grid Events</h3>
            </div>
            <div class="row">
			  <p>
              <a href="createEvent.php" class="btn btn-success">Create</a>
              </p>


                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Time</th>
                      <th>Location</th>
					  <th>Description</th>
					  <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                   include 'database.php';
                   $pdo = Database::connect();
                   $sql = 'SELECT * FROM events ORDER BY id DESC';
                   foreach ($pdo->query($sql) as $row) {
                            echo '<tr>';
                            echo '<td>'. $row['date'] . '</td>';
                            echo '<td>'. $row['time'] . '</td>';
                            echo '<td>'. $row['location'] . '</td>';
							echo '<td>'. $row['description'] . '</td>';
							echo '<td width=250>';
                            echo '<a class="btn" href="readEvent.php?id='.$row['id'].'">Read</a>';
                            echo ' ';
                            echo '<a class="btn btn-success" href="updateEvent.php?id='.$row['id'].'">Update</a>';
                            echo ' ';
                            echo '<a class="btn btn-danger" href="deleteEvent.php?id='.$row['id'].'">Delete</a>';
                            echo '</td>';
							echo '</tr>';
                   }
                   Database::disconnect();
                  ?>
                  </tbody>
            </table>
        </div>
    </div> <!-- /container -->
  </body>
</html>
