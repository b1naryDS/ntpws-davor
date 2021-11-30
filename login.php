<main>
    <div class="news">
    <form action="" name="myForm" id="myForm" method="POST">
        <input type="hidden" id="action" name="action" value="TRUE">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="" pattern=".{5,10}" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="" pattern=".{4,}" required>

            <button name="login" id="login"/>Login</button><br/>
        </form>
<?php
    if(isset($_POST['login'])) {
        login($connection);
    }
?>
</div>
</main>