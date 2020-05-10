<?php
require_once 'core/init.php';

if (Input::exists())
{
    if (Token::check(Input::get('token')))
    {
        $validate = new Validate();
        $validation = $validate->check($_POST, [
            'username' => [
                'required' => true,
            ],
            'password' => [
                'required' => true,
            ]
        ]);
        if ($validation->passed())
        {
            $user = new User();

            $login = $user->login(Input::get('username'), Input::get('password'));

            if ($login)
            {
                Redirect::to('index.php');
            }else
            {
                echo "Sorry, login fail";
            }
        } else {
            foreach ($validation->errors() as $error) {
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
    <div class="login_container">
        <form action="" method="post">

            <div class="field">
                <label for="username">Username: </label>
                <input type="text" name="username" id="username" autocomplete="off" placeholder="username">
            </div>

            <div class="field">
                <label for="password">Password: </label>
                <input type="password" name="password" id="password" autocomplete="off" placeholder="password">
            </div>

            <input type="hidden" name="token" value="<?php echo Token::generate();?>">

            <input type="submit" value="Log In">
            <a href="register.php">Register</a>
        </form>
    </div>
</body>
</html>

