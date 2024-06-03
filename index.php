<?php
session_start();
require_once 'conn.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Typrus</title>
    <link rel="stylesheet" href="stylesheet/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Tangerine">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>

<body> 
    <header class="typrusheader">
        <div class="headercontent">
            <div class="left">
            <img src ="pics/logo.jpg">
            </div>

            <div class="right">
              <?php
              if(isset($_SESSION['user_id']))
              {
                $UserID = $_SESSION['user_id'];
                $sql = "SELECT UserName, profile_pic FROM nutzer WHERE int_id = $UserID";
                $result = $conn->query($sql);
                if($result->num_rows == 1)
                {
                  while ($row = $result->fetch_assoc())
                  {
                      $username = $row['UserName'];
                      $profilepic = $row['profile_pic'];
                  }
                }
                if($profilepic != '')
                {
                  $profilepic_link = 'user/profile_pictures/'.$profilepic;
                }
                else{
                  $profilepic_link ="pics/user-avatar.png";
                }
                echo '
                <a href="user/'.$UserID.'/'.$username.'">
                <button id="statsbutton"><img src="'.$profilepic_link.'" class="header_profile_pic"><h3>Statistiken</h3></button>
                </a>
                <a href="logout.php"><button><h3>LogOut</h3></button></a>';

              }
              else{
                echo '<a href="Login+Regi.html"><button><h3>Login</h3></button></a>';
              }
              ?>

            <a href="Typer/index.html"><button><h3>Go Typing</h3></button></a>
            </div>
        </div>

    </header>

    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="pics/containerpics/startup-593324.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="pics/containerpics/computer-1869236.jpg" class="d-block w-100" alt="...">
          </div>
          <div class="carousel-item">
            <img src="pics/containerpics/wordpress-923188.jpg" class="d-block w-100" alt="...">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="facts">
      <div class="box">
        <h1 class="box_fact">3</h1>
        <p class="box_fact description">Users</p>
      </div>
      <div class="box">
        <h1 class="box_fact">1000</h1>
        <p class="box_fact description">Words typed every day</p>
      </div>
      <div class="box">
        <h1 class="box_fact">2</h1>
        <p class="box_fact description">languages</p>
      </div>
    </div>

    <div class="arrow">
      <img src ="pics/53966735-pfeil-nach-unten-vektor-symbol-style-ist-flach-symbol-symbol-farbe-schwarz-mit-weißem.jpg">
      <p  class="box_fact description" > Scroll for typing </p>
    </div>




    <div class="typer-deck">

      <main>

      <h1>
        <!--Hier snacke ich mir  die Schriftarten für den Typer (google fonts ist king)-->
        <svg xmlns="http://www.w3.org/2000/svg" height="1em"
             viewBox="0 0 576 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                     
          <path
                d="M64 112c-8.8 0-16 7.2-16 16V384c0 8.8 7.2 16 16 16H512c8.8 0 16-7.2 16-16V128c0-8.8-7.2-16-16-16H64zM0 128C0 92.7 28.7 64 64 64H512c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zM176 320H400c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H176c-8.8 0-16-7.2-16-16V336c0-8.8 7.2-16 16-16zm-72-72c0-8.8 7.2-16 16-16h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H120c-8.8 0-16-7.2-16-16V248zm16-96h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H120c-8.8 0-16-7.2-16-16V168c0-8.8 7.2-16 16-16zm64 96c0-8.8 7.2-16 16-16h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H200c-8.8 0-16-7.2-16-16V248zm16-96h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H200c-8.8 0-16-7.2-16-16V168c0-8.8 7.2-16 16-16zm64 96c0-8.8 7.2-16 16-16h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H280c-8.8 0-16-7.2-16-16V248zm16-96h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H280c-8.8 0-16-7.2-16-16V168c0-8.8 7.2-16 16-16zm64 96c0-8.8 7.2-16 16-16h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H360c-8.8 0-16-7.2-16-16V248zm16-96h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H360c-8.8 0-16-7.2-16-16V168c0-8.8 7.2-16 16-16zm64 96c0-8.8 7.2-16 16-16h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H440c-8.8 0-16-7.2-16-16V248zm16-96h16c8.8 0 16 7.2 16 16v16c0 8.8-7.2 16-16 16H440c-8.8 0-16-7.2-16-16V168c0-8.8 7.2-16 16-16z" />
        </svg>
      Typus
      </h1>
                  <!-- Hier wird das Spiel angezeigt sollte glaub ich keine Erklöä#rung brauchen -->
      <div id="header">
          <div id="info"></div>
              <div id="buttons">
                <button id="newGameBtn">Nochmal</button>
              </div>
            </div>
          <div id="game" tabindex="0">
              <div id="words"></div>
              <div id="cursor"></div>
              <div id="focus-error">Klicken um zu tippen</div>
          </div>
      </main>
          <script src="Typer/typus.js" defer> </script>


    </div>

    
  <script>
    const typerDeck = document.querySelector('.typer-deck');
    let scrollToTyperDeck = true;

    window.addEventListener('scroll', () => {
      if (scrollToTyperDeck) {
        if (window.scrollY >= 500) {
          typerDeck.scrollIntoView({ behavior: 'smooth', block: 'end' });
          scrollToTyperDeck = false;
        }
      }
    });

    typerDeck.addEventListener('scroll', () => {
      if (typerDeck.scrollTop === 1) {
        scrollToTyperDeck = true;
      }
    });
  </script>
</body>
</html>
