<?php
session_start();

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=zedunion;', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}

function redirigerVersEspace($statut) {
    switch ($statut) {
        case 'admin':
            header('Location: ../administration/home.php');
            exit();
            break;
        case 'agent':
            header('Location: ../agents/home.php');
            exit();
            break;
        default:
            header('Location: ../public/home.php'); 
            exit();
            break;
    }
}


if (isset($_POST['submitForm'])) {
    if (!empty($_POST['telephone']) && !empty($_POST['motdepasse'])) {
        $telephone = htmlspecialchars($_POST['telephone'], ENT_QUOTES, 'UTF-8');
        $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);

        $recupUser = $pdo->prepare('SELECT * FROM users WHERE telephone = ?');
        $recupUser->execute(array($telephone));

        if ($recupUser->rowCount() > 0) {
            $user = $recupUser->fetch();
            if (password_verify($_POST['motdepasse'], $user['motdepasse'])) {
                $_SESSION['telephone'] = $telephone;
                $_SESSION['motdepasse'] = $motdepasse;
                $_SESSION['id'] = $user['id'];

                if (isset($_POST['seSouvenirDeMoi']) && $_POST['seSouvenirDeMoi'] == 'on') {
                    $expiration = time() + 7 * 24 * 60 * 60;
                    setcookie('nom', $nom, $expiration);
                }

                redirigerVersEspace($user['statut']);
            } else {
                $error = "Votre numéro ou mot de passe est incorrect";
            }
        } else {
            $error = "Votre numéro de téléphone ou mot de passe est incorrect";
        }
    } else {
        $error = "Veuillez remplir tous les champs";
    }
}
?>

<!DOCTYPE html>
<html lang="fr" class="dark-mode">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #009688;
        }

        .container {
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 800px; 
        }

        h1 {
            text-align: center;
            font-size: 25px;
            color: #333; 
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: bold;
            color: #333; 
        }

        .form-group i {
            margin-right: 5px;
        }

        .form-control {
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            font-size: 16px; 
        }

        .btn-success {
            color: #fff;
            width: 100%;
            padding: 10px;
            font-size: 16px; 
            border-radius: 15px;
            background: #009688;
        }

        .alert {
            margin-top: 20px;
        }

        @media (max-width: 767px) {
            .container {
                max-width: 90%; 
            }

            .form-control, .btn-success {
                font-size: 14px; 
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>ZedUnion</h1>
    <form method="POST" id="loginForm">
        <div class="form-group">
            <label for="telephone"><i class="fas fa-phone"></i> Numéro de téléphone :</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">🇨🇩 +243</span>
                </div>
                <input type="number" class="form-control" id="telephone" name="telephone">
            </div>
        </div>

        <div class="form-group">
            <label for="motdepasse"><i class="fas fa-lock"></i> Mot de passe :</label>
            <input type="password" class="form-control" id="motdepasse" name="motdepasse">
        </div>
        <button type="submit" class="btn btn-success" name="submitForm"><i class="fas fa-sign-in-alt"></i> Sign in</button>
    </form><br>
    <p style="color: black; text-align: center;">Pas de compte ? <a href="signup.php">Inscrivez-vous</a></p>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
