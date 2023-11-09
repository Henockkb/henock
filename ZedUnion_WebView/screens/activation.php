<?php
session_start();

$telephone = $_SESSION['telephone'];

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Compteur de Confirmation</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-color: #009688;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .counter {
            font-size: 48px;
            color: #fff;
        }

        .message {
            font-size: 24px;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="counter">20</div>
    <div class="message">secondes pour activer votre compte</div>

    <div id="success-alert" style="display: none;">
        <div class="alert alert-success" role="alert">
            Compte activé avec succès. Redirection en cours...
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        var countdown = 20;
        var counterElement = document.querySelector('.counter');
        var messageElement = document.querySelector('.message');
        var successAlert = document.getElementById('success-alert');

        var countdownInterval = setInterval(function() {
            countdown--;
            counterElement.textContent = countdown;
            if (countdown <= 0) {
                clearInterval(countdownInterval);
                counterElement.style.display = 'none'; 
                messageElement.style.display = 'none';
                successAlert.style.display = 'block'; 
                setTimeout(function() {
                    window.location.href = "user.php?telephone=<?php echo urlencode($telephone); ?>"; // Redirection vers la page de connexion
                }, 5000); 
            }
        }, 1000);
    </script>
</body>
</html>
