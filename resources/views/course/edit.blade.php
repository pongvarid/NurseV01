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
                    <v-text-field prepend-icon="fas fa-dice"  v-model="courses.code"  label="รหัสรายวิชา" type="text" ></v-text-field>
                    <v-text-field prepend-icon="fas fa-pen-square" v-model="courses.name" label="ชื่อรายวิชา" type="text"></v-text-field>
                    <v-text-field prepend-icon="far fa-calendar-alt" v-model="courses.year" label="ปีการศึกษา" type="text"></v-text-field>
                  </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="primary" @click="update()">ยื่นยัน</v-btn>
            
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
        courses:{},
       
    },
    methods: {
        getCourse(){
            let result =  axios.get("/api/course_data/{{request()->route('id')}}")
            .then((r) => {
                this.courses = r.data;
            }).catch((e) => { 
                alert('error: '+e);
            });
        },
        update () {
            axios.put("/api/course/{{request()->route('id')}}",this.courses)
        .then(function(response) { 
            alert('แก้ไขรายวิชาเรียบร้อย');
            window.location = "/course/profile/{{request()->route('id')}}";
        })
        .catch(function(error) {
        
        });
        this.load();
        },
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