<?php
    print_r($order);
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
                            foreach ($order as $key => $value) {
                                $item = $key['StockItemID'];
                                $data = $db->prepare("SELECT StockItemName, Size, Photo, UnitPrice FROM stockitems WHERE StockItemID = :stock_item");
                                $data->execute(['stock_item' => $item]);
                                $data = $data->fetch();
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
