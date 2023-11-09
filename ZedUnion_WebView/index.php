<!DOCTYPE html>
<html>
<head>
    <title>loading</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            padding: 0;
            background: white;
        }

        .container-fluid {
            height: 100%;
        }

        .profile-image {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .bot-name {
            color: #FFFFFF;
            font-weight: bold;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        .loading-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .loading-text {
            margin-top: 20px;
            font-size: 17px;
            text-align: center;
            font-weight: bold;
        }

        .loader {
            margin-top: 10px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-container {
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @media (max-width: 768px) {
            .container {
                padding: 50px 20px;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="loading">
        <div class="loading-container">
            <div class="loading-content">
                <div class="loading-text"><img src="assets/images/logo.png" class="profile-image" alt="Bot Profile Image"><br><br>ZedUnion</div>
                <div class="loader"></div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.location.href = 'screens/zedunion.php';
            }, 5000);
        });
    </script>
</body>
</html>
