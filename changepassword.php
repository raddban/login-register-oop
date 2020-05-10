<?php

require_once 'core/init.php';

$user = new User();

if (!$user->isloggedIn())
{
    Redirect::to('index.php');
}

if (Input::exists())
{
    if (Token::check(Input::get('token')))
    {
        $validate = new Validate();
        $validation = $validate->check($_POST, [
            'password_current' =>[
                'required'  => true,
                'min'   => 6
            ],
            'password_new' =>[
                'required'  => true,
                'min'   => 6
            ],
            'password_new_again' =>[
                'required'  => true,
                'matches'     => 'password_new'
            ],
        ]);

        if ($validation->passed())
        {
            if (Hash::make(Input::get('password_current')) != $user->data()->password)
            {
                echo "your current password is wrong";
            }
            else{
                $user->update([
                    'password' => Hash::make(Input::get('password_new'))
                ]);
                Session::flash('home', 'Your password have been updated');
                Redirect::to('index.php');
            }
        }else
        {
            foreach ($validation->errors() as $error)
            {
                echo $error . "<br>";
            }
        }
    }
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
<div class="password">
    <form action="" method="post">

        <div class="field">
            <label for="password_current">Current password: </label>
            <input type="password" name="password_current" id="password_current" placeholder="password">
        </div>
        <div class="field">
            <label for="password_new">New password: </label>
            <input type="password" name="password_new" id="password_new" placeholder="password">
        </div>
        <div class="field">
            <label for="password_new_again">Repeat new password: </label>
            <input type="password" name="password_new_again" id="password_new_again" placeholder="password">
        </div>

        <input type="hidden" name="token" value="<?php echo Token::generate();?>">
        <input type="submit" value="Change">

    </form>
</div>
</body>
</html>

