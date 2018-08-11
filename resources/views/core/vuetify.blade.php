<!DOCTYPE html>
<html>
<head>
  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.js"></script>
<script src="https://cdnjs.com/libraries/lodash.js/"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<link href="../css/custom.css" rel="stylesheet">
</head>
<body>
   <?php
   
    $i_user = isset($_SESSION['user']);
   ?>
        <div class="w3-bar w3-red">
                <a href="#" class="w3-bar-item w3-button">Home</a>
                <a href="#" class="w3-bar-item w3-button w3-hide-small">Link 1</a>
                <a href="#" class="w3-bar-item w3-button w3-hide-small">Link 2</a>
                <?php if($i_user){?> 
                <a href="/logout"  class="w3-bar-item w3-button w3-hide-small">ออกจากระบบ</a>
                <?php } ?>
                <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium" onclick="myFunction()">&#9776;</a>
              </div>
              
              <div id="demo" class="w3-bar-block w3-red w3-hide w3-hide-large w3-hide-medium">
                <a href="#" class="w3-bar-item w3-button">Link 1</a>
                <a href="#" class="w3-bar-item w3-button">Link 2</a>
                <?php if($i_user){?> 
                    <a href="/logout" class="w3-bar-item w3-button w3-hide-small">ออกจากระบบ</a>
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