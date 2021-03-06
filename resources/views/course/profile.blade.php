<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />';}else{
    $id = $_SESSION['user'];
}
 
?> 
@extends('core.vuetify') 
@section('vue')
<v-container grid-list-md>
    <v-layout row wrap>
        <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="light-blue" dark>
                    <v-icon>far fa-file-alt</v-icon>
                    <v-toolbar-title> ข้อมูล</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar><br>
                <center>
                    <img src="https://cdn2.iconfinder.com/data/icons/mixed-rounded-flat-icon/512/note-128.png" alt="">
                    <h4>@{{courses.name.split(',')[1]}} (@{{courses.name.split(',')[2]}}) </h4>
                    <h5> @{{courses.code}}</h5>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-btn color="warning" @click="edit_course()"> แก้ไข &nbsp
                            <v-icon>fas fa-pen</v-icon>
                        </v-btn>
                        <v-btn color="red" @click="close_course()" v-if="dataCheck==1" dark>ปิด
                            <v-icon dark right>block</v-icon>
                        </v-btn>
                        <v-btn color="green" @click="open_course()" v-if="dataCheck==0" dark>เปิด
                            <v-icon dark right>far fa-eye</v-icon>
                        </v-btn>
                </center>
                <v-divider></v-divider>
                <v-list two-line subheader class="mrl-20">
                    <h5>
                        <v-icon>far fa-address-card</v-icon> &nbsp ไอดีอาจารย์ : @{{courses.id}}</h5>
                    <h5>
                        <v-icon>far fa-calendar-alt</v-icon> &nbsp ปีการศึกษา : @{{courses.year}}</h5>
                    <h5 v-if="courses.state == 1">
                        <v-icon>fas fa-user-tie</v-icon> &nbsp สถานะ : อาจารย์</h5>
                    <h5 v-if="courses.state == 0">
                        <v-icon>fas fa-user-tie</v-icon> &nbsp สถานะ : อาจารย์/แอดมิน</h5>
                    <h5>
                        <v-icon>fas fa-user-edit</v-icon> &nbsp สร้างเมื่อ : @{{timeconvert(courses.created_at)}}</h5>
                    <h5>
                        <v-icon>fas fa-user-cog</v-icon> &nbsp เเก้ไข : @{{timeconvert(courses.updated_at)}}</h5>

                </v-list>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="light-blue" dark>
                    <v-icon>fas fa-book-open</v-icon>
                    <v-toolbar-title>แบบฝึกหัด</v-toolbar-title>
                     
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-list two-line subheader>

                    <v-container>
                        <v-btn block color="primary" @click="submit_ask()">
                            <v-icon>fas fa-clipboard-check</v-icon>&nbsp ตอบถูกผิด</v-btn>
                        <v-btn block color="primary" @click="submit_choice()">
                            <v-icon>fas fa-list-ul</v-icon>&nbspเลือกตอบ</v-btn>
                        <v-btn block color="primary" @click="submit_askfile()">
                            <v-icon>fas fa-paperclip</v-icon>&nbspแนบไฟล์</v-btn>
                    </v-container>
                    <v-divider></v-divider>
                    <div v-for="exercise in exercises">
                        <v-list-tile>
                            <v-list-tile-content>
                                <v-layout style="width:100%;" row>
                                    <v-flex xs8 @click="goto_editExercisePage(exercise.id,exercise.type)">
                                        <v-list-tile-title class="mrt-10 pointer"><b>@{{exercise.name}}</b>&nbsp@{{getExerciseType(exercise.type)}} </v-list-tile-title>

                                    </v-flex>
                                    <v-flex xs2>
                                        <v-btn style="float:right;" @click="submit_check(exercise.id,exercise.type)" icon color="green" dark>
                                            <v-icon>fas fa-calendar-check </v-icon>
                                        </v-btn>
                                    </v-flex>
                                    <v-flex xs2>
                                        <v-btn style="float:right;" @click="deleteExercise(exercise.id)" icon color="red" dark>
                                            <v-icon>fas fa-times</v-icon>
                                        </v-btn>
                                    </v-flex>
                                </v-layout>

                            </v-list-tile-content>

                        </v-list-tile>

                    </div>
                </v-list>
            </v-card>
        </v-flex>
        <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="light-blue" dark>
                    <v-icon>fas fa-book-reader</v-icon>
                    <v-toolbar-title>นิสิต</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <center>
                    <v-container>
                        <v-btn block style="background-color:#683ECF;" dark @click="goto_ExportPage()">
                            <v-icon>far fa-clipboard</v-icon>&nbsp คะแนน</v-btn>
                        <v-btn block style="background-color:#683ECF;" dark @click="studentDialog = true">
                            <v-icon>fas fa-user-graduate</v-icon>&nbspข้อมูลนิสิต</v-btn>
                        <v-btn block style="background-color:#683ECF;" dark @click="TADialog = true">
                            <v-icon>fas fa-user-shield</v-icon>&nbspข้อมูล TA</v-btn>
                    </v-container>
                </center>
                <v-divider></v-divider>
                <h3>&nbsp;
                    <v-icon>far fa-folder-open</v-icon>&nbsp เอกสาร </h3>
                <v-container>
                    <v-btn block color="yellow" @click="document()">
                        <v-icon>fas fa-plus</v-icon>&nbsp จัดการเอกสาร </v-btn>
                </v-container>
                <v-divider></v-divider>
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
                </v-container>
                <v-divider></v-divider>
            </div>
        </div>
    </v-card>
</v-dialog>
<v-dialog v-model="TADialog" fullscreen hide-overlay transition="dialog-bottom-transition">

    <v-card>
        <v-toolbar dark color="primary">
            <v-btn icon dark @click="dialogClose()">
                <v-icon>close</v-icon>
            </v-btn>
            <v-toolbar-title>ข้อมูล TA</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-text-field v-model="dataDB.student" class="mrt-10" label="ใส่รหัสนิสิต TA ที่ต้องการเพิ่ม"></v-text-field>
            </v-flex>
            <v-btn color="primary" style="color:white!important; background-color:#9933CC;" dark  flat @click="addTA()">
                <v-icon>fas fa-plus</v-icon>&nbsp เพิ่ม TA
            </v-icon>
        </v-toolbar>
        <br><br>


        <div v-for="students in student">
            <div v-if="students.permission == 2">
                <v-container>
                    <h5>(@{{JSON.parse(students.studentIn.data).StudentCode}}) @{{JSON.parse(students.studentIn.data).FirstName_TH}}&nbsp;@{{JSON.parse(students.studentIn.data).LastName_TH}}</h5>

                    <p><b>@{{JSON.parse(students.studentIn.data).FacultyName_TH}}</b>@{{JSON.parse(students.studentIn.data).CourseName_TH}}
                    </p>
                </v-container>
                <v-divider></v-divider>
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
    dataCheck:{},
    dataDB: {
        course:"{{request()->route('id')}}",
    },
    TADialog:false,
    studentDialog:false,
    student:{},
    exercises:{},
    courses:{
        name:'',
    },
    close:{
        state:0,
        teacher:<?php echo $id; ?>,
    },
    open:{
        state:1,
        teacher:<?php echo $id; ?>,
    },
  },
  methods: { 
    timeconvert(time){
          convertTime = moment(time).format('L');
          return convertTime;
      },
    addTA(){
          axios.put("/api/course_in/addTA/"+this.dataDB.student,this.dataDB)
          .then(function(response) {
        alert('เพิ่ม TA ข้อมูลสำเร็จ');
        //console.log(this.dataDB);
        })
        .catch(function(error) {
        alert('error');
        });
        this.load();
    },
    dialogClose(){
        this.dataDB = {};
        this.TADialog = false;
        this.load();
    },
    deleteExercise(id){ 
        let deletes = confirm("คุณแน่ใจใช่ไหมที่จะลบข้อมูล");
        if(deletes){
        axios.delete("/api/exercise/"+id)
      .then((r) => { 
        alert("ลบข้อมูลแบบฝึกหัดสำเร็จ");
      }).catch((e) => { 
          alert('error: '+e);
      });
      this.load();}
    },
    submit_check(id,type){
        window.location = "/exercise/check/"+id+"?type="+type;
    },
    submit_askfile(){
        window.location = "/course/exercise/file/{{request()->route('id')}}";
    },
    submit_ask(){ //สร้างแบบฝึกหัดตอบถูกผิด
        window.location = "/course/exercise/ask_exercise/{{request()->route('id')}}";
    },
    submit_choice(){
        window.location = "/course/exercise/choice/{{request()->route('id')}}";
    },
    goto_ExportPage(){
        window.open("/course/export/{{request()->route('id')}}", '_blank');
    },
    goto_editExercisePage(id,type){ //แก้ไขแบบฝึกหัดตอบถูกผิด
        if(type == '1'){
            window.location = "/course/exercise/edit_ask/"+id;
        }else if(type == '2'){ 
            window.location = "/course/exercise/choice_edit/"+id;
        }else if(type == '3'){
            window.location = "/course/exercise/file_edit/"+id;
        }else{

        }
    },
    getExerciseType(type){
        if(type == '1'){
            return "(แบบ ตอบถูกผิด)";
        }else if(type == '2'){
            return "(แบบ เลือกตอบ)";
        }else if(type == '3'){
            return "(แบบ แนบไฟล์)";
        }else{
            return "(อื่นๆ)";
        }
    },
    checkExercise(){
        window.location = "/exercise/check/{{request()->route('id')}}";
    },
    document(){
        window.location = "/course/document/{{request()->route('id')}}";
    },
    edit_course(){ //แก้ไขรายวิชา
        window.location = "/course/edit_course/{{request()->route('id')}}";
    },
    close_course(close){ //ปิดรายวิชา
        var confirms = confirm("คุณแน่ใจใช่ไหม ที่จะปิดรายวิชา");
        if(confirms){
             axios.put("/api/close_course/{{request()->route('id')}}",this.close)
            .then((r) => {
                alert('ปิดรายวิชาเรีบยร้อยแล้ว');
                window.location = "/teacher/profile/";
            }).catch((e) => {
                alert('error: '+e);
            });
            this.load();
        }
    },
    open_course(open){ //เปิดรายวิชา
        var confirms = confirm("คุณแน่ใจใช่ไหม ที่จะเปิดรายวิชา");
        if(confirms){
            axios.put("/api/open_course/{{request()->route('id')}}",this.open)
        .then((r) => {
            alert('เปิดรายวิชาเรีบยร้อยแล้ว');
            window.location = "/teacher/profile/";
        }).catch((e) => {
            alert('error: '+e);
        });
        this.load();
        }
    },
    getCheck(){ //เช็คว่ารายวิชานี้ ปิดหรือยัง
        let result =  axios.get("/api/check_closeCourse/{{request()->route('id')}}")
      .then((r) => {
          this.dataCheck = r.data;
      }).catch((e) => { 
          alert('error: '+e);
      });
    },
    getStudent(){
        let result =  axios.get("/api/coursein/{{request()->route('id')}}")
      .then((r) => {
          this.student = r.data;
      }).catch((e) => { 
          alert('error: '+e);
      });
    },
    getCourse(){ //ดึงข้อมูลรายวิชา
        let result =  axios.get("/api/course_data/{{request()->route('id')}}")
      .then((r) => {
          this.courses = r.data;
      }).catch((e) => { 
          alert('error: '+e);
      });
      },
    getExercise(){ //ดึงข้อมูลแบบฝึกหัด
        let result =  axios.get("/api/exercise/{{request()->route('id')}}")
      .then((r) => {
          this.exercises = r.data;
      }).catch((e) => { 
          alert('error: '+e);
      });
      },
      load(){
       this.getExercise();
       this.getCourse();
       this.getStudent();
       this.getCheck();
      }
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection