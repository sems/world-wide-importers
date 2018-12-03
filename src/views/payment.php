<div class="row justify-content-md-center">
    <div class="col-md-6">
        <h1 class="h3 mb-3 font-weight-normal">Betaling</h1>
        <?php print(getAlert()); ?>
        <article class="card">
            <div class="card-body p-6">
                <ul class="nav bg-light nav-pills rounded nav-fill mb-3" role="tablist">
                    <li class="nav-item disabled">
                        <a class="nav-link " href="#nav-tab-card">
                        <i class="fa fa-credit-card"></i> Credit Card</a>
                    </li>
                    <li class="nav-item disabled">
                        <a class="nav-link" href="#nav-tab-paypal">
                        <i class="fab fa-paypal"></i> Paypal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#nav-tab-ideal">
                        <i class="fa fa-money-bill-alt"></i> iDEAL</a>
                    </li>
                    <li class="nav-item disabled">
                        <a class="nav-link" href="#nav-tab-bank">
                        <i class="fa fa-university"></i> Overschrijving</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade " id="nav-tab-card">
                        <form role="form">
                            <div class="form-group">
                                <label for="username">Volledige naam (op de pas)</label>
                                <input type="text" class="form-control" name="username" placeholder="" required="">
                            </div>

                            <div class="form-group">
                                <label for="cardNumber">Kaartnummer</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="cardNumber" placeholder="0000-0000-0000-0000">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label><span class="hidden-xs">Verloopdatum</span> </label>
                                        <div class="input-group">
                                            <select class="form-control" name="expiry_month" id="">
                                                <?php 
                                                    for ($i=1; $i < 12; $i++) { 
                                                        print('<option value="'.$i.'">'.str_pad($i, 2, "0", STR_PAD_LEFT).'</option>');
                                                    }
                                                ?>
                                            </select>
                                            <select class="form-control" name="expiry_month" id="">
                                                <?php 
                                                    for ($i=2018; $i < 2028; $i++) { 
                                                        print('<option value="'.$i.'">'.$i.'</option>');
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label data-toggle="tooltip" title="" data-original-title="3 digits code on back side of the card">CVV <i class="fa fa-question-circle"></i></label>
                                        <input type="number" class="form-control" required="" placeholder="000">
                                    </div>
                                </div>
                            </div>
                            <button class="subscribe btn btn-primary btn-block" type="button"> Bevesting </button>
                        </form>
                    </div>

                    <div class="tab-pane fade" id="nav-tab-paypal">
                        <p>Paypal is een van de makkelijkste manieren om online te betalen</p>
                        <p>
                            <button type="button" class="btn btn-primary"> <i class="fab fa-paypal"></i> Login op mijn Paypal </button>
                        </p>
                    </div>
                
                    <div class="tab-pane fade show active" id="nav-tab-ideal">
                        <p>iDEAL is een van nederlands grootste betaalmethodes.</p>
                        <p>Totale prijs: &euro; <?php print (isset($_SESSION['totalprice'])) ? $_SESSION['totalprice'] : '0'; ?></p>
                        <p>
                            <form action="f_handler.php?form_handler=f_pay_ideal.php" method="post">
                                <button type="submit" class="btn btn-primary"> <i class="fa fa-money-bill-alt"></i> Betaal met iDEAL </button>
                            </form>
                        </p>
                    </div>

                    <div class="tab-pane fade" id="nav-tab-bank">
                        <p>Bank details</p>
                            <dl class="param">
                            <dt>Bank: </dt>
                            <dd>Rabobank</dd>
                        </dl>
                        <dl class="param">
                            <dt>BIC</dt>
                            <dd>RABONL2U</dd>
                        </dl>
                        <dl class="param">
                            <dt>IBAN: </dt>
                            <dd>NL10 RABO 0123 4567 89</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </article>
        <div class="progress progress-payment">
            <div class="progress-bar" role="progressbar" style="width: 67%" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <a class="btn btn-primary" href="placeorder.php">Terug</a>
    </div>
</div>