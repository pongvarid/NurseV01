<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />'; die();}
else{
    $id = $_SESSION['user']; 
    if($_SESSION["user_type"] != 'student'){
        echo '<meta http-equiv="refresh" content="0; url=/teacher/profile" />'; die();
    } 
}
?> 
@extends('core.vuetify') 
@section('vue')
<v-container grid-list-md>
<<<<<<< Updated upstream
        <v-layout row wrap>
    
            <v-flex d-flex xs12 sm4>
    
                <v-card color="">
                    <v-toolbar color="indigo" dark>
                        <v-icon>fas fa-user-circle </v-icon>
                        <v-toolbar-title>นิสิต</v-toolbar-title>
                        <v-spacer></v-spacer>
                   
                    </v-toolbar>
    
                    <v-card-text>
                        <center>
                            <img style="width:50%;" src="https://i1.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1"
                                alt="">
                            <h2>@{{student.FirstName_TH}}&nbsp;@{{student.LastName_TH}}</h2>
                            <h5>@{{student.StudentCode}}</h5>
                        </center>
                        <hr>
                        <h5> <v-icon>fas fa-book-reader</v-icon> &nbsp สาขา :  @{{student.ProgramName_TH}}</h5>
                        <p> <v-icon>fas fa-user-graduate</v-icon> &nbsp คณะ :  @{{student.FacultyName_TH}}</p>
                        <hr>
                        <p> <v-icon>fas fa-mobile-alt</v-icon> &nbsp เบอร์ : @{{student.Telephone}}</p>
                        <p><v-icon>fas fa-map-marker-alt</v-icon> &nbsp ที่อยู่ : @{{student.Address}}</p>
                       <hr>
                    </v-card-text>
                </v-card>
            </v-flex>
    
            <v-flex d-flex xs12 sm8>
                <v-layout row wrap>
                    <v-flex d-flex>
                        <v-card>
                            <v-toolbar color="indigo" dark>
                                <v-icon>fas fa-align-justify </v-icon>
                                <v-toolbar-title>รายวิชาที่ลงทะเบียนเรียน</v-toolbar-title>
                                <v-spacer></v-spacer>
                                <v-btn icon>
                                        <v-icon>search</v-icon>
                                    </v-btn>
                            </v-toolbar>
                            <v-card-text>
                                <div v-for="courses in course">
                                    <v-list-tile avatar @click="goto_coursePage(courses.id)">
                                        <v-list-tile-avatar>
                                            <v-icon color="blue">fas fa-feather-alt </v-icon>
                                        </v-list-tile-avatar>
                                        <v-list-tile-content>
                                            <v-list-tile-title>@{{courses.name}}</v-list-tile-title>
                                            <v-list-tile-sub-title>@{{courses.code}}</v-list-tile-sub-title>
                                        </v-list-tile-content>
                                    </v-list-tile>
                                    <v-divider></v-divider>
                                </div> 
                        </v-card>
                    </v-flex>
    
                </v-layout>
    </v-container>
=======
    <v-layout row wrap>

        <v-flex d-flex xs12 sm4>

            <v-card color="">
                <v-toolbar color="indigo" dark>
                    <v-icon>fas fa-user-circle </v-icon>
                    <v-toolbar-title>นิสิต</v-toolbar-title>
                    <v-spacer></v-spacer>

                </v-toolbar>

                <v-card-text>
                    <center>
                        <img style="width:50%;" src="https://i1.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1"
                            alt="">
                        <h2>@{{student.FirstName_TH}}&nbsp;@{{student.LastName_TH}}</h2>
                        <h5>@{{student.StudentCode}}</h5>
                    </center>
                    <hr>
                    <h5>สาขา : @{{student.ProgramName_TH}}</h5>
                    <p>คณะ : @{{student.FacultyName_TH}}</p>
                    <hr>
                    <p>เบอร์ : @{{student.Telephone}}</p>
                    <p>ที่อยู่ : @{{student.Address}}</p>
                    <hr>
                </v-card-text>
            </v-card>
        </v-flex>

        <v-flex d-flex xs12 sm8>
            <v-layout row wrap>
                <v-flex d-flex>
                    <v-card>
                        <v-toolbar color="indigo" dark>
                            <v-icon>fas fa-align-justify </v-icon>
                            <v-toolbar-title>รายวิชาที่ลงทะเบียนเรียน</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn icon @click="searchCourse()">
                                <v-icon>search</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <div v-for="courses in course">
                                <v-list-tile avatar @click="goto_coursePage(courses.id)">
                                    <v-list-tile-avatar>
                                        <v-icon color="blue">fas fa-feather-alt </v-icon>
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title>@{{courses.name}}</v-list-tile-title>
                                        <v-list-tile-sub-title>@{{courses.code}}</v-list-tile-sub-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                                <v-divider></v-divider>
                            </div>
                    </v-card>
                </v-flex>

            </v-layout>
</v-container>
>>>>>>> Stashed changes
@endsection
 
@section('vue_script')
<script>
    new Vue({
  el: "#app",
  data: {  
   student:{}
  },
  methods: { 
      hello(){
        this.alert_text = "test";
        this.alert_bar=true;
      },
      searchCourse(){
        window.location = "/course/search";
      },
      load(){
        let result =  axios.get('/api/student/data/<?php echo $id; ?>')
      .then((r) => {
          this.student = r.data;
      }).catch((e) => { 
          alert('error');
      });
      }
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection