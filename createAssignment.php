<?php
/**
 * filename	: createAssignment.php
 * author	: David Roof 
 * course	: CIS 355
 * purpose	: this program creates new assignments and stores them in a sql table
 * design	: 
 *			1. Check user input on POSTBACK before inserting to table
 *			2. Display the table 
 *				2a. Submit query for customers to populate drop down menu
 *				2b. Submit query for events to populate drop down menu
 *			3. Submit to table
*/
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $customerError = null;
        $eventError = null;
        $commentError = null;
         
        // keep track post values
        $customer = $_POST['customerID'];
        $event = $_POST['eventID'];
        $comment = $_POST['comment'];
         
        // validate input
        $valid = true;

         
        if (empty($comment)) {
            $commentError = 'Please enter Comment';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO assignments (assign_customer_id,assign_event_id,comment) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($customer,$event,$comment));
            Database::disconnect();
            header("Location: assignments.php");
        }
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
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create an Assignment</h3>
                    </div>
             
                    <form class="form-horizontal" action="createAssignment.php" method="post">

					
		
						
					
                      <div class="control-group">
                        <label class="control-label">Customer</label>
                        <div class="controls">
						<?php
						
						$pdo = Database::connect();
						$sql = 'SELECT * FROM customers ORDER BY id DESC';
						
						echo "<select class='form-control' name='customerID' id='customerID'>";
						foreach ($pdo->query($sql) as $row) {
							echo "<option value='" . $row['id'] . " '> " . $row['name'] . "</option>";
						}
						echo "</select>";
						
						Database::disconnect();
						
						?>
						
				
							
							
                        </div>
                      </div>
                      <div class="control-group">
                        <label class="control-label">Event</label>
                        <div class="controls">
                            <?php
						
						$pdo = Database::connect();
						$sql = 'SELECT * FROM events ';
						
						echo "<select class='form-control' name='eventID' id='eventID'>";
						foreach ($pdo->query($sql) as $row) {
							echo "<option value='" . $row['id'] . " '> " . trim($row['description']) . " " . "(" . trim($row['location']) . ")". "</option>";
						}
						echo "</select>";
						
						Database::disconnect();
						
						?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($commentError)?'error':'';?>">
                        <label class="control-label">Comment</label>
                        <div class="controls">
                            <input name="comment" type="text"  placeholder="Comment" value="<?php echo !empty($comment)?$comment:'';?>">
                            <?php if (!empty($commentError)): ?>
                                <span class="help-inline"><?php echo $commentError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="assignments.php">Back</a>
                        </div>
						
						
						
                    </form>
                </div>
     </div> <!-- /container -->
  </body>
</html>
