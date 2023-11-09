<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "zedunion";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = htmlspecialchars($_POST['nom'], ENT_QUOTES, 'UTF-8');
        $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8');
        $telephone = htmlspecialchars($_POST['telephone'], ENT_QUOTES, 'UTF-8'); // Ajout de +243
        $motdepasse = password_hash($_POST['motdepasse'], PASSWORD_DEFAULT);
        $statut = htmlspecialchars($_POST['statut'], ENT_QUOTES, 'UTF-8');
        $_SESSION['telephone'] = $telephone;
        $_SESSION['nom'] = $nom;
        $_SESSION['motdepasse'] = $motdepasse;

        if (empty($nom) || empty($mail) || empty($telephone) || empty($motdepasse) || empty($statut)) {
            $error = "Veuillez remplir tous les champs";
        } else {
            $stmt_check = $conn->prepare("SELECT * FROM users WHERE telephone = :telephone");
            $stmt_check->execute([':telephone' => $telephone]);

            if ($stmt_check->rowCount() > 0) {
                $error = "Ce numéro est déjà associé à un compte, veuillez utiliser un autre numéro";
            } else {
                $stmt = $conn->prepare("INSERT INTO users (nom, mail, telephone, motdepasse, statut) VALUES (:nom, :mail, :telephone, :motdepasse, :statut)");
                $stmt->execute([
                    ':nom' => $nom,
                    ':mail' => $mail,
                    ':telephone' => $telephone,
                    ':motdepasse' => $motdepasse,
                    ':statut' => $statut
                ]);

                $success = "L'utilisateur : $nom a été ajouté avec succès. Redirection en cours pour activer le compte";
                header("Refresh: 0; URL=activation.php");
            }
        }
    }

    $stmt = $conn->prepare("SELECT id, nom, mail, telephone, motdepasse, statut FROM users");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire d'inscription</title>
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
    <form method="POST" id="inscriptionForm">
        <div class="form-group">
            <label for="nom"><i class="fas fa-user"></i> Nom d'utilisateur :</label>
            <input type="text" class="form-control" id="nom" name="nom">
        </div>
        <div class="form-group">
            <label for="mail"><i class="fas fa-envelope"></i> Email :</label>
            <input type="text" class="form-control" id="mail" name="mail">
        </div>
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
        <div class="form-group">
            <i class="fas fa-building"></i> <label for="statut">Statut :</label>
            <select class="form-control form-control-large" name="statut" id="statut" readonly>
                <option value="public">Public</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success" name="submitForm"><i class="fas fa-sign-in-alt"></i> S'inscrire</button>
    </form><br>
    <p style="text-align: center; color: black;">Déjà un compte ? <a href="login.php">Connectez-vous</a></p>
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
