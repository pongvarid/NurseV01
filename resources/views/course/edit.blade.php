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
<div id="app">
  <v-app>
    <v-content>
      <v-container>
        <v-flex text-xs-center>
          <v-card class="elevation-12">
            <v-toolbar dark color="primary">
              <v-toolbar-title>แก้ไขรายวิชา</v-toolbar-title>
              <v-spacer></v-spacer>
            </v-toolbar>
            <v-card-text>
              <v-text-field prepend-icon="fas fa-dice" v-model="courses.code" label="รหัสรายวิชา" type="text"></v-text-field>
              <v-text-field prepend-icon="fas fa-pen-square" v-model="courses.name[0]" label="ชื่อรายวิชา" type="text"></v-text-field>
              <v-text-field prepend-icon="fab fa-adn" v-model="courses.name[1]" label="ชื่อรายวิชาภาษาอังกฤษ" type="text"></v-text-field>
              <v-text-field prepend-icon="far fa-calendar-alt" v-model="courses.year" label="ปีการศึกษา" type="text"></v-text-field>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="primary" @click="update()">ยืนยัน</v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </v-container>
    </v-content>
  </v-app>
</div>
@endsection
 
@section('vue_script')
<script>
  new Vue({ el: '#app',
    data:{
        courses:{
          name:[],
        },
    },
    methods: {
        getCourse(){
            let result =  axios.get("/api/course_data/{{request()->route('id')}}")
            .then((r) => {
                this.courses = r.data;
                this.getName();
            }).catch((e) => { 
                alert('error: '+e);
            });
        },
        getName(){
            let name = this.courses.name.split(",");
            let result_name = [];
            for(let i=0; i<name.length; i++){
                if(i == 0){continue;}
                result_name[i-1] = name[i]; 
            }
            this.courses.name = result_name;
            this.courses.count = result_name.length;         
        },
        checkStringName(){
        let name = this.courses.name;
        let resource = true;
        console.log(name);
           for(let i=0; i< name.length; i++){
            let tmpAsk =  this.courses.name[i].split(","); 
            if(tmpAsk.length >1){
                resource = false;
                break;
            }
           }
           return resource;
        },
        update(){
            let check = this.checkStringName();
            if(check){
            this.courses.name = ","+this.courses.name.toString();
            let result =  axios.put("/api/course/{{request()->route('id')}}",this.courses)
            .then((r) => {
                alert('แก้ไขข้อมูลสำเร็จ');
                window.location = "/course/profile/{{request()->route('id')}}";
            }).catch((e) => { 
                alert('error: '+e);
            });}else{
                alert('ห้ามใส่เครื่องหมาย "," ในคำถาม');
            }
            
        },
       // update () {
        //    this.course.name =this.name.th+" ("+this.name.en+")";
        //    axios.put("/api/course/{{request()->route('id')}}",this.courses)
       // .then(function(response) { 
       //     alert('แก้ไขรายวิชาเรียบร้อย');
       //     window.location = "/course/profile/{{request()->route('id')}}";
       // })
       // .catch(function(error) {
        
       // });
       // this.load();
       // },
        load(){
            this.getCourse();
      },
    },
    mounted(){
      this.load();
    },
    
    })

</script>
@endsection