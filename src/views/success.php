<div class="row justify-content-md-center text-center succes-order">
    <div class="col-md-6">
        <?php print(getAlert()); ?>
        <i class="fas fa-check-circle"></i>
        <h3>Betaling gelukt!</h3>
        <p>De betaling van order <strong><?php print($orderID); ?></strong> is goed bij ons doorgekomen!</p>
        <p>Je zal een bestel- en betaalbevestiging hebben ontvangen op het opgegeven emailadres.</p>
        <?php 
        if (isset($_SESSION['logged_in'])) {
            ?>
            <p>Klik <a href="<?php print($linkToOrder); ?>">hier</a> om naar uw order overzicht te gaan.</p>
            <?php
        }
        ?>
    </div>
</div>