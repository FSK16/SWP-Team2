<?php
require_once '../conn.php';
include '../template/functions.php';
session_start();
if(isset($_SESSION['user_id']))
{
    $UserID = $_SESSION['user_id'];
}
else{
    $UserID = 20;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Typrus</title>
    <link rel="stylesheet" href="../stylesheet/style.css">
    <script src="../Typer/typus.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>



<body> 
    <header class="typrusheader">
        <div class="headercontent">
            <div class="left">
            <img src ="../pics/logo.jpg">
            </div>

            <div class="right">
            <a href="../index.html"><button ><h3>LogOut</h3></button></a>
            <a href="../Typer/index.html"><button><h3>Go Typing</h3></button></a>
            </div>
        </div>

    </header>
    <div class="content">
        <?php
        $sql = "SELECT UserName FROM nutzer WHERE int_id = $UserID";
        $result = $conn->query($sql);
        if($result->num_rows == 1)
        {
            while($row = $result->fetch_assoc())
            {
                $UserName = $row['UserName'];
                echo '<h2 id="welcomeMessage">Welcome user '.$row['UserName'].'</h2>';
            }
        }
        ?>

<div class="table_2_itemes">
<div id="userStats" class="user_high_score">
        <h2>User Stats</h2>
        <!-- Include user-specific stats here -->
        <p>Username: <?php echo $UserName?></p>
        <?php 
        $sql = "SELECT AVG(wpm) AS wpm FROM result WHERE user_id = 3";
        $result = $conn->query($sql);
        if($result->num_rows == 1)
        {
            while($row = $result->fetch_assoc())
            {
                $wpm = $row['wpm'];
                $wpm_rounded = round($wpm, 4);
                echo '<p>Averagge wpm: '.$wpm_rounded.'</p>';
            }
        }
        $sql = "SELECT AVG(acc) AS acc FROM result WHERE user_id = 3";
        $result = $conn->query($sql);
        if($result->num_rows == 1)
        {
            while($row = $result->fetch_assoc())
            {
                $acc = $row['acc'];
                $acc_rounded = round($acc, 4);
                echo '<p>Averagge accuracy: '.$acc_rounded.'</p>';
            }
        }
        ?>
        <p>test type: time 30 sec / english</p>
        <p>time: 30</p>

        <canvas id="scatterChart" width="400" height="200"></canvas>
        <!-- Add more user stats as needed -->
</div>

  



    <div id="globalHighScores" class="global_high_scores">
        <h2>Global High Scores</h2>
        <!-- Include a list of global high scores here -->

        <div class="userStats_highscoretable">
            <div class="userStats_highscoretable_header">
                <button type="button" id="highscore_wpm_button" onclick="togglehighscore(1)"><b>Order by Words per mintue</b></button>
                <button type="button" id="highscore_acc_button" onclick="togglehighscore(0)"><b>Order by accuracy</b></button>
        	</div>
            <div class="userStats_highscoretable_content">
                <div class="highscore_entry_block" id="highsorce_entry_title">
                    <div class="highscore_entry">
                    <p>Place</p>
                    </div>
                    <div class="highscore_entry">
                    <p>User</p>
                    </div>
                    <div class="highscore_entry">
                    <p>wpm</p>
                    </div>
                    <div class="highscore_entry">
                    <p>acc</p>
                    </div>
                    <div class="highscore_entry">
                    <p>duration</p>
                    </div>
                    <div class="highscore_entry">
                    <p>date</p>
                    </div>
                </div>
                <?php 
                $sql = "SELECT * FROM result LEFT JOIN nutzer ON result.user_id = nutzer.int_id ORDER BY wpm DESC";
                $result = $conn->query($sql);
                if($result->num_rows > 0)
                {   
                    echo '<div id="highscore_wpm">';
                    $trefferanzahl = 0;
                    while($row = $result->fetch_assoc())
                    {   
                        $trefferanzahl +=1;
                        $UserName = $row['UserName'];
                        //$date =  formatdate($row['date']);
                        echo '     
                        <div class="highscore_entry_block">
                
                            <div class="highscore_entry">
                            <p>'.$trefferanzahl.'</p>
                            </div>
                            <div class="highscore_entry">
                            <p>'.$row['UserName'].'</p>
                            </div>
                            <div class="highscore_entry">
                            <p>'.$row['wpm'].'</p>
                            </div>
                            <div class="highscore_entry">
                            <p>'.$row['acc'].'</p>
                            </div>
                            <div class="highscore_entry">
                            <p>'.$trefferanzahl.'</p>
                            </div>
                            <div class="highscore_entry">
                            <p>'.$row['date'].'</p>
                            </div>
                        </div>
                            
                        ';
                    }
                    echo '</div>';
                }
                ?>
                <?php 
                $sql = "SELECT * FROM result LEFT JOIN nutzer ON result.user_id = nutzer.int_id ORDER BY acc DESC";
                $result = $conn->query($sql);
                if($result->num_rows > 0)
                {   
                    echo '<div id="highscore_acc">';
                    $trefferanzahl = 0;
                    while($row = $result->fetch_assoc())
                    {   
                        $trefferanzahl +=1;
                        $UserName = $row['UserName'];
                        //$date = formatdate($row['date']);
                        echo '     
                        <div class="highscore_entry_block">
                
                            <div class="highscore_entry">
                            <p>'.$trefferanzahl.'</p>
                            </div>
                            <div class="highscore_entry">
                            <p>'.$row['UserName'].'</p>
                            </div>
                            <div class="highscore_entry">
                            <p>'.$row['wpm'].'</p>
                            </div>
                            <div class="highscore_entry">
                            <p>'.$row['acc'].'</p>
                            </div>
                            <div class="highscore_entry">
                            <p>'.$trefferanzahl.'</p>
                            </div>
                            <div class="highscore_entry">
                            <p>'.$row['date'].'</p>
                            </div>
                        </div>
                            
                        ';
                    }
                }
                ?>
                </div>
            </div>
        </div>
        <div class="container_100p" id="userStats_profile_pic">
            <div class="container_content">
                <div class="content_60p">
                    <h3>Dein Profilbild</h3>
                    <p>Füge ein Profilbild hinzu, um deinem Profil
                         ideales Aussehen zu schaffen. 
                         Klicke dazu ganz einfach auf Profilbild
                          hinzuügen!
                        Das Profilbild kann auch im Nachhinein geändert werden</p>
                </div>
                <div class="content_40p" id="profile_pic_view">
                    <div class="userStats_profilePic_Picture">
                        <img src="https://railwayfans.b-cdn.net/image_online/IMG-6652f20f8545f9.75230249.jpg" alt="Profilbild von <?php echo $UserName?>">
                    </div>
                    <div class="userStats_profilePic_button_change">
                        <button onclick="openPopUp('new_proile_pic_popup',  500, 250, '#ffffff')"><b>Neues Profilbild wählen</b></button>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

    <div id="countryPlacement">

        <script>// Function to get the user's country placement
            function getCountryPlacement() {
                // Simulated data, replace with your actual data retrieval logic
                return "#1";
            }
        
            // Update the "countryPlacement" section with the user's country placement
            var countryPlacementElement = document.getElementById("countryPlacement");
            countryPlacementElement.innerHTML = "You are " + getCountryPlacement() + " in your country";
        </script>
    </div>


</>


 

<script>

    
function newpicupload(event) {
    console.log("File erhalten");

    var uploadPictureDiv = document.querySelector('.uploadpicture');
    var uploadText = document.querySelector('.uploadtext');
    var uploadButton = document.getElementById('fileupload_button');
    var uploadBox = document.querySelector('.uploadbox');
    var confirmed = document.querySelector('.confirmed');
    var file = event.target.files[0]; // Datei vom Ereignisparameter holen

    if (file) {
        var reader = new FileReader();

        reader.onload = function (e) {
            var img = document.createElement('img');
            img.src = e.target.result;

            // Überprüfen Sie die Dateiendung
            if (file.type === 'image/jpeg') {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function () {
                    if (image.width <= 2000) {
                        img.style.opacity = '0'; // Bild am Anfang ausblenden
                        uploadPictureDiv.appendChild(img);

                        uploadText.style.transition = 'opacity 0.5s';
                        uploadButton.style.transition = 'opacity 0.5s';
                        uploadText.style.opacity = '0';
                        uploadButton.style.opacity = '0';

                        // Ändern Sie die Hintergrundfarbe der uploadbox
                        uploadBox.style.transition = 'background-color 0.5s';
                        uploadBox.style.backgroundColor = 'transparent';
                        uploadText.style.display = 'none';

                        // Verzögern Sie das Einblenden des Bildes um 0,5 Sekunden
                        setTimeout(function () {
                            img.style.opacity = '1';
                            img.classList.add('uploadpicture_image');
                        }, 500);
                    } else {
                        alert("Bitte wähle ein Bild mit einer Breite, die kleiner als 2000px ist.");
                    }
                };
            } else {
                alert("Bitte wähle ein JPEG-Bild.");
            }
        };
        reader.readAsDataURL(file);
    } else {
        uploadPictureDiv.innerHTML = '';

        // Zeigen Sie den Text und den Upload-Button mit einem Übergangseffekt wieder an
        uploadText.style.transition = 'opacity 0.5s';
        uploadButton.style.transition = 'opacity 0.5s';
        uploadText.style.opacity = '1';
        uploadButton.style.opacity = '1';

        // Setzen Sie die Hintergrundfarbe der uploadbox zurück
        uploadBox.style.transition = 'background-color 0.5s';
        uploadBox.style.backgroundColor = '#dfe3de';
    }
}

        // JavaScript code for creating the line chart
        var chartData = {
            datasets: [{
                label: 'WPM vs. Time',
                data: [
                    { x: 5, y: 75 },
                    { x: 10, y: 130 },
                    { x: 15, y: 100 },
                    { x: 20, y: 90 },
                    { x: 25, y: 110 },
                    { x: 30, y: 100 }
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        };

        var lineChart = new Chart(document.getElementById("scatterChart"), {
            type: 'line',
            data: chartData,
            options: {
                scales: {
                    x: {
                        type: 'linear',
                        position: 'bottom',
                        title: {
                            display: true,
                            text: 'Time (seconds)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'WPM'
                        }
                    }
                }
            }
        });
        var currentsetting = 0;
        window.onload = togglehighscore(1);


        function togglehighscore(currentsetting){
            var acc = document.getElementById("highscore_acc");
            var wpm = document.getElementById("highscore_wpm");
            if(currentsetting == 0)
            {
                wpm.style.display = 'none';
                acc.style.display = 'block';
                currentsetting = 1;
            }
            else if(currentsetting == 1)
            {
                acc.style.display = 'none';
                wpm.style.display = 'block';
                currentsetting = 0;
            }

        }



    </script>


<div id="new_proile_pic_popup" class="popupwindow">
    <div class="container_content">
        <form action="new_profile_pic.php" method="POST">

        <h4>Neues Profilbild wählen</h4>
        <div class="uploadbox">
            <p class="uploadtext">Bitte den Button drücken um ein Bild auszuwählen</p>
            <div class="uploadpicture">
                <input type="file" id="fileInput" name="my_image" style="display: none;" onchange="newpicupload(event)" required>
            </div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('fileInput').click()" id="fileupload_button">Bild auswählen</button>
        </div>
        <button  type="submit" name="submit" class="profile_pic_new_submit">Bild auswählen</button>
        </form>

    </div>


</div>
<div id="overlay"></div>
</body>
</html>