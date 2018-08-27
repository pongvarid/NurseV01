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

<v-container grid-list-md>
        
        {{-- <table  width="100%" class="table">
                <thead>
                    <tr>
                        <th>รหัสนิสิต</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>คณะ</th>
                        <th>สาขา</th>
                        <th>แบบฝึกหัด</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-for="data in datas">
                    <tr>
                        <td>@{{ data.student }}</td>
                        <td>@{{JSON.parse(data.data).FirstName_TH}} @{{JSON.parse(data.data).LastName_TH}}</td>
                        <td>@{{JSON.parse(data.data).FacultyName_TH}}</td>
                        <td>@{{JSON.parse(data.data).ProgramName_TH}}</td>
                        <td>@{{ data.name }}</td>
                        <td>@{{ data.score }}</td>
                    </tr>
                    </template>
                </v-data-table>
                </tbody>
            </table>
        --}}
    <template>
        <v-data-table
          :headers="headers"
          :items="datas"
          :pagination.sync="pagination"
          class="elevation-1"
          hide-actions 
        >
        <template slot="items" slot-scope="props">
            {{-- <table>
                <thead>
                    <tr>
                        <th>@{{ props.item.name }}</th>
                    </tr>  
                </thead>
            </table> --}}
            <tr>
                <td>@{{ props.item.student }}</td>
                <td>@{{JSON.parse(props.item.data).FirstName_TH}} @{{JSON.parse(props.item.data).LastName_TH}}</td>
                <td>@{{JSON.parse(props.item.data).FacultyName_TH}}</td>
                <td>@{{JSON.parse(props.item.data).ProgramName_TH}}</td>
                <td>@{{ props.item.name }}</td>
                <td>@{{ props.item.score }}</td>
            </tr>               
        </template>
        </v-data-table>
</template>
</v-container>

@endsection
 
@section('vue_script')
<script>
    new Vue({
  el: "#app",
  data: {
    datas:[],
    headers: [
          { text: 'รหัสนิสิต', value: 'student', sortable: false, },
          { text: 'ชื่อ-นามสกุล', value: '' },
          { text: 'คณะ', value: '' },
          { text: 'สาขา', value: '' },
          { text: 'แบบฝึกหัด', value: 'name' },
          { text: 'คะแนน', value: 'score' },
        ],
        pagination: {
          sortBy: 'student',
        },
  },
  methods: { 
      
    getExport(){
        axios.get("/api/score/{{request()->route('id')}}")
        .then((r)=>{
            this.datas = r.data;
        }).catch((e)=>{
            alert('error: '+e);
        });
    },
    load(){
       this.getExport();
    }
  },
  mounted(){
      this.load();
  }
});

</script>
@endsection