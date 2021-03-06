<!DOCTYPE html>
<html>

<head>
  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.js"></script>
  <script src="https://cdnjs.com/libraries/lodash.js/"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
    crossorigin="anonymous">
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <link href="../../css/custom.css" rel="stylesheet">

</head>
<style>
  .box-blue {
  color:white!important;
  background: rgba(0, 160, 204, 1);
  background: -moz-linear-gradient(
    left,
    rgba(0, 160, 204, 1) 0%,
    rgba(41, 100, 163, 1) 100%
  );
  background: -webkit-gradient(
    left top,
    right top,
    color-stop(0%, rgba(0, 160, 204, 1)),
    color-stop(100%, rgba(41, 100, 163, 1))
  );
  background: -webkit-linear-gradient(
    left,
    rgba(0, 160, 204, 1) 0%,
    rgba(41, 100, 163, 1) 100%
  );
  background: -o-linear-gradient(
    left,
    rgba(0, 160, 204, 1) 0%,
    rgba(41, 100, 163, 1) 100%
  );
  background: -ms-linear-gradient(
    left,
    rgba(0, 160, 204, 1) 0%,
    rgba(41, 100, 163, 1) 100%
  );
  background: linear-gradient(
    to right,
    rgba(0, 160, 204, 1) 0%,
    rgba(41, 100, 163, 1) 100%
  );
  filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00a0cc', endColorstr='#2964a3', GradientType=1 );
}
</style>
<body onkeypress="return disableCtrlKeyCombination(event);" onkeydown="return disableCtrlKeyCombination(event);">
  <?php
    $i_user = isset($_SESSION['user']);
   ?>
    <div class="w3-bar box-blue wh">
      <?php if($i_user){?>
      <?php
                if($_SESSION['user_type'] == 'student'){
                  ?>
        <a href="/student/profile" class="w3-bar-item w3-button w3-hide-small"><i class="fas fa-user"></i>&nbsp โปรไฟล์</a>
        <a href="/student/logs" class="w3-bar-item w3-button w3-hide-small"><i class="far fa-list-alt"></i>&nbsp ประวัติ</a>
        <?php
                }
                if($_SESSION['user_type'] == 'teacher'){
                  ?>
          <a href="/teacher/profile" class="w3-bar-item w3-button w3-hide-small"><i class="fas fa-user"></i>&nbsp โปรไฟล์</a>
          <a href="/teacher/logs" class="w3-bar-item w3-button w3-hide-small"><i class="far fa-list-alt"></i>&nbsp ประวัติ</a>
          <?php
                }
                if(isset($_SESSION["admin"]) ){
                  if($_SESSION["admin"] == '2'){
                  ?>
            <a class="w3-bar-item w3-button w3-hide-small" href="/admin/teacher"> <i class="fas fa-user-tie"></i>&nbsp อาจารย์</a>
            <a class="w3-bar-item w3-button w3-hide-small" href="/admin/student"> <i class="fas fa-book-reader"></i>&nbsp นิสิต</a>
            <a class="w3-bar-item w3-button w3-hide-small" href="/admin/course"> <i class="fas fa-book-open"></i>&nbsp รายวิชา</a>
            <a class="w3-bar-item w3-button w3-hide-small" href="/admin/course"> <i class="fas fa-laptop-code"></i>&nbsp การลงทะเบียน</a>
            <a class="w3-bar-item w3-button w3-hide-small" href="/admin/document"> <i class="far fa-clipboard"></i>&nbsp เอกสาร</a>
            <a class="w3-bar-item w3-button w3-hide-small" href="/admin/exercise"> <i class="fas fa-clipboard-list"></i>&nbsp แบบฝึกหัด</a>
            <a class="w3-bar-item w3-button w3-hide-small" href="/admin/exercised"> <i class="fas fa-clipboard-check"></i>&nbsp การทำแบบฝึกหัด</a>
            <a class="w3-bar-item w3-button w3-hide-small" href="/admin/logs"> Logs</a>

            <?php
                }}
                ?>
              <a href="/logout" class="w3-bar-item w3-button w3-hide-small"><i class="fas fa-power-off"></i>&nbsp ออกจากระบบ</a>
              <?php } ?>
              <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="myFunction()">&#9776;</a>
    </div>

    <div id="demo" class="w3-bar-block box-blue wh w3-hide w3-hide-large w3-hide-medium">
        <?php if($i_user){?>
          <?php
                    if($_SESSION['user_type'] == 'student'){
                      ?>
            <a href="/student/profile" class="    w3-bar-item w3-button"><i class="fas fa-user"></i>&nbsp โปรไฟล์</a>
            <a href="/student/logs" class="    w3-bar-item w3-button"><i class="far fa-list-alt"></i>&nbsp ประวัติ</a>
            <?php
                    }
                    if($_SESSION['user_type'] == 'teacher'){
                      ?>
              <a href="/teacher/profile" class="    w3-bar-item w3-button"><i class="fas fa-user"></i>&nbsp โปรไฟล์</a>
              <a href="/teacher/logs" class="    w3-bar-item w3-button"><i class="far fa-list-alt"></i>&nbsp ประวัติ</a>
              <?php
                    }
                    if(isset($_SESSION["admin"]) ){
                      if($_SESSION["admin"] == '2'){
                      ?>
                <a class="    w3-bar-item w3-button" href="/admin/teacher"> <i class="fas fa-user-tie"></i>&nbsp อาจารย์</a>
                <a class="    w3-bar-item w3-button" href="/admin/student"> <i class="fas fa-book-reader"></i>&nbsp นิสิต</a>
                <a class="    w3-bar-item w3-button" href="/admin/course"> <i class="fas fa-book-open"></i>&nbsp รายวิชา</a>
                <a class="    w3-bar-item w3-button" href="/admin/course"> <i class="fas fa-laptop-code"></i>&nbsp การลงทะเบียน</a>
                <a class="    w3-bar-item w3-button" href="/admin/document"> <i class="far fa-clipboard"></i>&nbsp เอกสาร</a>
                <a class="    w3-bar-item w3-button" href="/admin/exercise"> <i class="fas fa-clipboard-list"></i>&nbsp แบบฝึกหัด</a>
                <a class="    w3-bar-item w3-button" href="/admin/exercised"> <i class="fas fa-clipboard-check"></i>&nbsp การทำแบบฝึกหัด</a>
                <a class="    w3-bar-item w3-button" href="/admin/logs"> Logs</a>
    
                <?php
                    }}
                    ?>
                  <a href="/logout" class="    w3-bar-item w3-button"><i class="fas fa-power-off"></i>&nbsp ออกจากระบบ</a>
                  <?php } ?>
              
    </div>

    <script>
      function myFunction() {
                  var x = document.getElementById("demo");
                  if (x.className.indexOf("w3-show") == -1) {
                      x.className += " w3-show";
                  } else { 
                      x.className = x.className.replace(" w3-show", "");
                  }
              }
    </script>
    <div id="app">
      <v-app>
        <v-content>
          @yield('vue')
        </v-content>
      </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
    @yield('vue_script')
</body>

</html>