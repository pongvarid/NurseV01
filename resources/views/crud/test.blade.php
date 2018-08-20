@extends('core.vuetify') 
@section('vue')
<v-btn color="green" @click="dialog=true">add</v-btn>
<div v-for="data in tmp">
    <div>
        <pre>@{{data}}</pre>
        <v-btn color="red" @click="deleteData(data.id)">delete</v-btn>
        <v-btn color="blue" @click="updateOpen(data)">update</v-btn>
    </div>
</div>

<v-dialog v-model="dialog" width="500">
  

    <v-card>
        <v-card-title class="headline blue lighten-2" primary-title>
                <v-btn icon dark @click.native="dialogClose()">
                        <v-icon>close</v-icon>
                      </v-btn>
            <div v-if="!update">Add</div>
            <div v-if="update">Update</div>
        </v-card-title>

        <v-card-text>
            <v-text-field v-model="dataDB.user" label="user" ></v-text-field>
            <v-text-field  v-model="dataDB.type" label="type" ></v-text-field>
            <v-text-field  v-model="dataDB.event" label="event" ></v-text-field>
            <v-btn v-if="!update" @click="saveData()">save</v-btn>
            <v-btn v-if="update"  @click="updateData()">update</v-btn>
        </v-card-text>

    </v-card>
</v-dialog>
@endsection
 
@section('vue_script')
<script>
    new Vue({
  el: "#app",
  data: {
      dialog:false,
      tmp:{},
      dataDB:{},
      update:false,
  },
  methods: { 
    dialogClose(){
        this.dataDB = {};
        this.update = false;
        this.dialog = false;
        this.load();
    },
    updateOpen(tmp){
        this.update = true;
        this.dialog = true;
        this.dataDB = tmp;
    },
    deleteData(id){
        axios
      .delete("/api/logs/"+id)
      .then(function(response) {
        alert('ลบข้อมูลสำเร็จ'); 
       
      })
      .catch(function(error) {
        alert('error');
      });
      this.dialogClose(); 
    },
    updateData(){
        axios
      .put("/api/logs/"+this.dataDB.id,this.dataDB)
      .then(function(response) {
        alert('แก้ไขข้อมูลสำเร็จ'); 
      })
      .catch(function(error) {
        alert('error');
      });
      this.dialogClose(); 
    },
    saveData(){
        axios
      .post("/api/logs",this.dataDB)
      .then(function(response) {
        alert('บันทึกข้อมูลสำเร็จ');
       
      })
      .catch(function(error) {
        alert('error');
      });
      this.dialogClose(); 
    },
      load(){
        let result =  axios.get('/api/logs/1')
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