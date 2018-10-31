<div class="text-center">
    <form class="form-register" method="post" action="f_register.php">
        <h1 class="h3 mb-3 font-weight-normal">Please register</h1>

        <label for="" class="sr-only">Email address</label>
        <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>

        <label for="" class="sr-only">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Password" required>

        <label for="" class="sr-only">Re-enter Password</label>
        <input type="password" name="repassword" class="form-control" placeholder="Re-enter Password" required>

        <label for="" class="sr-only">Full name (first and lastname)</label>
        <input type="text" name="full_name" class="form-control" placeholder="John Doe" required>

        <label for="" class="sr-only">Prefered name (nickname)</label>
        <input type="text" name="preferred_name" class="form-control" placeholder="Nickname" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    </form>
</div>
