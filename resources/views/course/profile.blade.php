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
                    <v-toolbar-side-icon></v-toolbar-side-icon>
                    <v-toolbar-title>ข้อมูล</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar><br>
                <center>
                    <img src="https://cdn2.iconfinder.com/data/icons/mixed-rounded-flat-icon/512/note-128.png" alt="">
                    <h4>@{{courses.name}} </h4>
                    <h5> @{{courses.code}}</h5>
                    <v-divider></v-divider>
                    <v-card-text>
                        <v-btn color="warning" @click="edit_course()">แก้ไข</v-btn>
                        <v-btn color="red" @click="close_course()" dark>ปิด
                            <v-icon dark right>block</v-icon>
                        </v-btn>
                </center>
                <v-divider></v-divider>
                <v-list two-line subheader class="mrl-20">
                    <h5>ไอดีอาจารย์ : @{{courses.id}}</h5>
                    <h5>ปีการศึกษา : @{{courses.year}}</h5>
                    <h5>สถานะ : @{{courses.state}}</h5>
                    <h5>สร้างเมื่อ : @{{courses.created_at}}</h5>
                    <h5>เเก้ไข : @{{courses.updated_at}}</h5>

                </v-list>
                </v-card-text>
            </v-card>
        </v-flex>
        <v-flex d-flex xs12 sm4>
            <v-card>
                <v-toolbar color="light-blue" dark>
                    <v-toolbar-side-icon>
                        <v-icon>fas fa-user-circle</v-icon>
                    </v-toolbar-side-icon>
                    <v-toolbar-title>เมนู</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-list two-line subheader>
                    <v-divider></v-divider>
                    <h3>&nbsp;เอกสาร</h3>
                    <v-btn color="yellow" @click="document()">จัดการเอกสาร</v-btn>
                    <v-divider></v-divider>
                    <h3>&nbsp;แบบฝึกหัด</h3>
                    <v-subheader>
                        <v-btn color="primary" @click="submit_ask()">ตอบถูกผิด</v-btn>
                        <v-btn color="primary" @click="submit_choice()">เลือกตอบ</v-btn>
                        <v-btn color="primary" @click="submit_askfile()">แนบไฟล์</v-btn>
                    </v-subheader>
                    <v-divider></v-divider>
                    <div v-for="exercise in exercises">
                        <v-list-tile>
                            <v-list-tile-content>
                                <v-layout style="width:100%;" row>
                                    <v-flex xs12 @click="goto_editExercisePage(exercise.id,exercise.type)">
                                        <v-list-tile-title class="mrt-10 pointer">@{{exercise.name}} @{{getExerciseType(exercise.type)}} </v-list-tile-title>

                                    </v-flex>
                                    <v-flex xs1>
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
                    <v-toolbar-side-icon></v-toolbar-side-icon>
                    <v-toolbar-title>นิสิต</v-toolbar-title>
                    <v-spacer></v-spacer>
                </v-toolbar>
                <v-divider></v-divider>
                <center>

                    <v-btn>คะแนน</v-btn>
                    <v-btn @click="studentDialog = true">ข้อมูลนิสิต</v-btn>
                    <v-btn @click="TADialog = true">ข้อมูล TA</v-btn>
                </center>
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

                <h5>(@{{JSON.parse(students.studentIn.data).StudentCode}}) @{{JSON.parse(students.studentIn.data).FirstName_TH}}&nbsp;@{{JSON.parse(students.studentIn.data).LastName_TH}}</h5>

                <p><b>@{{JSON.parse(students.studentIn.data).FacultyName_TH}}</b>@{{JSON.parse(students.studentIn.data).CourseName_TH}}
                </p>

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
            <v-btn @click="addTA()">เพิ่ม TA</v-btn>

        </v-toolbar>
        <br><br>


        <div v-for="students in student">
            <div v-if="students.permission == 2">

                <h5>(@{{JSON.parse(students.studentIn.data).StudentCode}}) @{{JSON.parse(students.studentIn.data).FirstName_TH}}&nbsp;@{{JSON.parse(students.studentIn.data).LastName_TH}}</h5>

                <p><b>@{{JSON.parse(students.studentIn.data).FacultyName_TH}}</b>@{{JSON.parse(students.studentIn.data).CourseName_TH}}
                </p>

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
    dataDB: {},
    TADialog:false,
    studentDialog:false,
    student:{},
    exercises:{},
    courses:{},
    close:{
        state:0,
    },
  },
  methods: { 
    addTA(){
        console.log();
          axios.put("/api/course_in/addTA/"+this.dataDB.student,this.dataDB)
          .then(function(response) {
        alert('เพิ่ม TA ข้อมูลสำเร็จ'); 
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
    submit_askfile(){
        window.location = "/course/exercise/file/{{request()->route('id')}}";
    },
    submit_ask(){ //สร้างแบบฝึกหัดตอบถูกผิด
        window.location = "/course/exercise/ask_exercise/{{request()->route('id')}}";
    },
    submit_choice(){
        window.location = "/course/exercise/choice/{{request()->route('id')}}";
    },
    goto_editExercisePage(id,type){ //แก้ไขแบบฝึกหัดตอบถูกผิด
        if(type == '1'){
            window.location = "/course/exercise/edit_ask/"+id;
        }else if(type == '2'){ 
            window.location = "/course/exercise/choice_edit/"+id;
        }else if(type == '3'){

        }else{

        }
    },
    getExerciseType(type){
        if(type == '1'){
            return "(แบบ ถาม-ตอบ)";
        }else if(type == '2'){
            return "(แบบ เลือกข้อถูก)";
        }else if(type == '3'){
            return "(แบบ สั่งงาน)";
        }else{
            return "(อื่นๆ)";
        }
    },
    document(){
        window.location = "/course/document/{{request()->route('id')}}";
    },
    edit_course(){ //แก้ไขรายวิชา
        window.location = "/course/edit_course/{{request()->route('id')}}";
    },
    close_course(){ //ปิดรายวิชา
        axios.put("/api/close_course/{{request()->route('id')}}",this.close)
        .then((r) => {
            alert('ปิดรายวิชาเรีบยร้อยแล้ว');
            window.location = "/teacher/profile/";
        }).catch((e) => {
            alert('error: '+e);
        });
        this.load();
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
      }
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection
 {{-- {{request()->route('id')}} --}}