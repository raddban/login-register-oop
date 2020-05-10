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
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ],
            'password' => [
                'required' => true,
                'min' => 6,
            ],
            'password_again' => [
                'required' => true,
                'matches' => 'password'
            ],
            'name' => [
                'required' => true,
                'min' => 2,
                'max' => 50,
            ],
            'email' => [
                'required' => true,
                'min' => 5,
                'max' => 100,
            ]
        ]);

        if ($validation->passed()) {
            $user = new User();

            try
            {
                $user->create([
                    'username'  => Input::get('username'),
                    'password'  => Hash::make(Input::get('password')),
                    'name'  => Input::get('name'),
                    'e_mail' => Input::get('email'),
                    'joined'  => date('Y-m-d H:i:s'),
                ]);

                Session::flash('home', 'You have been registered, and now can log in');
                Redirect::to('login.php');
            }catch (Exception $e)
            {
                die($e->getMessage());
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

<div class="register">
    <form action="" method="post">

        <div class="field">
            <label for="username">Username: </label>
            <input type="text" id="username" placeholder="username" name="username" value="<?php echo escape(Input::get
            ('username')) ?>"
                   autocomplete="off">
        </div>
        <div class="field">
            <label for="password">Password: </label>
            <input type="password" id="password" placeholder="password" name="password">
        </div>
        <div class="field">
            <label for="password_again">Password again: </label>
            <input type="password" id="password_again" placeholder="password" name="password_again">
        </div>
        <div class="field">
            <label for="name">Name: </label>
            <input type="text" id="name" placeholder="name" name="name" value="<?php echo escape(Input::get('name'))
            ?>">
        </div>
        <div class="field">
            <label for="email">Email: </label>
            <input type="email" id="name" placeholder="email" name="email" value="<?php echo escape(Input::get('email'))
            ?>">
        </div>
        <input type="hidden" name="token" value="<?php echo Token::generate()?>">
        <input type="submit" value="Register">
        <a href="login.php">Login</a>
    </form>

</div>

</body>
</html>

