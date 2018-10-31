<?php
// For each produc print product photo (null) and add product name
foreach ($arrayProducts as $row) {
  // print photo
  print("<img src='data:image/png;base64,".base64_encode($row['Photo'])."'/>");
  //print name
  print($row["StockItemName"] . "<br />");
}
?>

<?php
// // Use to validate photo extension
// print("<script type='text/javascript'>
//   (/\.(gif|jpg|jpeg|tiff|png)$/i).test(".$row['Photo'].")
// </script>");
?>
