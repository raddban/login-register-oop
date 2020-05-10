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
            'name' => [
                'required' => true,
                'min'   => 2,
                'max'   => 50
            ],
            'email' => [
                'required' => false,
                'min'   => 5,
                'max'   => 100
            ]
        ]);

        if ($validation->passed())
        {
            try
            {
                $user->update([
                    'name' => Input::get('name'),
                    'e_mail' => Input::get('email')
                ]);

                Session::flash('home', 'Your details have been updated');
                Redirect::to('index.php');
            }catch (Exception $e)
            {
                die($e->getMessage());
            }
        }
        else
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
<div class="update">

    <form action="" method="post">
        <div class="field">
            <h2>Hello <?php echo escape($user->data()->name)?></h2>
            <small>Full name update</small>
        </div>
        <div class="field update_field">
            <label for="name"></label>
            <input type="text" name="name" id="name" placeholder="<?php echo escape($user->data()->name)?>">

            <label for="email"></label>
            <input type="email" name="email" id="email" placeholder="<?php echo escape($user->data()->e_mail)?>">

            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
            <input type="submit" value="Update">
        </div>
    </form>

</div>
</body>
</html>
