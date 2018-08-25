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
        <v-flex >
            <v-layout row wrap>
                <v-flex d-flex>
                    <v-card>
                        <v-toolbar color="box-green" dark>
                            <v-icon>far fa-list-alt</v-icon>
                            <v-toolbar-title>ประวัติ</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                                <template>
                                        <v-data-table
                                          :headers="headers"
                                          :items="logs"
                                          class="elevation-1"
                                        >
                                        <template slot="items" slot-scope="data" v-if="data.item.user == <?php echo $user; ?>">
                                            <td>@{{ data.item.event }}</td>
                                            <td>@{{ data.item.created_at }}</td>
                                        </template>
                                        </v-data-table>
                                </template>
                        </v-card-text>
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
    //count:1,
    logs:{},
    headers: [
          { text: 'ประวัติ', value: 'event' },
          { text: 'วันที่', value: 'created_at' },
        ],
  },
  methods: { 
    getLog(){
        axios.get("/api/log_data?type=student")
        .then((r)=>{
            this.logs = r.data;
        }).catch((e)=>{
            alert('error:'+e);
        })
    },
    load(){
        this.getLog();
    }
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection