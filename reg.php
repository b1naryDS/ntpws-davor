<main>
    <div class="news">
    <form action="" method="post">
    <label>Ime</label><br/>
    <input type="text" id="name" name="name"/><br/>
    <label>Username</label><br/>
    <input type="text" id="username" name="username"/><br/>
    <label>Prezime</label><br/>
    <input type="text" id="lastname" name="lastname"/><br/>
    <label>Adresa e-pošte</label><br/>
    <input type="email" id="email" name="email"/><br/>
    <label>Lozinka</label><br/>
    <input type="password" id="password" name="password"><br/>
    <label>Potvrda lozinke</label><br/>
    <input type="password" id="passwordRepeat" name="passwordRepeat"><br/>
    <label>Država</label><br/>
    <select name="country" id="country"><?php popuni()?></select><br/>
    <label>Grad</label><br/>
    <input type="text" id="city" name="city"><br/>
    <label>Adresa</label><br/>
    <input type="text" id="address" name="address"><br/>
    <label>Datum rođenja</label><br/>
    <input type="date" id="dateofbirth" name="dateofbirth"><br/>
    <br/>
    <button name="reg" id="reg"/>Register</button><br/>
</form>
<?php
    if(isset($_POST['reg'])) {
        register($connection);
    }
?>
</div>
</main>