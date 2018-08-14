<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />';}
else{
    $id = $_SESSION['user']; 
}
?> 
@extends('core.vuetify') 

@section('vue')
<div>
    <v-toolbar color="cyan" dark tabs>
        <v-toolbar-side-icon><v-icon>fas fa-user-circle</v-icon></v-toolbar-side-icon>
  
        <v-toolbar-title>สวัสดี @{{student.FirstName_TH}}&nbsp;@{{student.LastName_TH}}</v-toolbar-title>

        <v-spacer></v-spacer>

      

        <v-tabs slot="extension" v-model="model" centered color="cyan" slider-color="yellow">
            <v-tab key="1" >ข้อมูลนิสิต</v-tab>
            <v-tab key="2" >รายวิชาที่ลงเรียน</v-tab>
            <v-tab key="3">ประวัติการใช้งาน</v-tab>
        </v-tabs>
    </v-toolbar>

    <v-tabs-items v-model="model">
        <v-tab-item id="1" key="1">
            <v-card flat>
                <v-card-text >
                    ข้อมูลนิสิต
                </v-card-text>
            </v-card>
        </v-tab-item>
        <v-tab-item id="2" key="2">
            <v-card flat>
                <v-card-text >
                    รายวิชาที่ลงเรียน
                </v-card-text>
            </v-card>
        </v-tab-item>
        <v-tab-item id="3" key="3">
            <v-card flat>
                <v-card-text>ประวัติการใช้งาน</v-card-text>
            </v-card>
        </v-tab-item>
    </v-tabs-items>
</div>
@endsection
 
@section('vue_script')
<script>
    new Vue({
  el: "#app",
  data: {
    model: 'tab-2',

   student:{}
  },
  methods: { 
      hello(){
        this.alert_text = "test";
        this.alert_bar=true;
      },
      load(){
        let result =  axios.get('<?=env('link');?>/api/student/data/<?php echo $id; ?>')
      .then((r) => {
          this.student = r.data;
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