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
<!-------------  upload a CSV in PDO ---------------->
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

<!------------- If Comma(,) character in any string in CSV file, Use the PHP Script----------------->
<?php
$databasehost = "localhost"; 
$databasename = "import"; 
$databasetable = "import"; 
$databaseusername="username"; 
$databasepassword = "password"; 
$fieldseparator = ","; 
$lineseparator = "\n";

$enclosedby = "\"";

$csvfile = "test.csv";

if(!file_exists($csvfile)) {
    die("File not found. Make sure you specified the correct path.");
}

try {
    $pdo = new PDO("mysql:host=$databasehost;dbname=$databasename", 
        $databaseusername, $databasepassword,
        array(
            PDO::MYSQL_ATTR_LOCAL_INFILE => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        )
    );
} catch (PDOException $e) {
    die("database connection failed: ".$e->getMessage());
}

$pdo->exec("TRUNCATE TABLE `$databasetable`");

    /* ----------- Start of Babu Codes ------------ */
					/* $target_dir = "uploads/";
					$target_file = $target_dir . basename($_FILES["customer_upload"]["name"]);

							
					
					if(move_uploaded_file($_FILES["customer_upload"]["tmp_name"], $target_file)) {//

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
					} else {
						$sucess = "Error occurred";
					} */

					$target_file = $_FILES["customer_upload"]["tmp_name"];

					$fieldseparator = ","; 
					$lineseparator = "\n";
					$affectedRows = $db->exec("
					LOAD DATA LOCAL INFILE ".$db->quote($target_file)." REPLACE INTO TABLE `temp_promocode_customer_master`
					FIELDS TERMINATED BY ".$db->quote($fieldseparator)."
    				ENCLOSED BY ".$pdo->quote($enclosed)."  
					LINES TERMINATED BY ".$db->quote($lineseparator)." 
					IGNORE 1 LINES
					(user_id,hash)
					SET batch_id=".$batch_id);

					if(!$affectedRows){
						$sucess = "Error occurred";
					}

					/* ----------- End of Babu Codes ------------ */

echo "Loaded a total of $affectedRows records from this csv file.\n";

?>