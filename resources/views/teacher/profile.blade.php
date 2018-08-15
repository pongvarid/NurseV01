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
                <v-toolbar-title>เกี่ยวกับคุณ</v-toolbar-title>
                <v-spacer></v-spacer>
            </v-toolbar>
            <v-list two-line subheader>
             <h2>dsds</h2>
            </v-list>
        </v-card>
    </v-flex>
    <v-flex xs12 sm1></v-flex>
    <v-flex xs12 sm8 >
        <v-card>
            <v-toolbar color="light-blue" dark>
                <v-toolbar-side-icon></v-toolbar-side-icon>
                <v-toolbar-title>รายวิชาที่เปิดสอน</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn dark icon @click="create_course()">
                        <v-icon>fas fa-plus-circle </v-icon>
                       
                      </v-btn>
                      
            </v-toolbar>
            <v-list two-line subheader>
                <v-subheader inset>Folders</v-subheader> 
                <v-divider inset></v-divider>
                <v-subheader inset>Files</v-subheader>
                 
            </v-list>
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
 
   teacher:{}
  },
  methods: { 
    create_course(){
        window.location = "<?=env('link');?>/course/create";
    },
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