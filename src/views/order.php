<?php
    // print_r($arrayOrders);
    // [0][0] orderID
?>
<div class="row">
    <div class="col-md-12">
        <div class="accordion" id="accordion_order">
            <div class="card">
                <div class="card-header" id="heading_address">
                    <h5 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse_delivery" aria-expanded="true" aria-controls="collapse_delivery">
                        Adressen
                    </button>
                    </h5>
                </div>

                <div id="collapse_delivery" class="collapse show" aria-labelledby="heading_address" data-parent="#accordion_order">
                    <div class="card-body">
                    Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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
                                      </div>
                                      <div class="col-md-4">
                                          <?php
                                          print("<script> \n function run_change_amount" . $key . "(){ \n var button" . $key . " = document.getElementById('send_button" . $key . "'); \n button" . $key . ".form.submit(); } \n </script>");
                                          //Delete product with a invisible field. Later we can use this field to see which product has been deleted
                                          ?>
                                          <span class="basket_product_price">Stukprijs: €<?php echo $data['UnitPrice']; ?></span>
                                      </div>
                                  </div>
                              </div>
                              <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
