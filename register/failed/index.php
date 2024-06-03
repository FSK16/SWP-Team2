<?php
session_start();
if(isset($_SESSION['fehler']))
{
    $fehler = $_SESSION['fehler'];
    $_SESSION['fehler'] = null;

}
?><!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #3498db, #9b59b6);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.4);
            width: 800px;
            max-width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
        }

        .card-header {
            background: linear-gradient(135deg, #3498db, #9b59b6);
            color: #fff;
            border-radius: 15px 15px 0 0;
            text-align: center;
            padding: 20px;
            font-size: 36px;
        }
        .card-header p{
            font-size: 17px
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3498db, #9b59b6);
            border: none;
            border-radius: 15px;
            transition: background 0.3s, transform 0.3s;
            color: #fff;
            font-size: 20px;
            padding: 15px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2980b9, #8e44ad);
            transform: scale(1.02);
        }

        .tab-content {
            position: relative;
            animation: slide 0.5s forwards;
        }
        .button_confirmation{
            background: linear-gradient(135deg, #2382c1, #9032b7);
        }
        a{
            text-decoration: none;
            color: unset;
        }
        a:hover{
            text-decoration: none;
            color: unset;
        }

        @keyframes slide {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(0);
            }
        }
        .w50p{
            width: 50%;
        }
        .fl{
            float: left
        }
        .two_in_one{
            width: 100%;
            display: flow-root;
        }

        .two_in_one button{
            width: 48%;
            margin: 1%;
        }
        #first{
            background: linear-gradient(135deg, #2980b9, #445bad);
        }
        #second{
            background: linear-gradient(135deg, #4462ad, #8444ad);
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h4> Registrierung fehlgeschlagen </h4>
            <p> <?php echo $fehler?> </p>
            <div class="two_in_one">
                <div class="one_elemet">
                    <a href="../../">
                        <button id="first" class="btn btn-primary btn-block button_confirmation w50p fl">
                        Zur Startseite
                        </button>
                    </a>
                    <a href="../../Login+Regi.html">
                        <button id="second" class="btn btn-primary btn-block button_confirmation w50p fl">
                        Erneut versuchen
                        </button>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$_SESION['fehler'] = null;
?>
