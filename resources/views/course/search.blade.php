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
  <v-text-field v-model="search" append-icon="search" label="ค้นหา" single-line hide-details></v-text-field>
  <v-btn @click="searchCouse()">ค้นหา</v-btn>

  <!--// //course}}*/ -->
  <v-card>
    <v-container fluid grid-list-lg>
      <v-layout row wrap>
        <template v-for="data in course">
        <v-flex xs3 >
          <v-card color="blue-grey darken-2" class="white--text">
            <v-card-title primary-title>
              <div class="headline">@{{data.name}}</div>
              <div><br>@{{data.code}}</div>
            </v-card-title>
            <v-card-actions>
              <v-btn flat dark @click="viewCouse(data.id)">รายละเอียด</v-btn>
            </v-card-actions>
          </v-card>
        </v-flex>
      </template>
      </v-layout>
    </v-container>
  </v-card>

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
  },
methods: {
  searchCouse(){
    axios.get("/api/search_course/"+this.search)
    .then((r) => {
          this.course = r.data;  
      }).catch((e) => { 
          alert('error');
      });
  },
      viewCouse(id){
        window.location = "/course/register/"+id;
      }
  },
  mounted(){
      //this.load();
  }
});

</script>
@endsection