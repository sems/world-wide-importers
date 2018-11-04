<?php
// For each produc print product photo (null) and add product name
if(sizeOf($arrayProducts) < 1) {
  echo 'Geen resultaten';
} else {
  $i = 0;
  print("<div class='row'>");
  foreach ($arrayProducts as $row) {
    //if ($i == 0) {
      //print("<div class='row'>");
    //}

    print("<div class='col-md-4 products-top-margin'>
      <div class='card'>
        <a class='products-link' href='product.php?id=".$row['StockItemID']."'>
          <img class='card-img-top' src='data:image/gif;base64,".base64_encode($row['Photo'])."' />
        </a>");

    print("<div class='card-body'>");
    print("<a class='products-link' href='product.php?id=".$row['StockItemID']."'>
      <span class='product-name'>".
      $row['StockItemName'].
      "</span></a><br /><span class='product-price'>".
      "&euro;".$row['UnitPrice'].
      "</span>");
    
    print("</div></div></div>");
    //if ($i == 2) {
      //print("</div>");
      //$i = 0;
      //continue;
    //}
    //$i++;

    // print photo
    //print("<a href='product.php?id=".$row['StockItemID']."'><img width='50px' src='data:image/gif;base64,".base64_encode($row['Photo'])."'/>");
    //print name
    //print($row['StockItemName'] . "</a><br />");
  }
  print("</div>");
}

?>


<?php
// // Use to validate photo extension
// print("<script type='text/javascript'>
//   (/\.(gif|jpg|jpeg|tiff|png)$/i).test(".$row['Photo'].")
// </script>");
?>