<div class="text-center">
    <form class="form-signin" method="post" action="f_login.php">
        <h1 class="h3 mb-3 font-weight-normal">Login</h1>
        <?php print(getAlert()); ?>

        <label for="inputEmail" class="sr-only">Emailadres</label>
        <input type="email" name="logonMail" class="form-control" placeholder="Emailadres" required autofocus>

        <label for="inputPassword" class="sr-only">Wachtwoord</label>
        <input type="password" name="password" class="form-control" placeholder="Wachtwoord" required>

        <div class="g-recaptcha" data-sitekey="6LcD2ngUAAAAAHXz1YsKDMeS7kZDIf02OMiLgCN3"></div>
        
        <button class="btn btn-lg btn-primary btn-block" type="submit">Inloggen</button>
        <a class="registreer" href="register.php">Nog geen account? Registreer nu</a>
    </form>
</div>
