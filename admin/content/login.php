<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Primitive CMS Login</title>
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>

    <div id="login-container">
        <h1>Primitive CMS Login</h1>
        <form action="." method="post">
            <div>
                <label for="username_box">Username:</label>
                <input type="text" name="username" id="username_box">
            </div>
            <div>
                <label for="password_box">Password:</label>
                <input type="password" name="password" id="password_box">
            </div>
            <button type="submit" name="login" value="login">Login</button>
        </form>
    </div>

</body>

</html> 