<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />';
die();
}else{
    $id = $_SESSION['user'];
    if($_SESSION["user_type"] != 'teacher'){
        echo '<meta http-equiv="refresh" content="0; url=/student/profile" />'; die();
    } 
}
 
?> 
@extends('core.vuetify') 
@section('vue')
<v-container grid-list-md>
    <v-layout row wrap>

        <v-flex d-flex xs12 sm4>

            <v-card color="">
                <v-toolbar color="blueONblue" dark>
                    <v-icon>fas fa-user-circle </v-icon>
                    <v-toolbar-title>อาจารย์</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-btn icon>
                        
                    </v-btn>
                </v-toolbar>

                <v-card-text>
                    <center>
                        <img style="width:50%;" src="https://i1.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1"
                            alt="">
                        <h2>@{{teacher.name}}</h2>
                        <h5>@{{teacher.username}}</h5>
                        <v-btn @click="dialog_updateTeacherProfile =true" class="box-purple" dark>
                            <v-icon>fas fa-user-cog</v-icon>&nbsp;แก้ไขโปรไฟล์</v-btn>
                    </center>
                    <hr>
                    <h5 v-if="teacher.permission == 1"> <v-icon>fas fa-user-tie</v-icon> &nbsp สถานะ : อาจารย์</h5>
                    <h5 v-if="teacher.permission == 0">สถานะ : อาจารย์/แอดมิน</h5>
                    <h5> <v-icon>fas fa-book-open</v-icon> &nbsp รายวิชาที่สร้างได้ : @{{teacher.count}}</h5>
                    <p>@{{teacher.remark}}</p>
                </v-card-text>
            </v-card>
        </v-flex>

        <v-flex d-flex xs12 sm8>
            <v-layout row wrap>
                <v-flex d-flex>
                    <v-card>
                        <v-toolbar color="box-purple" dark>
                            <v-icon>fas fa-align-justify </v-icon>
                            <v-toolbar-title>รายวิชา</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn v-if="teacher.count > 0" icon @click="create_course()">
                                <v-icon>fas fa-plus-circle </v-icon>
                            </v-btn>
                            <h5 v-if="teacher.count == 0">
                                Course Full
                            </h5>
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

<v-dialog v-model="dialog_updateTeacherProfile" width="500">
    <v-card>
        <v-card-title class="box-blue" dark>
            <v-icon class="wh">fas fa-user-cog</v-icon>&nbsp;
            <h3 class="wh">แก้ไขโปรไฟล์</h3>
        </v-card-title>

        <v-card-text>
            <v-text-field prepend-icon="fas fa-user" label="ชื่อ-สกุล" v-model="teacher.name" outline></v-text-field>
            <v-text-field prepend-icon="fas fa-lock" label="รหัสผ่าน" v-model="teacher.password" outline></v-text-field>
            <v-textarea  prepend-icon="fas fa-edit" outline label="เกี่ยวกับคุณ" v-model="teacher.remark"></v-textarea>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" flat @click="updateTeacherProfile()">
                แก้ไขข้อมูล
            </v-btn>
        </v-card-actions>
    </v-card>
</v-dialog>
@endsection
 
@section('vue_script')
<script>
    new Vue({
  el: "#app",
  data: {
    dialog_updateTeacherProfile:false,
   teacher:{},
   course:{}
  },
  methods: { 
    create_course(){
        window.location = "/course/create";
    },
    goto_coursePage(id){
        window.location = "/course/profile/"+id;
    },
    updateTeacherProfile(){
        let result =  axios.put('/api/teacher/'+this.teacher.id,this.teacher)
      .then((r) => { 
        alert('แก้ไขข้อมูลสำเร็จ');
      }).catch((e) => { 
          alert('error');
      });
      this.load();
      this.dialog_updateTeacherProfile = false;
    }, 
      getTeacherInfo(){
        let result =  axios.get('/api/teacher/<?php echo $id; ?>')
      .then((r) => {
          this.teacher = r.data;
      }).catch((e) => { 
          alert('error');
      });
      },
      getCourse(){
        let result =  axios.get('/api/course/<?php echo $id; ?>')
      .then((r) => {
          this.course = r.data;
      }).catch((e) => { 
          alert('error');
      });
      },

      load(){
       this.getTeacherInfo();
       this.getCourse();
      }
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection