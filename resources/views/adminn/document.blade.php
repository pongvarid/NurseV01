@extends('core.vuetify') 
@section('vue')
<div id="app" class="container">
  <v-app id="inspire">
    <div>
      <v-toolbar flat color="white">
        <v-toolbar-title>Document</v-toolbar-title>
        <v-divider class="mx-2" inset vertical></v-divider>
        <v-spacer></v-spacer>
        <v-text-field v-model="search" append-icon="search" label="Search" single-line hide-details></v-text-field>
        <v-dialog v-model="dialog" max-width="500px">
          <v-btn slot="activator" color="primary" dark class="mb-2">New Item</v-btn>
          <v-card>
            <v-card-title>
              <span class="headline">
                  <div v-if="!update">Add</div>
                  <div v-if="update">Update</div>
                </span>
            </v-card-title>
            <v-card-text>
              <v-container grid-list-md>
                <v-layout wrap>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="dataDB.name" label="Name"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="dataDB.link" label="Link"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="dataDB.course" label="Course"></v-text-field>
                  </v-flex>
                  <v-flex xs12 sm6 md4>
                    <v-text-field v-model="dataDB.remark" label="Remark"></v-text-field>
                  </v-flex>
                </v-layout>
              </v-container>
            </v-card-text>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" flat @click.native="dialogClose()">Cancel</v-btn>
              <v-btn v-if="!update" @click="saveData()">save</v-btn>
              <v-btn v-if="update" @click="updateData()">update</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
      <v-data-table :headers="headers" :items="tmp" hide-actions:pagination.sync="pagination" :total-items="totalTMP" :loading="loading"
        class="elevation-1" :search="search">
        <template slot="items" slot-scope="props">
          <td>@{{ props.item.name }}</td>
          <td>@{{ props.item.link }}</td>
          <td>@{{ props.item.course }}</td>
          <td>@{{ props.item.remark }}</td>
          <td>@{{ props.item.created_at }}</td>
          <td>@{{ props.item.updated_at }}</td>
          <td class="justify-center layout px-0">
            <v-icon
              small
              class="mr-2"
              @click="updateOpen(props.item)"
            >
              edit
            </v-icon>
            <v-icon
              small
              @click="deleteData(props.item.id)"
            >
              delete
            </v-icon>
          </td>
        </template>
        <template slot="no-data">
            <v-alert slot="no-results" :value="true" color="error" icon="warning">
                Your search for "@{{ search }}" found no results.
            </v-alert>
          </template>
      </v-data-table>
    </div>
  </v-app>
</div>
@endsection
 
@section('vue_script')
<script>
  new Vue({
  el: '#app',
  data: {
    search: '',
    dialog: false,
    headers: [
      { text: 'Name', value: 'name' },
      { text: 'Link', value: 'link' },
      { text: 'Course',value: 'course' },
      { text: 'Remark', value: 'remark' },
      { text: 'Created_at', value: 'created_at' },
      { text: 'Updated_at', value: 'updated_at' },
      { text: 'Actions', value: 'name', sortable: false }
    ],
    tmp: [],
    dataDB:{},
    update:false,
    totalTMP: 0,
    loading: true,
    pagination: {},
  },
  watch: {
      pagination: {
        handler () {
          this.getDataFromApi()
            .then(data => {
              this.datatmp = data.items
              this.totalTMP = data.total
            })
        },
        deep: true
      }
    },
methods: { 
  getDataFromApi () {
        this.loading = true
        return new Promise((resolve, reject) => {
          const { sortBy, descending, page, rowsPerPage } = this.pagination

          let items = this.tmp
          const total = items.length

          if (this.pagination.sortBy) {
            items = items.sort((a, b) => {
              const sortA = a[sortBy]
              const sortB = b[sortBy]

              if (descending) {
                if (sortA < sortB) return 1
                if (sortA > sortB) return -1
                return 0
              } else {
                if (sortA < sortB) return -1
                if (sortA > sortB) return 1
                return 0
              }
            })
          }
          if (rowsPerPage > 0) {
            items = items.slice((page - 1) * rowsPerPage, page * rowsPerPage)
          }
          setTimeout(() => {
            this.loading = false
            resolve({
              items,
              total
            })
          }, 1000)
        })
      },
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
        var confirms = confirm("คุณแน่ใจใช่ไหม ที่จะลบข้อมูล");
        if(confirms){
            axios
      .delete("<?=env('link');?>/api/admin/document/"+id)
      .then(function(response) {
        alert('ลบข้อมูลสำเร็จ'); 
      })
      .catch(function(error) {
        alert('error');
      });
      this.dialogClose(); 
        }
    },
    updateData(){
        console.log();
        axios
      .put("<?=env('link');?>/api/admin/document/"+this.dataDB.id,this.dataDB)
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
      .post("<?=env('link');?>/api/admin/document",this.dataDB)
      .then(function(response) {
        alert('บันทึกข้อมูลสำเร็จ');
       
      })
      .catch(function(error) {
        alert('error');
      });
      this.dialogClose(); 
    },
      load(){
        let result =  axios.get('<?=env('link');?>/api/admin/document/1')
      .then((r) => {
          this.tmp = r.data;  
      }).catch((e) => { 
          alert('error');
      });
      },
      getData () {
        return this.tmp
      }
  },
  mounted(){
      this.load();
      this.getDataFromApi()
        .then(data => {
          this.datatmp = data.items
          this.totalTMP = data.total
        });
  }
});

</script>
@endsection