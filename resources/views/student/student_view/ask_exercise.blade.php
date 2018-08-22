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

        <v-flex d-flex xs12 sm12>
            <v-card color="">
                <v-toolbar color="indigo" dark>
                    <v-icon>fas fa-user-circle </v-icon>
                    <v-toolbar-title> @{{exercise.name}}</v-toolbar-title>
                    <v-spacer></v-spacer>

                </v-toolbar>
                <v-container>
                        <v-alert value="info" type="info">
                                @{{exercise.remark}}
                            </v-alert>
                </v-container>
       
               @{{ask}}
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
      exercise:{ 
          ask:[],
      },
      ask:{},
  },
  methods: { 
    getAsk(){
       
     
        
    },
     load(){
        axios.get("/api/exercise/do/askanswer/{{request()->route('id')}}")
      .then((r) => {
          this.exercise = r.data;
          this.ask =  r.data.ask;
      }).catch((e) => { 
          alert('error');
      });
     }
  },
  mounted(){
    this.load();
    this.getAsk();
  }
});

</script>
@endsection