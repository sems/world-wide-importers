<div class="row justify-content-md-center text-center failed-order">
    <div class="col-md-6">
        <?php print(getAlert()); ?>
        <i class="fas fa-times-circle"></i>
        <h3>Betaling mislukt!</h3>
        <p>Er is iets misgegaan bij het betalen van order <strong><?php print($orderID); ?></strong>.</p>
        <p>Je zal enkel bestelbevestiging hebben ontvangen op het opgegeven emailadres.</p>
        <?php
        if (isset($_SESSION['logged_in'])) {
            ?>
        <p>Klik <a href="<?php print($linkToOrder); ?>">hier</a> om
            naar uw order te gaan en de betaling opnieuw uit te voeren.</p>
        <?php
        }
        ?>
    </div>
</div>