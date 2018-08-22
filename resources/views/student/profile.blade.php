<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />'; die();}
else{
    $id = $_SESSION['user'];
    $code = $_SESSION['student']; 
    if($_SESSION["user_type"] != 'student'){
        echo '<meta http-equiv="refresh" content="0; url=/teacher/profile" />'; die();
    } 
}
?> 
@extends('core.vuetify') 
@section('vue')
<v-container grid-list-md>
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
                       
                        <img   v-if="student.Title == 'นางสาว'"  style="width:50%;" src="https://cdn1.iconfinder.com/data/icons/user-pictures/100/female1-128.png"
                            alt="">
                     <img   v-if="student.Title == 'นาย'"  style="width:50%;" src="https://cdn1.iconfinder.com/data/icons/user-pictures/100/male3-128.png"
                            alt="">
                        <h2>@{{student.FirstName_TH}}&nbsp;@{{student.LastName_TH}}</h2>
                        <h5>@{{student.StudentCode}}</h5>
                    </center>
                    <hr>
                    <h5><v-icon>fas fa-book-reader</v-icon> &nbsp สาขา : @{{student.ProgramName_TH}}</h5>
                    <p><v-icon>fas fa-user-graduate</v-icon> &nbsp คณะ : @{{student.FacultyName_TH}}</p>
                    <hr>
                    <p><v-icon>fas fa-mobile-alt</v-icon> &nbsp เบอร์ : @{{student.Telephone}}</p>
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
                            <v-btn icon @click="searchCourse()">
                                <v-icon>search</v-icon>
                            </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            {{-- <pre>@{{courses}}</pre> --}}
                            <div v-for="course in courses">
                                <v-list-tile avatar @click="goto_coursePage(courses.id)">
                                    <v-list-tile-avatar>
                                        <v-icon color="blue">fas fa-feather-alt </v-icon>
                                    </v-list-tile-avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title>@{{course.courseData}}</v-list-tile-title>
                                       
                                    </v-list-tile-content>
                                </v-list-tile>
                                <v-divider></v-divider>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-flex>

            </v-layout>
</v-container>

@endsection
 
@section('vue_script')
<script>
    new Vue({
  el: "#app",
  data: {  
   student:{},
   courses:{},
  },
  methods: { 
      hello(){
        this.alert_text = "test";
        this.alert_bar=true;
      },
      getCourseIn(){
        let result =  axios.get('/api/course_in/<?php echo $code; ?>')
      .then((r) => {
          this.courses = r.data;
      }).catch((e) => { 
          alert('error: '+e);
      });
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
      this.getCourseIn();
      },
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection