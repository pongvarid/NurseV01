<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />';}else{
    $id = $_SESSION['user'];
}
/*-------------------SET SESSION-----------------------*/
include(resource_path().'/alert/alert.php');
?>

@extends('core.vuetify') 
 
 <style>
     .bgh{ 
background: #111 url(https://www.img.in.th/images/4d8c442b2cdb2583584d7e63d6c87017.jpg)  no-repeat left top;
background-size: cover; 
 
    }
    
 </style>   
@section('vue')
 
<?php
 include(resource_path().'/views/teacher/test.blade.php');
alert();
?>
@endsection
 
@section('vue_script')
<script>
  new Vue({
  el: "#app",
  data: {
      <?=script_alert()?>
   teacher:{}
  },
  methods: { 
      hello(){
        this.alert_text = "test";
        this.alert_bar=true;
      },
      load(){
        let result =  axios.get('<?=env('link');?>/api/teacher/<?php echo $id; ?>')
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