<?php
session_start();
define('DBHOST','localhost');
define('DBNAME','wideworldimporters');
define('DBUSER','root');
define('DBPASS','root');

$dbh = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<!DOCTYPE html>
<html>
<head>  <title>hoi</title>
</head>
	<body>
    <?php
    if (isset($_POST['btn'])) {
    	$name = $_FILE['myfile']['name'];
    	$type = $_FILE['myfile']['type'];
    	$data = file_get_contents($_FILES['myfile']['tmp_name']);
    	$stmt = $dbh->prepare("update stockitems set Photo=? where StockItemID=?");
    	$stmt->bindParam(1,$data);
      $stmt->bindParam(2,$_POST['id']);
    	$stmt->execute();
    }
    ?>
  	<form method="post" enctype="multipart/form-data">
  		<input type="file" name="myfile" /><br />
      StockItemID: <input type="text" name="id" /><br />
  		<button name="btn">Upload</button>
  	</form>
  	<p></p><br /><br />
  	<ol>
  		<?php
  			$stat = $dbh->prepare("select * from stockitems");
  			$stat->execute();
  			while($row = $stat->fetch()){
  				echo "<li><a target='_blank' href='view.php?id=".$row['StockItemID']."'>".$row['StockItemName']."</a></li>";
  			}
    	 ?>
  	 </ol>

	</body>
</html>
