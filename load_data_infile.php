<?php
$dsn = 'mysql:host=localhost;dbname=databasename';
$dbuser = "dbusername";
$dbpass = "dbpassword";
$db = new PDO($dsn, $dbuser, $dbpass,
		 array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
        );
if ($db) {
//	echo "connection sucessfull";
} else {
	$dberror = $db->errorInfo();
	echo "Error code : " . $dberror[1] . "<br>";
	echo "Error name : " . $dberror[2] . "<br>";
}
?>
<?php
/* $cons= mysqli_connect("localhost", "root","root","promocode") or die(mysql_error());

						mysqli_query($cons, '
						    LOAD DATA LOCAL INFILE "'.$target_file.'"
						        INTO TABLE temp_promocode_customer_master
						        FIELDS TERMINATED by \',\'
						        LINES TERMINATED BY \'\n\'
								IGNORE 1 LINES
						        (user_id,hash)
						        SET batch_id='.$batch_id)or die(mysql_error());

						*/

						/* $query2=$db->prepare('
						    LOAD DATA LOCAL INFILE "'.$target_file.'"
						        INTO TABLE temp_promocode_customer_master
						        FIELDS TERMINATED by \',\'
						        LINES TERMINATED BY \'\n\'
								IGNORE 1 LINES
						        (user_id,hash)
						        SET batch_id=:batch_id');
						$query2->bindParam(':batch_id',$batch_id);
						//$query2->bindParam(':target_file',$target_file);
						$query2->execute(); */

							$fieldseparator = ","; 
							$lineseparator = "\n";
						  $affectedRows = $db->exec("
						    LOAD DATA LOCAL INFILE ".$db->quote($target_file)." REPLACE INTO TABLE `temp_promocode_customer_master`
						    FIELDS TERMINATED BY ".$db->quote($fieldseparator)." 
						    LINES TERMINATED BY ".$db->quote($lineseparator)." 
						    IGNORE 1 LINES
						        (user_id,hash)
						        SET batch_id=".$batch_id);
						  
						  if(!$affectedRows){
						  	$sucess = "Error occurred";
						  }
?>