<?php
require_once 'core/init.php';

//echo Session::get(Config::get('session/session_name'));

if (Session::exists('home'))
{
    echo "<p>" . Session::flash('home') . "</p>";
}

$user = new User();

if ($user->isloggedIn())
{?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="style.css">
        <title>Document</title>
    </head>
    <body>
        <div class="on_profile">
            <div class="on_profile_link">
            <span>Profile: </span>
            <a class="profile_name" href="profile.php?user=<?php echo escape($user->data()->username)?>"><?php echo
                escape($user->data()
                    ->username) ?></a>
            </div>
            <div class="navigation">
                <ul>
                    <li><a href="changepassword.php">Change password</a></li>
                    <li><a href="update.php">Update name</a></li>
                    <li><a href="logout.php">Log out</a></li>
                </ul>
            </div>
        </div>


    </body>
    </html>

<?php
}else
{
    echo "<div class='login' style='display: flex; justify-content: center; height: 100vh; align-items: center'><a style='text-decoration:none; margin-top: 10px; display: flex; justify-content: center;
 align-items: center; border-radius: 3px; background-color: #f0ebeb; color: #737070; font-weight: bold; width: 100px; height: 100px;' href='login.php'>Login</a></div>";
}


