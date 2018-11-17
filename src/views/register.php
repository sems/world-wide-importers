<div class="text-center">
    <form class="form-register" method="post" action="f_register.php">
        <h1 class="h3 mb-3 font-weight-normal">Registreren</h1>
        <?php print(getAlert()); ?>
        <label for="" class="sr-only">Emailadres</label>
        <input type="email" name="email" class="form-control" placeholder="Emailadres" required autofocus>

        <label for="" class="sr-only">Wachtwoord</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required>

        <label for="" class="sr-only">Wachtwoord opnieuw</label>
        <input type="password" name="repassword" class="form-control" placeholder="Re-enter Password" required>

        <label for="" class="sr-only">Volledige naam (voor en achternaam)</label>
        <input type="text" name="full_name" class="form-control" placeholder="John Doe" required>

        <label for="" class="sr-only">Voorkeur naam (gebruikersnaam)</label>
        <input type="text" name="preferred_name" class="form-control" placeholder="Nickname" required>

        <div class="g-recaptcha" data-sitekey="6LcD2ngUAAAAAHXz1YsKDMeS7kZDIf02OMiLgCN3"></div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Registreer</button>
    </form>
</div>
