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
        <v-flex d-flex>
            <v-card color="">
                <v-toolbar color="indigo" dark>
                    <v-icon>fas fa-user-circle </v-icon>
                    <v-toolbar-title>ข้อมูลรายวิชา @{{courses.name.split(',')[1]}} (@{{courses.name.split(',')[2]}}) [@{{courses.code}}]</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    <v-layout row wrap>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.name.split(',')[1]" label="ชื่อรายวิชา" outline append-icon="place" readonly></v-text-field>
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.code"  label="รหัสรายวิชา" outline append-icon="fas fa-dice" readonly></v-text-field>             
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.year"  label="ปีการศึกษา" outline append-icon="far fa-calendar-alt" readonly></v-text-field>             
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.teacher"  label="อาจารย์" outline append-icon="fas fa-user-tie" readonly></v-text-field>             
                        </v-flex>
                        <v-flex xs12 sm6 md3>
                            <v-text-field v-model="courses.created_at"  label="วันที่เปิดรายวิชา" outline append-icon="far fa-clock" readonly></v-text-field>             
                        </v-flex>
                    </v-layout>
                </v-card-text>
            </v-card>
        </v-flex>
    </v-layout>
    <br>
    <v-layout row wrap>
        <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="indigo" dark>
                <v-icon>fas fa-server</v-icon>
                    <v-toolbar-title>ข้อมูลเอกสาร</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-container>
                        <div v-for="document in documents">
                            <v-btn  color="primary" block @click="goto_filePage(document.link)">@{{document.name}}</v-btn>
                        </div>
                    </v-container> 
            </v-card>
        </v-flex>
        <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="indigo" dark>
                <v-icon>far fa-clipboard</v-icon>
                    <v-toolbar-title>ข้อมูลแบบฝึกหัด</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-card-text>
                    <v-card-text>
                            <div v-for="exercise in exercises">
                                    <v-list-tile avatar @click="goto_exercisePage(exercise.id,exercise.type)">
                                        <v-list-tile-content>
                                            <p class="headline mb-0">@{{exercise.name}}</p>
                                            <div>@{{exercise.time}}</div> 
                                        </v-list-tile-content>
                                    </v-list-tile>
                                <v-divider></v-divider>
                            </div>
                    </v-card-text>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="indigo" dark>
                <v-icon>fas fa-book-reader</v-icon>
                    <v-toolbar-title>นิสิตที่ลงเรียน</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                    <v-container>
                        <v-btn block style="background-color:#683ECF;" dark > <v-icon>far fa-clipboard</v-icon>&nbspคะแนน</v-btn>
                        <v-btn block style="background-color:#683ECF;" dark  @click="studentDialog = true"><v-icon>fas fa-user-graduate</v-icon>&nbspข้อมูลนิสิต</v-btn>
                        <v-btn block style="background-color:#683ECF;" dark  @click="studentDialogTA = true"><v-icon>fas fa-user-shield</v-icon>&nbspข้อมูล TA</v-btn>
                    </v-container>
            </v-card>
        </v-flex>
    </v-layout>
</v-container>

<v-dialog v-model="studentDialog" fullscreen hide-overlay transition="dialog-bottom-transition">
        <v-card>
            <v-toolbar dark color="primary">
                <v-btn icon dark @click.native="studentDialog = false">
                    <v-icon>close</v-icon>
                </v-btn>
                <v-toolbar-title>ข้อมูลนิสิต</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <br><br>
            <div v-for="students in student">
                <div v-if="students.permission == 1">
                    <v-container>
                        <h5>(@{{JSON.parse(students.studentIn.data).StudentCode}}) @{{JSON.parse(students.studentIn.data).FirstName_TH}}&nbsp;@{{JSON.parse(students.studentIn.data).LastName_TH}}</h5>
                        <p><b>@{{JSON.parse(students.studentIn.data).FacultyName_TH}}</b>@{{JSON.parse(students.studentIn.data).CourseName_TH}}
                        </p>
                        <v-divider></v-divider>
                    </v-container>
                </div>
            </div>
        </v-card>
    </v-dialog>
    <v-dialog v-model="studentDialogTA" fullscreen hide-overlay transition="dialog-bottom-transition">
            <v-card>
                <v-toolbar dark color="primary">
                    <v-btn icon dark @click.native="studentDialogTA = false">
                        <v-icon>close</v-icon>
                    </v-btn>
                    <v-toolbar-title>ข้อมูล TA</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <br><br>
                <div v-for="students in student">
                    <div v-if="students.permission == 2">
                        <v-container>
                            <h5>(@{{JSON.parse(students.studentIn.data).StudentCode}}) @{{JSON.parse(students.studentIn.data).FirstName_TH}}&nbsp;@{{JSON.parse(students.studentIn.data).LastName_TH}}</h5>
                            <p><b>@{{JSON.parse(students.studentIn.data).FacultyName_TH}}</b>@{{JSON.parse(students.studentIn.data).CourseName_TH}}
                            </p>
                            <v-divider></v-divider>
                        </v-container>
                    </div>
                </div>
            </v-card>
        </v-dialog>
@endsection
 
@section('vue_script')
<script>
    new Vue({
  el: "#app",
  data: {
    studentDialog:false,
    studentDialogTA:false,
    student:{},
    courses:{},
    exercises:{},
    dataCheck:1,
    register:{
    student:"{{$_SESSION['student']}}",
    course:"{{request()->route('id')}}",
    permission:1,
   },
   documents:{},
  },
  methods: {
    getStudent(){
        let result =  axios.get("/api/coursein/{{request()->route('id')}}")
      .then((r) => {
          this.student = r.data;
      }).catch((e) => { 
          alert('error: '+e);
      });
    },
    goto_filePage(link){
        window.open(link, '_blank');
    },
    goto_exercisePage(id,type){ //แก้ไขแบบฝึกหัดตอบถูกผิด
        if(type == '1'){
            window.location = "/student/course/exercise/ask_exercise/"+id;
        }else if(type == '2'){
            window.location = "/student/course/exercise/choice_exercise/"+id;
        }else if(type == '3'){
            window.location = "/student/course/exercise/file_exercise/"+id;
        }else{

        } 
    },
    getDocument(){
        let result = axios.get("/api/document_data/{{request()->route('id')}}")
        .then((r)=>{
          this.documents = r.data;
        }).catch((e)=>{
          alert('error: '+e);
        });
    },
      getCourse(){
        let result = axios.get("/api/course_data/{{request()->route('id')}}")
        .then((r)=>{
          this.courses = r.data;
        }).catch((e)=>{
          alert('error: '+e);
        });
      },
      load(){
        this.getCourse();
      },
      getExercise(){
        let result = axios.get("/api/exercise_data/{{request()->route('id')}}")
        .then((r)=>{
          this.exercises = r.data;
        }).catch((e)=>{
          alert('error: '+e);
        });
      },
      load(){
        this.getCourse();
        this.getExercise();
        this.getDocument();
        this.getStudent();     
    },
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection

