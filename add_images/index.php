<?php
session_start();
define('DBHOST','localhost');
define('DBNAME','wideworldimporters');
define('DBUSER','root');
define('DBPASS','');

$dbh = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$data0 = file_get_contents('foto_voor_kbs/diverse/USB/usb_1.jpg');
$stmt0 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (1, 3, 6, 8, 11)");
$stmt0->bindParam(1,$data0);
$stmt0->execute();

$data1 = file_get_contents('foto_voor_kbs/diverse/USB/usb_2.jpg');
$stmt1 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (2, 7, 12, 13, 5)");
$stmt1->bindParam(1,$data1);
$stmt1->execute();

$data2 = file_get_contents('foto_voor_kbs/diverse/USB/usb_3.jpg');
$stmt2 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (4, 9, 10, 14, 15)");
$stmt2->bindParam(1,$data2);
$stmt2->execute();

$data25 = file_get_contents('foto_voor_kbs/mokken/mok_1.jpg');
$stmt25 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29)");
$stmt25->bindParam(1,$data25);
$stmt25->execute();

$data3 = file_get_contents('foto_voor_kbs/mokken/mok_2.jpg');
$stmt3 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51)");
$stmt3->bindParam(1,$data3);
$stmt3->execute();

$data4 = file_get_contents('foto_voor_kbs/mokken/mok_3.jpg');
$stmt4 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (52, 53, 54, 55, 56, 57)");
$stmt4->bindParam(1,$data4);
$stmt4->execute();

$data5 = file_get_contents('foto_voor_kbs/speelgoed/rcauto/rc_1.jpg');
$stmt5 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (58, 59, 60, 61, 62, 63)");
$stmt5->bindParam(1,$data5);
$stmt5->execute();

$data6 = file_get_contents('foto_voor_kbs/speelgoed/rcauto/rc_2.jpg');
$stmt6 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (64, 65, 66, 67, 68, 69, 70)");
$stmt6->bindParam(1,$data6);
$stmt6->execute();

$data7 = file_get_contents('foto_voor_kbs/speelgoed/rcauto/rc_3.jpg');
$stmt7 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (71, 72, 73, 74, 75)");
$stmt7->bindParam(1,$data7);
$stmt7->execute();

$data8 = file_get_contents('foto_voor_kbs/kleren/t-shirt/model_tshirt.jpg');
$stmt8 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101)");
$stmt8->bindParam(1,$data8);
$stmt8->execute();

$data9 = file_get_contents('foto_voor_kbs/kleren/hoodie/hoodie_2.jpg');
$stmt9 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (102, 103, 104, 105, 106)");
$stmt9->bindParam(1,$data9);
$stmt9->execute();

$data10 = file_get_contents('foto_voor_kbs/kleren/jacket/jacket_3.jpg');
$stmt10 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117)");
$stmt10->bindParam(1,$data10);
$stmt10->execute();

$data11 = file_get_contents('foto_voor_kbs/kleren/pantoffel/pantoffel_1.jpg');
$stmt11 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (118, 119, 120, 121, 122, 123, 124, 125)");
$stmt11->bindParam(1,$data11);
$stmt11->execute();

$data12 = file_get_contents('foto_voor_kbs/kleren/pantoffel/pantoffel_2.jpg');
$stmt12 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (126, 127, 128, 129)");
$stmt12->bindParam(1,$data12);
$stmt12->execute();

$data13 = file_get_contents('foto_voor_kbs/kleren/pantoffel/pantoffel_3.jpg');
$stmt13 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (130, 131, 132, 133, 134, 135, 136, 137)");
$stmt13->bindParam(1,$data13);
$stmt13->execute();

$data14 = file_get_contents('foto_voor_kbs/kleren/sokken/sok_4.jpg');
$stmt14 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (138, 139, 140, 141)");
$stmt14->bindParam(1,$data14);
$stmt14->execute();

$data15 = file_get_contents('foto_voor_kbs/diverse/snufjes/snuf_1.jpg');
$stmt15 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (142, 143, 144, 145)");
$stmt15->bindParam(1,$data15);
$stmt15->execute();

$data16 = file_get_contents('foto_voor_kbs/diverse/snufjes/snuf_1.jpg');
$stmt16 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (146, 147, 148, 149)");
$stmt16->bindParam(1,$data16);
$stmt16->execute();

$data17 = file_get_contents('foto_voor_kbs/speelgoed/actiefiguren/actionfigure_1.PNG');
$stmt17 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (150, 151)");
$stmt17->bindParam(1,$data17);
$stmt17->execute();

$data18 = file_get_contents('foto_voor_kbs/speelgoed/actiefiguren/actionfigure_2.jpg');
$stmt18 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (152)");
$stmt18->bindParam(1,$data18);
$stmt18->execute();

$data19 = file_get_contents('foto_voor_kbs/verpakking/bubblewrap/bubble_1.jpg');
$stmt19 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (153, 154, 155, 156, 157, 158, 159, 160, 161, 162, 163, 164)");
$stmt19->bindParam(1,$data19);
$stmt19->execute();

$data20 = file_get_contents('foto_voor_kbs/verpakking/bubblewrap/bubble_2.jpg');
$stmt20 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (165, 166, 167, 168, 169, 170, 171, 172, 173, 174, 175, 176)");
$stmt20->bindParam(1,$data20);
$stmt20->execute();

$data21 = file_get_contents('foto_voor_kbs/verpakking/dozen/doos_1.jpg');
$stmt21 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (177, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186, 187, 188, 189, 190)");
$stmt21->bindParam(1,$data21);
$stmt21->execute();

$data22 = file_get_contents('foto_voor_kbs/verpakking/dozen/doos_2.jpg');
$stmt22 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (191, 192, 193, 194, 195, 196, 197, 198, 199, 200, 201, 202, 203, 204, 205)");
$stmt22->bindParam(1,$data22);
$stmt22->execute();

$data23 = file_get_contents('foto_voor_kbs/verpakking/dozen/doos_3.jpg');
$stmt23 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218, 219)");
$stmt23->bindParam(1,$data23);
$stmt23->execute();

$data24 = file_get_contents('foto_voor_kbs/diverse/snufjes/snuf_3.jpg');
$stmt24 = $dbh->prepare("update stockitems set Photo=? where StockItemID IN (220, 221, 222, 223, 224, 225, 226, 227)");
$stmt24->bindParam(1,$data24);
$stmt24->execute();

$stmt = $dbh->prepare("CREATE TABLE pictures ( 
StockItemID int(11) NOT NULL,
Image blob NOT NULL,
FOREIGN KEY (StockItemID) REFERENCES stockitems (StockItemID))");
$stmt->execute();
$dbh = NULL;

function addimages($param1, $param2, $param3, $param4){
    $dbh = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = file_get_contents($param1);
    $data1 = file_get_contents($param2);
    $data2 = file_get_contents($param3);
    $stmt = $dbh->prepare("insert into pictures values (".$param4.", ?), (".$param4.", ?), (".$param4.", ?)");
    $stmt->bindParam(1,$data);
    $stmt->bindParam(2,$data1);
    $stmt->bindParam(3,$data2);
    $stmt->execute();
    $dbh = NULL;
}

function addimages4($param1, $param2, $param3, $param4, $param5){
    $dbh = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $data = file_get_contents($param1);
    $data1 = file_get_contents($param2);
    $data2 = file_get_contents($param3);
    $data3 = file_get_contents($param4);
    $stmt = $dbh->prepare("insert into pictures values (".$param5.", ?), (".$param5.", ?), (".$param5.", ?), (".$param5.", ?)");
    $stmt->bindParam(1,$data);
    $stmt->bindParam(2,$data1);
    $stmt->bindParam(3,$data2);
    $stmt->bindParam(4,$data3);
    $stmt->execute();
    $dbh = NULL;
}

for($i = 1; $i < 16; $i++){
    addimages('foto_voor_kbs/diverse/USB/usb_1.jpg', 'foto_voor_kbs/diverse/USB/usb_2.jpg', 'foto_voor_kbs/diverse/USB/usb_3.jpg', $i);
}
for($i = 16; $i < 58; $i++){
    addimages('foto_voor_kbs/mokken/mok_1.jpg', 'foto_voor_kbs/mokken/mok_2.jpg', 'foto_voor_kbs/mokken/mok_3.jpg', $i);
}

for($i = 58; $i < 76; $i++){
    addimages('foto_voor_kbs/speelgoed/rcauto/rc_1.jpg', 'foto_voor_kbs/speelgoed/rcauto/rc_2.jpg', 'foto_voor_kbs/speelgoed/rcauto/rc_3.jpg', $i);
}

for($i = 76; $i < 102; $i++){
    addimages4('foto_voor_kbs/kleren/t-shirt/model_tshirt.jpg', 'foto_voor_kbs/kleren/t-shirt/voorkant_tshirt.jpg', 'foto_voor_kbs/kleren/t-shirt/achterkant_tshirt.jpg', 'foto_voor_kbs/kleren/t-shirt/zijkant_tshirt.jpg', $i);
}

for($i = 102; $i < 107; $i++){
    addimages('foto_voor_kbs/kleren/hoodie/hoodie_2.jpg', 'foto_voor_kbs/kleren/hoodie/hoodie_0.jpg', 'foto_voor_kbs/kleren/hoodie/hoodie_1.jpg', $i);
}

for($i = 107; $i < 118; $i++){
    addimages('foto_voor_kbs/kleren/jacket/jacket_3.jpg', 'foto_voor_kbs/kleren/jacket/jacket_1.jpg', 'foto_voor_kbs/kleren/jacket/jacket_2.jpg', $i);
}

for($i = 118; $i < 126; $i++){
    addimages('foto_voor_kbs/kleren/pantoffel/pantoffel_1.jpg', 'foto_voor_kbs/kleren/pantoffel/pantoffel_2.jpg', 'foto_voor_kbs/kleren/pantoffel/pantoffel_3.jpg', $i);
}

for($i = 126; $i < 130; $i++){
    addimages4('foto_voor_kbs/kleren/sokken/sok_4.jpg','foto_voor_kbs/kleren/sokken/sok_1.jpg', 'foto_voor_kbs/kleren/sokken/sok_2.jpg', 'foto_voor_kbs/kleren/sokken/sok_3.jpg', $i);
}

for($i = 142; $i < 150; $i++){
    addimages('foto_voor_kbs/diverse/snufjes/snuf_1.jpg', 'foto_voor_kbs/diverse/snufjes/snuf_2.jpg', 'foto_voor_kbs/diverse/snufjes/snuf_3.jpg', $i);
}

for($i = 150; $i < 153; $i++){
    addimages('foto_voor_kbs/speelgoed/actiefiguren/actionfigure_1.PNG', 'foto_voor_kbs/speelgoed/actiefiguren/actionfigure_2.jpg', 'foto_voor_kbs/speelgoed/actiefiguren/actionfigure_3.jpeg', $i);
}

for($i = 153; $i < 177; $i++){
    addimages('foto_voor_kbs/verpakking/bubblewrap/bubble_1.jpg', 'foto_voor_kbs/verpakking/bubblewrap/bubble_2.jpg', 'foto_voor_kbs/verpakking/bubblewrap/bubble_3.jpg', $i);
}

for($i = 177; $i < 220; $i++){
    addimages('foto_voor_kbs/verpakking/dozen/doos_1.jpg', 'foto_voor_kbs/verpakking/dozen/doos_2.jpg', 'foto_voor_kbs/verpakking/dozen/doos_3.jpg', $i);
}

for($i = 220; $i < 228; $i++){
    addimages('foto_voor_kbs/diverse/snufjes/snuf_1.jpg', 'foto_voor_kbs/diverse/snufjes/snuf_2.jpg', 'foto_voor_kbs/diverse/snufjes/snuf_3.jpg', $i);
}