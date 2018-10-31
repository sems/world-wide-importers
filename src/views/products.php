<?php
  foreach ($arrayProducts as $row) {
    print("<img src='data:image/png;base64,".base64_encode($row['Photo'])."'/>");
    print($row["StockItemName"] . "<br />");


    print("<script type='text/javascript'>
      (/\.(gif|jpg|jpeg|tiff|png)$/i).test(".$row['Photo'].")
    </script>");
  }
?>
