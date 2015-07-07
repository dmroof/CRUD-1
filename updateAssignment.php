<?php
/**
 * filename	: updateAssignment.php
 * author	: David Roof 
 * course	: CIS 355
 * purpose	: this program updates assignments and stores them in a sql table
 * design	: 
 *			1. Check user input on POSTBACK before updating to table
 *			2. Display the table with the information from previous unsuccessful submission 
 *			3. Submit to table
*/
    require 'database.php';
	
     $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: assignments.php");
    }
	
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
            $sql = "UPDATE assignments SET assign_customer_id = ? ,assign_event_id = ?,comment = ? WHERE id = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($customer,$event,$comment,$id));
            Database::disconnect();
			
            header("Location: assignments.php");
        }
    }
	else{
		      $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM assignments where id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($id));
        $data = $q->fetch(PDO::FETCH_ASSOC);
        $cid = $data['assign_customer_id'];
        $eid = $data['assign_event_id'];
        $comment = $data['comment'];
        Database::disconnect();
		
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
                        <h3>Update an Assignment</h3>
                    </div>
             
                    <form class="form-horizontal" action="updateAssignment.php?id=<?php echo $id?>" method="post">

					
		
						
					
                      <div class="control-group">
                        <label class="control-label">Customer</label>
                        <div class="controls">
						<?php
						
						$pdo = Database::connect();
						$sql = 'SELECT * FROM customers ORDER BY id DESC';
						
						echo "<select class='form-control' name='customerID' id='customerID'>";
						foreach ($pdo->query($sql) as $row) {
							
							if($row['id']  == $cid){
								echo "<option value='" . $row['id'] . "  ' selected> " . $row['name'] . "</option>";
								
							}
							else{
								echo "<option value='" . $row['id'] . " '> " . $row['name'] . "</option>";
							}
							
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
							
							
							if($row['id']  == $eid){
								echo "<option value='" . $row['id'] . " ' selected> " . trim($row['description']) . " " . "(" . trim($row['location']) . ")". "</option>";
								
							}
							else{
								echo "<option value='" . $row['id'] . " '> " . trim($row['description']) . " " . "(" . trim($row['location']) . ")". "</option>";
							}
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
                          <button type="submit" class="btn btn-success">Update</button>
                          <a class="btn" href="assignments.php">Back</a>
                        </div>
						
						
						
                    </form>
                </div>
     </div> <!-- /container -->
  </body>
</html>
