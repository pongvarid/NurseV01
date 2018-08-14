

@extends('core.vuetify')


 @section('vue')

<div id="app">
  <v-app id="inspire">
    <v-card>
      <v-card-title>
        Nutrition
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="search"
          label="Search"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :headers="headers"
        :items="tmp"
        :search="search"
      >
        <template slot="items" slot-scope="props">
          <td>@{{ props.item.name }}</td>
          <td class="text-xs-right">@{{ props.item.username }}</td>
          <td class="text-xs-right">@{{ props.item.remark }}</td>
        </template>
        <v-alert slot="no-results" :value="true" color="error" icon="warning">
          Your search for "@{{ search }}" found no results.
        </v-alert>
      </v-data-table>
    </v-card>
  </v-app>
</div>
 @endsection

 @section('vue_script')
 <script>
new Vue({
  el: '#app',
  data () {
    return {
        search: '',
      totalDesserts: 0,
      tmp: [],
      loading: true,
      pagination: {},
      headers: [
        {
          text: 'Name',
          align: 'left',
          sortable: false,
          value: 'name'
        },
        { text: 'User Name', value: 'username' },
        { text: 'Remark', value: 'remark' }
      ]
    }
  },
  watch: {
    pagination: {
      handler () {
        this.getDataFromApi()
          .then(data => {
            this.tmp = data.items
            this.totalDesserts = data.total
          })
      },
      deep: true
    }
  },
  mounted () {
    this.load();

    this.getDataFromApi()
      .then(data => {
        this.tmp = data.items
        this.totalDesserts = data.total
      })
  },
  methods: {
    getDataFromApi () {
      this.loading = true
      return new Promise((resolve, reject) => {
        const { sortBy, descending, page, rowsPerPage } = this.pagination

        let items = this.getDesserts()
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
    load(){
         let result =  axios.get('<?=env('link');?>/api/admin/1')
       .then((r) => {
           this.tmp = r.data;
       }).catch((e) => {
           alert('error');
       });
       }
  }
});


 </script>
 @endsection
