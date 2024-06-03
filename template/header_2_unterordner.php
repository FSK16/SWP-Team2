<header class="typrusheader">
    <div class="headercontent">
        <div class="left">
            <a href="../../">
                <img src ="../../pics/logo.jpg">
            </a>
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
                  $profilepic_link = '../../user/profile_pictures/'.$profilepic;
                }
                else{
                  $profilepic_link ="../../pics/user-avatar.png";
                }
                echo '
                <a href=../../"user/'.$UserID.'/'.$username.'">
                <button id="statsbutton"><img src="'.$profilepic_link.'" class="header_profile_pic"><h3>Statistiken</h3></button>
                </a>
                <a href="../../logout.php"><button><h3>LogOut</h3></button></a>';

              }
              else{
                echo '<a href="../../Login+Regi.php"><button><h3>Login</h3></button></a>';
              }
              ?>
            <a href="../../Typer/index.html"><button><h3>Go Typing</h3></button></a>
        </div>
    </div>
</header>