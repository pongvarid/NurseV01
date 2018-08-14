<!DOCTYPE html>
<html>

<head>
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
</head>

<body>
    <div id="app">
        <v-app>
            <v-content>
 
              

            </v-content>
        </v-app>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
    <script>
        new Vue({
       el:"#app",
       data:{
           text:null,
        x:[1,2,3,4,5],
        y:{
            name:"pongvarid",
            surname:"cxxxx"
        }
       },
       methods:{
           resource(){
               return Number(this.text)+1;
           },
           load(){alert('Hello');}
       },
       mounted(){
           
       }
   });
    </script>
</body>

</html>