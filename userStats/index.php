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

    <?php
    require_once '../template/header_1_unterordner.php';
    ?>
    <div class="content">
        <?php
        $sql = "SELECT UserName, profile_pic, country_name, country_id FROM nutzer LEFT JOIN countries ON nutzer.country_id = countries.int_id  WHERE nutzer.int_id = $UserID";
        $result = $conn->query($sql);
        if($result->num_rows == 1)
        {
            while($row = $result->fetch_assoc())
            {
                $profilepic = $row['profile_pic'];
                $UserName = $row['UserName'];
                $heimatland = $row['country_name'];
                $country_id = $row['country_id'];
                echo '<h2 id="welcomeMessage">Welcome user '.$row['UserName'].'</h2>';
            }
        }
        $sql = "SELECT * FROM result LEFT JOIN nutzer ON result.user_id = nutzer.int_id LEFT JOIN countries ON nutzer.country_id = countries.int_id WHERE country_id = $country_id ORDER BY wpm";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $durchlauf = 1;
            while($row = $result->fetch_assoc())
            {
                $UserID_Ergebnis = $row['user_id'];
                $durchlauf =+1;
                if($UserID_Ergebnis == $UserID)
                {
                    $rang_wpm = $durchlauf;
                    break;
                }
                else{
                    $rang_wpm = "unbekannt";
                }
                
            }
        }
        $sql = "SELECT * FROM result LEFT JOIN nutzer ON result.user_id = nutzer.int_id LEFT JOIN countries ON nutzer.country_id = countries.int_id WHERE country_id = $country_id ORDER BY acc";
        $result = $conn->query($sql);
        if($result->num_rows > 0)
        {
            $durchlauf = 1;
            while($row = $result->fetch_assoc())
            {
                $UserID_Ergebnis = $row['user_id'];
                $durchlauf =+1;
                if($UserID_Ergebnis == $UserID)
                {
                    $rang_acc = $durchlauf;
                    break;
                }
                else{
                    $rang_acc = "unbekannt";
                }
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

                        $date =  formatdate($row['date']);
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
                            <p>'.$date.'</p>
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
                        $date = formatdate($row['date']);
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
                            <p>'.$date.'</p>
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
                        Das Profilbild kann auch im Nachhinein geändert werden.</p>
                </div>
                <div class="content_40p" id="profile_pic_view">
                    <div class="userStats_profilePic_Picture">
                        <?php
                        if(isset($profilepic))
                        {
                            echo '<img src="../user/profile_pictures/'.$profilepic.'" alt="Profilbild von '.$UserName.'">';
                        }
                        else{
                            echo '<img src="../pics/user-avatar.png" alt="Profilbild von '.$UserName.'">';
                        }
                        ?>
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
    <p>Du bist aktuell auf Rang <b><?php echo $rang_wpm?></b> in <?php echo $heimatland?></p>
        <p>Du bist aktuell auf Rang <b><?php echo $rang_acc?></b> in <?php echo $heimatland?></p>


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
            console.log(img.src);

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


        var wpmData = [
            <?php
            $sql = "SELECT wpm FROM result WHERE user_id = 3";
            $result = $conn->query($sql);
            if($result->num_rows > 0)
            {
                $durchlauf = 1;
                while ($row = $result->fetch_assoc())
                {
                    echo '{ x: '.$durchlauf.', y: '.$row['wpm'].' },';
                    $durchlauf ++;

                }
            }
                            
        ?>];
        var accData = [
            <?php
            $sql = "SELECT acc FROM result WHERE user_id = 3";
            $result = $conn->query($sql);
            if($result->num_rows > 0)
            {
                $durchlauf = 1;
                while ($row = $result->fetch_assoc())
                {
                    echo '{ x: '.$durchlauf.', y: '.$row['acc'].' },';
                    $durchlauf ++;

                }
            }
                            
        ?>];
        // JavaScript code for creating the line chart
        var chartData = {
            datasets: [
            {
                label: 'WPM',
                data: wpmData,
                backgroundColor: '#39cccc',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                pointRadius: 5,
                pointHoverRadius: 8
            },
            {
                label: 'Accuracy',
                data: accData,
                backgroundColor: '#000000',
                borderColor: '#000000',
                borderWidth: 1,
                pointRadius: 5,
                pointHoverRadius: 8
            }

        
        ]
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
                            text: 'Anzahl Tippversuche'
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


        var chartData_acc = {
            datasets: [{
                label: 'WPM',
                data: [
                    <?php 

                    $sql = "SELECT acc FROM result WHERE user_id = 3";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0)
                    {
                        $durchlauf = 1;
                        while ($row = $result->fetch_assoc())
                        {
                            echo '{ x: '.$durchlauf.', y: '.$row['acc'].' },';
                            $durchlauf ++;

                        }
                    }
                    ?>
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                pointRadius: 5,
                pointHoverRadius: 8
            }]
        };
        var lineChart_acc = new Chart(document.getElementById("scatterChart"), {
            type: 'line',
            data: chartData_acc,
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
                            text: 'Accuracy'
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
        <form action="new_profile_pic.php" method="POST" enctype="multipart/form-data">

        <h4>Neues Profilbild wählen</h4>
        <div class="uploadbox">
            <p class="uploadtext">Bitte den Button drücken um ein Bild auszuwählen</p>
            <div class="uploadpicture">
                <input type="file" id="fileInput" name="my_image" style="display: none;" onchange="newpicupload(event)">
            </div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="document.getElementById('fileInput').click()" id="fileupload_button">Bild auswählen</button>
        </div>
        <button type="submit" name="submit" class="profile_pic_new_submit">Bild auswählen</button>
        <button type="submit" id="profile_pic_new_delete" name="delete" class="profile_pic_new_submit bgred">Profilbild löschen</button>

        </form>

    </div>


</div>
<div id="overlay"></div>
</body>
</html>