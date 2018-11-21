<div class="row">
    <div class="col-md-12">
        <h4>Order <?php print($_GET['id']);?></h4>
        <div class="accordion" id="accordion_order">
            <div class="card">
                <div class="card-header" id="heading_payment">
                    <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_payment" aria-expanded="true" aria-controls="collapse_payment">
                        Betaling(en)
                    </button>
                    </h5>
                </div>
                <div id="collapse_payment" class="collapse" aria-labelledby="heading_payment" data-parent="#accordion_order">
                  <div class="md-col-12">
                    <div class="card-body row">
                        
                    </div>
                  </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="heading_address">
                    <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_delivery" aria-expanded="true" aria-controls="collapse_delivery">
                        Adressen
                    </button>
                    </h5>
                </div>
                <div id="collapse_delivery" class="collapse" aria-labelledby="heading_address" data-parent="#accordion_order">
                  <div class="md-col-12">
                    <div class="card-body row">
                      <div class="md-col-6">
                        <div class="card-body">
                          <h5>Afleveringsadres</h5>
                          <div>
                            <?php print($arrayOrders[0]['DeliveryAddressLine1'] . $arrayOrders[0]['DeliveryAddressLine2'] . '<br />' . $arrayOrders[0]['DeliveryPostalCode'] . '<br />' . $arrayOrders[0]['CityName']); ?>
                          </div>
                        </div>
                      </div>
                      <div class="md-col-6">
                        <div class="card-body float-right">
                          <h5>Postadres</h5>
                          <div>
                            <?php print($arrayOrders[0]['PostalAddressLine1'] . '<br />' . $arrayOrders[0]['PostalPostalCode'] . '<br />' . $arrayOrders[0]['CityName']); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="heading_content">
                    <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_content" aria-expanded="true" aria-controls="collapse_content">
                        Inhoud bestelling
                    </button>
                    </h5>
                </div>

                <div id="collapse_content" class="collapse show" aria-labelledby="heading_content" data-parent="#accordion_order">
                    <div class="card-body">
                        <?php
                            $totalPrice = 0;
                            foreach ($arrayOrders as $data) {
                              ?>
                              <div class='col-md-12'>
                                  <div class="row basket_product">
                                      <?php
                                      ?> <div class='col-md-3'> <?php print(strlen($data['Photo']) < 1 ? "<img src='http://placehold.it/150x150' />":"<img src='data:image/gif;base64,".base64_encode($data['Photo'])."'/>");
                                      ?> </div>
                                      <div class="col-md-5">
                                          <h6><?php print($data['Description']);?></h6>
                                          <p><?php print(!empty($data['Size']) ? "Grootte: " . $data['Size']: "Geen grootte"); ?></p>
                                          <p><?php print('Aantal: ' . $data['Quantity']) ?></p>
                                      </div>
                                      <div class="col-md-4">
                                          <?php
                                          print("<script> \n function run_change_amount" . $key . "(){ \n var button" . $key . " = document.getElementById('send_button" . $key . "'); \n button" . $key . ".form.submit(); } \n </script>");
                                          //Delete product with a invisible field. Later we can use this field to see which product has been deleted
                                          ?>
                                          <span class="basket_product_price">Stukprijs: €<?php echo $data['UnitPrice']; ?></span>
                                          <span class="basket_product_price"><strong>Subtotaal: €<?php print(number_format($data['Quantity'] * $data['UnitPrice'], 2)) ; ?></strong></span>
                                      </div>
                                  </div>
                              </div>
                              <?php 
                              $totalPrice = $totalPrice + ($data['Quantity'] * $data['UnitPrice']);
                            }
                        ?>
                        <div class="col-md-12">
                          <div class="row basket_product">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-4">
                              <p>Verzendkosten: €0.00</p>
                              <span class="basket_product_price"><strong>Totaal: €<?php print(number_format($totalPrice, 2)); ?></strong></span>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
