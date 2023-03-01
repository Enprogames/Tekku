<!DOCTYPE html>

<head>
   <link href="../css/settings_style.css" rel="stylesheet" />
   <link href="../css/base_colors.css" rel="stylesheet" />
   <link rel="icon" type="image/x-icon" href="../favicon.ico" />

   <style>

   .postBox{
         border: 2px solid #AA4926;
         height: 250px;
         width: 250px;
         margin: auto;
      }

    .midPostBox{
         padding: 10px;
         display: flex;
    }

    .grandPostBox{
         border: 2px solid brown;
    }

   </style>

   <title> /tec/ - Technology </title>
</head>

<body>
   <header>
      <?php include 'header.php' ?>
      <h6 style='text-align: right'>
      <div class="dropdown">
            <button>settings</button>
               <div class="dropdown-content">
                  <a href="usr_login.php">Log In</a>
                  <a href="#">FAQ</a>
                  <a href="#">Rules</a>
               </div>
      </div>

      <a href="..">home</a> </h6>
   </header>
   <hr/>
   <h1 style="text-align: center; text-decoration: underline;">/tec/ - Technology</h1>
   <hr />
      <?php
         include 'post_box.php';
      ?>
   <hr/>

   <div class="grandPostBox">
      <?php

      for($i = 0; $i < 25; $i++){
         echo "<div class='midPostBox'>";
         for($j = 0; $j < 4; $j++){
            echo "<div class='postBox'><p>main post will go here using external load_post.php func, probably</p></div>";
         }
         echo "</div>";
      }

      ?>
   </div>
</body>

</html>