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
                  <v-btn color="primary" :disabled="!valid" @click="submit()">submit</v-btn>
                </form>
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
      valid: true,
      course:{
        state:1,
        teacher:<?php echo $id;?> //อาจารย์
      },
    },
    methods: {
      submit () {
        axios.post("/api/course",this.course)
      .then(function(response) { 
        if(response.data == '1'){
            alert('บันทึกรายวิชาเรียบร้อย');
            window.location = "/teacher/profile";
        }else{
      
        } 
      })
      .catch(function(error) {
     
      });
      },
      
    }
    
    })
  </script>

@endsection