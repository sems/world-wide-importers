<?php
// For each produc print product photo (null) and add product name
if(sizeOf($arrayProducts) < 1) {
  echo 'Geen resultaten';
} else {
  foreach ($arrayProducts as $row) {
    // print photo
    print("<img width='50px' src='data:image/gif;base64,".base64_encode($row['Photo'])."'/>");
    //print name
    print($row["StockItemName"] . "<br />");
  }
}

?>


<?php
// // Use to validate photo extension
// print("<script type='text/javascript'>
//   (/\.(gif|jpg|jpeg|tiff|png)$/i).test(".$row['Photo'].")
// </script>");
?>
