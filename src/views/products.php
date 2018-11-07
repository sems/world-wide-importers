<form action='products.php?filter=hoi' method='get'>
  <select name='order'>
    <option value='ASC'>Van laag naar hoog</option>
    <option value='DESC'>Van hoog naar laag</option>
  </select>
  <button type='submit'>Zoek</button>
</form>

<?php
// For each produc print product photo (null) and add product name
if(sizeOf($arrayProducts) < 1) {
  echo 'Geen resultaten';
} else {
  $i = 0;
  print("<div class='row'>");
  foreach ($arrayProducts as $row) {
    print("<div class='col-md-4 products-top-margin'>
      <div class='card'>
        <a class='products-link' href='product.php?id=".$row['StockItemID']."'>
          ".(strlen($row['Photo']) < 1 ? "<img class='card-img-top' src='img/image_not_found.png' />":"<img class='card-img-top' src='data:image/gif;base64,".base64_encode($row['Photo'])."'/>")."
        </a>");

    print("<div class='card-body'>");
    print("<table><tr><td><a class='products-link' href='product.php?id=".$row['StockItemID']."'>"
      .$row['StockItemName'].
      "</a></td><td class='product-price'>".
      "&euro;".$row['UnitPrice'].
      "</td></tr></table>");

    print("</div></div></div>");
  }
  print("</div>");
}

?>
