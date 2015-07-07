<?php
/**
 * filename	: createEvent.php
 * author	: David Roof 
 * course	: CIS 355
 * purpose	: this program creates new events and stores them in a sql table
 * design	: 
 *			1. Check user input on POSTBACK before inserting to table
 *			2. Display the table with the information from previous unsuccessful submission 
 *			3. Submit to table
*/     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $date = null;
        $time = null;
        $location = null;
        $description = null;
        // keep track post values
        $date = $_POST['date'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        // validate input
        $valid = true;
        if (empty($date)) {
            $dateError = 'Please enter a Date';
            $valid = false;
        }
         
        if (empty($time)) {
            $timeError = 'Please enter a Time';
            $valid = false;
        }
         
        if (empty($location)) {
            $locationError = 'Please enter a Location';
            $valid = false;
        }
         
		if (empty($description)) {
            $descriptionError = 'Please enter a Description';
            $valid = false;
        } 
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO events (date,time,location,description) values(?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($date,$time,$location,$description));
            Database::disconnect();
            header("Location: Event.php");
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
                        <h3>Create an Event</h3>
                    </div>
             
                    <form class="form-horizontal" action="createEvent.php" method="post">
                      <div class="control-group <?php echo !empty($dateError)?'error':'';?>">
                        <label class="control-label">Date</label>
                        <div class="controls">
                            <input name="date" type="text"  placeholder="Date" value="<?php echo !empty($date)?$date:'';?>">
                            <?php if (!empty($dateError)): ?>
                                <span class="help-inline"><?php echo $dateError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($timeError)?'error':'';?>">
                        <label class="control-label">Time</label>
                        <div class="controls">
                            <input name="time" type="text" placeholder="Time" value="<?php echo !empty($time)?$time:'';?>">
                            <?php if (!empty($timeError)): ?>
                                <span class="help-inline"><?php echo $timeError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($locationError)?'error':'';?>">
                        <label class="control-label">Location</label>
                        <div class="controls">
                            <input name="location" type="text"  placeholder="Location" value="<?php echo !empty($location)?$location:'';?>">
                            <?php if (!empty($locationError)): ?>
                                <span class="help-inline"><?php echo $locationError;?></span>
                            <?php endif;?>
                        </div>
						
						
						
                      </div>
					   <div class="control-group <?php echo !empty($descriptionError)?'error':'';?>">
                        <label class="control-label">Description</label>
                        <div class="controls">
                            <input name="description" type="text"  placeholder="Description" value="<?php echo !empty($description)?$description:'';?>">
                            <?php if (!empty($descriptionError)): ?>
                                <span class="help-inline"><?php echo $descriptionError;?></span>
                            <?php endif;?>
                        </div>
					  </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create</button>
                          <a class="btn" href="Event.php">Back</a>
                        </div>
                    </form>
                </div>
     </div> <!-- /container -->
  </body>
</html>
