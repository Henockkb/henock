<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZedUnion</title>
    <style>
        body {
            background: #009688;
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .button-container {
            background-color: rgba(0, 0, 0, 0.5); 
            padding: 10px;
            text-align: center;
        }

        .button {
            margin: 10px;
            padding: 10px 20px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="button-container">
        <a href="login.php" class="button">Login</a>
        <a href="signup.php" class="button">Signup</a>
    </div>
</body>
</html>