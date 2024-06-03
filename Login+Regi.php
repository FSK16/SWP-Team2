<?php
require_once 'conn.php';
?>

<!DOCTYPE html>
<html>
<head>
        <!-- Meta-Tag zur Anpassung der Anzeige und Steuerung des Layouts auf verschiedenen Geräten -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Einbindung der Bootstrap CSS-Bibliothek zur Nutzung von vordefinierten Stilen und Layouts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Einbindung einer externen benutzerdefinierten CSS-Datei -->
    <link rel="stylesheet" href="stylesheet/style.css">

    <style>
        body {
            background: linear-gradient(135deg, #3498db, #9b59b6);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
    </style>
        <!-- Titel der Webseite -->
    <title>Neues Nutzerkonto erstellen | Typus</title>
</head>
<body class="login_regi">
        <!-- Hauptcontainer im Card-Design von Bootstrap -->
    <div class="card">
                <!-- Kopfzeile der Karte -->
        <div class="card-header">
            Willkommen
        </div>
                <!-- Hauptinhalt der Karte -->
        <div class="card-body">
                        <!-- Navigationstabs für Login und Registrierung -->
            <ul class="nav nav-tabs card-header-tabs justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#login">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#register">Registrieren</a>
                </li>
            </ul>
                        <!-- Inhalt der Tabs -->
            <div class="tab-content">
                                <!-- Inhalt des Login-Tabs -->

                <div class="tab-pane fade show active" id="login">
                    <form action="login.php" method="POST" id="loginForm">
                        <div class="form-group">
                            <label for="loginUsername">Benutzername:</label>
                            <input type="text" name="name" class="form-control" id="loginUsername" required>
                        </div>
                        <div class="form-group">
                            <label for="loginPassword">Passwort:</label>
                            <input type="password" name="password" class="form-control" id="loginPassword" required>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                </div>

                <div class="tab-pane fade" id="register">
                    <form action="register.php" method="POST" id="registerForm">
                        <div class="form-group">
                            <label for="registerUsername">Benutzername:</label>
                            <input type="text" name="name" class="form-control" id="registerUsername" required>
                        </div>
                        <div class="form-group">
                            <label for="registerEmail">E-Mail-Adresse:</label>
                            <input type="email" name="email" class="form-control" id="registerEmail" required>
                        </div>
                        <div class="form-group">
                            <label for="registerPassword">Passwort:</label>
                            <input type="password" name="password" class="form-control" id="registerPassword" required> 
                        </div>
                        <div class="form-group">
                            <label for="registerCountry">Land:</label>
                            <select name="country" class="form-control" id="registerCountry" required>
                            <?php
                            $sql = "SELECT * FROM countries";
                            $result = $conn->query($sql);
                            if($result ->num_rows > 0)
                            {
                                while($row = $result->fetch_assoc())
                                {
                                    echo '<option value="'.$row['int_id'].'">'.$row['country_name'].'</option>';
                                }
                            }
                            ?>
                            </select>
                        </div>
                        <button type="submit" name="submit" class="btn btn-primary btn-block">Registrieren</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Einbindung von jQuery -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <!-- Einbindung von Popper.js, einer Bibliothek für dynamische Positionierung -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <!-- Einbindung der Bootstrap JS-Bibliothek für interaktive Elemente -->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function validateLoginForm() {
            const username = document.getElementById("loginUsername").value;
            const password = document.getElementById("loginPassword").value;
    
            if (username === "" || password === "") {
                alert("Bitte füllen Sie alle Felder aus.");
                return false;
            }
            // Weitere Validierungen hier hinzufügen (z.B. Regex für Benutzernamen und Passwort)
            return true;
        }
    
        function validateRegisterForm() {
            const username = document.getElementById("registerUsername").value;
            const email = document.getElementById("registerEmail").value;
            const password = document.getElementById("registerPassword").value;
            const country = document.getElementById("registerCountry").value;
    
            if (username === "" || email === "" || password === "" || country === "") {
                alert("Bitte füllen Sie alle Felder aus.");
                return false;
            }
    
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Bitte geben Sie eine gültige E-Mail-Adresse ein.");
                return false;
            }
    
            // Weitere Validierungen hier hinzufügen (z.B. Passwortstärke)
            return true;
        }
    
        document.getElementById("loginForm").onsubmit = validateLoginForm;
        document.getElementById("registerForm").onsubmit = validateRegisterForm;
    </script>
</body>
</html>