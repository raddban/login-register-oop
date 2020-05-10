<?php

require_once 'core/init.php';

if (!$username = Input::get('user'))
{
    Redirect::to('index.php');
}else
{
    $user = new User($username);
    if (!$user->find($username))
    {
        Redirect::to(404);
    }else
    {
        $data = $user->data();
    }
?>
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
    <div class="back">
        <a href="index.php">Home</a>
    </div>
        <div class="profile">
            <h3>Hello <?php echo escape($data->username);?></h3>
            <p>This section is about section, from here you can update some info about yourself as well</p>
            <div class="profile_fields">
                <div class="profile_field">
                    <p>Full name: <?php echo escape($data->name)?> </p>
                    <a href="update.php">Update</a>
                </div>
                <div class="profile_field">
                    <p>Email: <?php echo escape($data->e_mail)?> </p>
                    <a href="update.php">Update</a>
                </div>
                <div class="profile_field">
                    <p>Age: <small>data from database</small> </p>
                    <a href="update.php">Update</a>
                </div>
                <div class="profile_field">
                    <p>Gender: <small>data from database</small></p>
                    <a href="update.php">Update</a>
                </div>
                <div class="profile_field">
                    <p>Image: <small>data from database</small> </p>
                    <a href="update.php">Update</a>

                </div>

            </div>
        </div>
    </body>
    </html>
<?php
}