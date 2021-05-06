<template>
  <div class="q-pa-md">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6 text-capitalize">{{ lang.ortu_title }}</div>
        <div class="row q-mt-md">
          <main-button :lang="lang" class="q-mt-sm" />
          <row-dropdown :lang="lang" vuex-module="parent" class="q-mt-sm" />
          <search-box :label="lang.ortu_cari" vuex-module="parent" class="q-mt-sm" />
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
import MainButton from './MainButton'
import RowDropdown from 'components/RowDropdown'

export default defineComponent({
  name: 'ParentMain',
  mixins: [locale], 
  components: { 
    ParentTable, SearchBox, 
    MainButton, RowDropdown
  },
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
