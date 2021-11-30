<form action="" method="post">
    <label>Ime</label><br/>
    <input type="text" id="ime" name="ime"/><br/>
    <label>Prezime</label><br/>
    <input type="text" id="prezime" name="prezime"/><br/>
    <label>Adresa e-pošte</label><br/>
    <input type="email" id="email" name="email"/><br/>
    <label>Lozinka</label><br/>
    <input type="password" id="sifraA" name="sifraA"><br/>
    <label>Potvrda lozinke</label><br/>
    <input type="password" id="sifraB" name="sifraB"><br/>
    <label>Država</label><br/>
    <select name="zemlja" id="zemlja"><?php popuni()?></select><br/>
    <label>Grad</label><br/>
    <input type="text" id="grad" name="grad"><br/>
    <label>Ulica</label><br/>
    <input type="text" id="ulica" name="ulica"><br/>
    <label>Datum rođenja</label><br/>
    <input type="date" id="rodjenje" name="rodjenje"><br/>
    <br/>
    <input type="submit" value="Registriraj me" id="registracija"/><br/>
</form>
<?php register($connection) ?>