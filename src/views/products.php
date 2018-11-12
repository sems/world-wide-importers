<div class="row">
  <div class="col-md-4">
    <form action='products.php' method='get'>
      <?php
        if (isset($_GET['filter'])) {
          // Check if filter isset, if so add hidden name and value of filter to form
          echo '<input type="hidden" name="filter" value="'.$_GET['filter'].'" />';
        }
      ?>
      <div class="input-group mb-3">
        <select name='order' class="custom-select" id="inputGroupSelect02">
          <option selected disabled>Sorteer...</option>
          <option value='ASC'>Van laag naar hoog</option>
          <option value='DESC'>Van hoog naar laag</option>
        </select>
        <div class="input-group-append">
          <button class="input-group-text" for="inputGroupSelect02" type='submit'>Zoek</button>
        </div>
      </div>
    </form>
  </div>

  <?php
    // For each produc print product photo (or fallback photo) and add product name
    if(sizeOf($arrayProducts) < 1) {
      echo 'Geen resultaten';
    } else {
      $i = 0;
      print("<div class='card-deck product-row-margin'>");
      foreach ($arrayProducts as $row) {
        print("<div class='col-md-4 products-top-margin '>
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
</div>