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
<v-container >
    <v-layout row>
    <v-flex xs12 sm4  >
        <v-card>
            <v-toolbar color="light-blue" dark>
                <v-toolbar-side-icon><v-icon>fas fa-user-circle</v-icon></v-toolbar-side-icon>
                <v-toolbar-title>แบบฝึกหัด</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <v-list two-line subheader>
                <v-divider ></v-divider> 
                <v-subheader >
                    <v-btn color="primary" depressed large @click="submit_ask()">แบบตอบถูกผิด</v-btn>
                </v-subheader> 
                <v-divider ></v-divider>
                <v-subheader >
                    <v-btn color="primary" depressed large @click="submit_ecm()">แบบเลือกตอบ</v-btn>
                    </v-subheader> 
                <v-divider ></v-divider> 
                <v-subheader >
                    <v-btn color="primary" depressed large @click="submit_edm()">แบบคำสั่งแนบไฟล์</v-btn>
                </v-subheader> 
                <v-divider ></v-divider> 
            </v-list>
        </v-card>
    </v-flex>
    <v-flex xs12 sm1></v-flex>
    <v-flex xs12 sm8 >
        <v-card>
            <v-toolbar color="light-blue" dark>
                <v-toolbar-side-icon></v-toolbar-side-icon>
                <v-toolbar-title>รายวิชา {{request()->route('id')}}</v-toolbar-title>
                <v-spacer></v-spacer>
                      
            </v-toolbar>


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
 
  },
  methods: { 
    submit_ask(){
        window.location = "<?=env('link');?>/course/exercise/ask_exercise/{{request()->route('id')}}";
    },
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection

{{-- {{request()->route('id')}} --}}