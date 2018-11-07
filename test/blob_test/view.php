<?php
session_start();
define('DBHOST','localhost');
define('DBNAME','wideworldimporters');
define('DBUSER','root');
define('DBPASS','root');

$dbh = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>

<?php
$id = isset($_GET['id']) ? $_GET['id'] : "";
$stat = $dbh->prepare("select * from stockitems where StockItemID=?");
$stat->bindParam(1, $id);
$stat->execute();
$row = $stat->fetch();
echo "<img src='data:image/gif;base64,".base64_encode($row['Photo'])."'/>";
?>
