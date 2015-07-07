<?php
/**
 * filename	: readAssignment.php
 * author	: David Roof 
 * course	: CIS 355
 * purpose	: this program reads the url for the record ID. Then displays the assignment information
 * design	: 			
 *			1. Display Assignment information
 *	
 *			
*/
    require 'database.php';
    $id = null;
    if ( !empty($_GET['id'])) {
        $id = $_REQUEST['id'];
    }
     
    if ( null==$id ) {
        header("Location: assignments.php");
    } else {
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Read an Assignment</h3>
                    </div>
                     
                    <div class="form-horizontal" >
                    
					
					  <div class="control-group">
                        <label class="control-label">Customer</label>
                        <div class="controls">
						 <label class="checkbox">
						<?php
						$pdo = Database::connect();
						$sql = 'SELECT * FROM customers ORDER BY id DESC';
						foreach ($pdo->query($sql) as $row) {
							if($row['id']  == $cid){
								echo  $row['name'] ;
							}	
						}
						Database::disconnect();
						?>
						  </label>
                        </div>
                      </div>
              
					  <div class="control-group">
                        <label class="control-label">Event</label>
                        <div class="controls">
						 <label class="checkbox">
						<?php
						$pdo = Database::connect();
						$sql = 'SELECT * FROM events';
						foreach ($pdo->query($sql) as $row) {
							if($row['id']  == $eid){
								echo  trim($row['description']) . " " . "(" . trim($row['location']) . ")" ;
							}	
						}
						Database::disconnect();
						?>
						  </label>
                        </div>
                      </div>
					
					  <div class="control-group">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <label class="checkbox">
                                <?php echo $data['comment'];?>
                            </label>
                        </div>
                      </div>
					  
                        <div class="form-actions">
                          <a class="btn" href="assignments.php">Back</a>
                       </div>
                     
                      
                    </div>
                </div>
                 
    </div> <!-- /container -->
  </body>
</html>
