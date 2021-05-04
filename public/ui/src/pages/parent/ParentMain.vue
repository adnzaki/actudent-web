<template>
  <div class="q-pa-md">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6 text-capitalize">{{ lang.ortu_title }}</div>
        <div class="row">
          <search-box 
            :label="lang.ortu_cari" 
            add-class="offset-sm-6 offset-md-8" 
            vuex-module="parent"
          />
        </div>
      </q-card-section>
      <parent-table :lang="lang" />
    </q-card>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import locale from '../../mixins/fetch-lang'
import ParentTable from './ParentTable'
import SearchBox from 'components/SearchBox'

export default defineComponent({
  name: 'ParentMain',
  mixins: [locale], 
  components: { ParentTable, SearchBox },
  data () {
    return {}
  },
  mounted () {
    setTimeout(() => {
      this.fetchLang('Admin')
      this.fetchLang('AdminOrtu')
    }, 500)
  },
  setup () {
    return {
      
    }
  }
})
</script>
