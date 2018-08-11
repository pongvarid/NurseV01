<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />';}else{
    $id = $_SESSION['user'];
}
/*-------------------SET SESSION-----------------------*/
?>

@extends('core.vuetify') 
 
 <style>
     .bgh{ 
background: #111 url(https://www.img.in.th/images/4d8c442b2cdb2583584d7e63d6c87017.jpg)  no-repeat left top;
background-size: cover; 
 
    }
    
 </style>   
@section('vue')
<v-layout row >
        <v-flex xs12 id="home">
         
            <v-layout row>
                    <v-flex xs12 md12 sm12  class="bgh "> 
                            <div class="pd-die pd-48 "> 
                                    <h2 class="w3-jumbo wh" >สวัสดี</h2>
                                    <h3 class="wh">อาจารย์ @{{teacher.name}}</h3>
                                    <span class="w3-large wh"> @{{teacher.remark}}</span>
                                    <p><a href="#about" class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">@{{}}</a></p>
                       
                            </div>
                 
                        </v-flex>
            </v-layout>
         
         
               <!-------   <span class="w3-jumbo w3-hide-small">สวัสดี</span><br>
                  <span class="w3-jumbo w3-hide-large">Hi</span><br> ------>
           </v-flex>   
        </v-flex xs12 >
        
    </v-layout>
@endsection
 
@section('vue_script')
<script>
  new Vue({
  el: "#app",
  data: {
   teacher:{}
  },
  methods: { 
      load(){
        let result =  axios.get('/api/teacher/<?php echo $id; ?>')
      .then((r) => {
          this.teacher = r.data;
      }).catch((e) => { 
          alert('error');
      });
      }
  },
  mounted(){
      this.load();
  }
});


</script>
@endsection