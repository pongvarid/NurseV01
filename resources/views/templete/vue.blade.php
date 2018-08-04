<!DOCTYPE html>
<html>
<head>
    <link href='css/css.css' rel="stylesheet">
  <link href="css/vuetify.min.css" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <link href="css/materialdesignicons.min.css" media="all" rel="stylesheet" type="text/css" />
  <link href="css/custom.css" media="all" rel="stylesheet" type="text/css" />
  <script src="js/axios.min.js"></script>
  <script src="js/amoment-with-locales.min.js"></script>
</head>
<body>
  <div id="app">
    <v-app>
      <v-content>
      @yield('vue_templete')
      </v-content>
    </v-app>
  </div>
 
  <script src="js/vue.js"></script>
  <script src="js/vuetify.js"></script>

  @yield('vue_script')
</body>
</html>