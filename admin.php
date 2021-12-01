<main>
    <?php
        if ($_SESSION['user']['valid'] == 'true') {
            if (!isset($action)) { $action = 1; }
            print '
            <h1>Administration</h1>
            <div id="admin">
                <ul>
                ';
                if ($_SESSION['user']['role'] === 'administrator') {
                print '
                    <li><a href="index.php?izbor=7&amp;action=1">Users</a></li>';
                } print '
                    <li><a href="index.php?izbor=7&amp;action=2">News</a></li>
                </ul>';
                # Admin Users
                if ($action == 1) { include("admin/users.php"); }

                # Admin News
                else if ($action == 2) { include("admin/news.php"); }
            print '
            </div>';
        }
        else {
            $_SESSION['message'] = '<p>Please register or login using your credentials!</p>';
            header("Location: index.php?izbor=6");
        }
    ?>
</main>