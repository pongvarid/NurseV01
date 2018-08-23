<?php 
/*-------------------SET SESSION-----------------------*/
session_start();
$user = isset($_SESSION['user']); 
if(!$user){ echo '<meta http-equiv="refresh" content="0; url=/" />';}else{
    $id = $_SESSION['user'];
}
 //echo $id;
?> 
@extends('core.vuetify') 
@section('vue')

<div id="app">
  <v-container>
    <v-flex d-flex xs12 sm12>
      <v-layout row wrap>
        <v-flex d-flex>
          <v-card>
            <v-toolbar color="box-purple" dark>
              <v-icon>fas fa-align-justify </v-icon>
              <v-toolbar-title>รายวิชา</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-text-field v-model="search" label="ค้นหา" single-line hide-details></v-text-field>
              <v-btn @click="searchCouse()">ค้นหา</v-btn>
            </v-toolbar>
            <v-container fluid grid-list-lg>
              <v-layout row wrap>
                <template v-if="!course">
                  <v-flex class="text-xs-center">
                    <h3>
                    ค้นหารายวิชา
                    </h3>
                  </v-flex>
                </template>
                <template v-if="course && course == '' ">
                    <v-flex class="text-xs-center">
                      <h3>
                      ไม่มีรายวิชา
                      </h3>
                    </v-flex>
                  </template>
                <template v-for="data in course" v-if="data.state != 0">
                    <v-flex xs12 sm4>
                      <v-card color="w3-container w3-light-grey" >
                        <v-card-title primary-title>
                            <div>
                              <div><img style="width:30%;" 
                                src="https://cdn0.iconfinder.com/data/icons/interior-and-decor-vol-1-1/512/15-128.png"
                                alt=""></div>
                              <div class="headline">รหัสวิชา: @{{data.code}}</div>
                              <div>ชื่อวิชา: @{{data.name.split(',')[1]}} (@{{data.name.split(',')[2]}})</div>
                            </div>
                        </v-card-title>
                        <v-divider light></v-divider>
                        <v-card-actions>
                          <v-btn flat dark outline color="indigo" @click="viewCouse(data.id)">รายละเอียด</v-btn>
                        </v-card-actions>
                      </v-card>
                    </v-flex>
                  </template>
              </v-layout>
            </v-container>
          </v-card>
        </v-flex>
      </v-layout>
    </v-flex>
    </v-cotainer>
</div>
@endsection
 
@section('vue_script')
<script>
  new Vue({
  el: '#app',
  data: {
    course:'',
    search: '',
    dataDB:{},
    tmp:[],
  },
methods: {
  searchCouse(){
    axios.get("/api/search_course/"+this.search)
    .then((r) => {
          this.course = r.data;
        
      }).catch((e) => { 
          alert('กรุณากรอกข้อมูลใหม่อีกครั้ง');
      });
  },
  viewCouse(id){
    window.location = "/course/register/"+id;
  },
  load(){
    let result =  axios.get('/api/admin/course/1') 
    .then((r) => {
      this.tmp = r.data;  
    
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