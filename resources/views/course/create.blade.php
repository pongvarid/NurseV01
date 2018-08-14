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
        <v-container fill-height>
            <v-flex text-xs-center>
              <v-card class="elevation-12">
                <v-toolbar dark color="primary">
                  <v-toolbar-title>เพิ่มรายวิชา</v-toolbar-title>
                  <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                <form>
                    @csrf
                    <v-text-field v-model="course.code"  label="รหัสรายวิชา" type="text" ></v-text-field>
                    <v-text-field v-model="course.name"  label="ชื่อรายวิชา" type="text"></v-text-field>
                    <v-text-field v-model="course.year"  label="ปีการศึกษา" type="text"></v-text-field>
                  </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" :disabled="!valid" @click="submit">submit</v-btn>
                  <v-btn @click="clear">clear</v-btn>
                </form>
                </v-card-actions>
          </v-card>
            </v-flex>
        </v-container>
      </v-content>
  </v-app>
  </div>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify/dist/vuetify.js"></script>
  <script>
    
    new Vue({ el: '#app',
    data: () => ({
      valid: true,
      course:{
        state:1,
        teacher:'admin',
      }
      //code:this.code,
    }),

    methods: {
      submit () {
        axios.post("<?=env('link');?>/api/course",this.course)
      .then(function(response) { 
        if(response.data == '1'){
            window.location = "<?=env('link');?>/course/";
        }else{
      
        } 
      })
      .catch(function(error) {
     
      });
      },
      clear () {
        this.$refs.form.reset()
      }
    }
    
    })
  </script>
</body>
</html>