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
      <add-parent-form :lang="lang" />
      <edit-parent-form :lang="lang" />
      <delete-confirm :lang="lang" vuex-module="parent" />
      <parent-table :lang="lang" />
    </q-card>
  </div>
</template>

<script>
import locale from '../../mixins/fetch-lang'
import SearchBox from 'components/SearchBox'
import RowDropdown from 'components/RowDropdown'
import DeleteConfirm from 'components/DeleteConfirm'
import ParentTable from './ParentTable'
import MainButton from './MainButton'
import AddParentForm from './AddParentForm'
import EditParentForm from './EditParentForm'

export default {
  name: 'ParentMain',
  mixins: [locale], 
  components: { 
    ParentTable, SearchBox, 
    MainButton, RowDropdown,
    AddParentForm, EditParentForm,
    DeleteConfirm
  },
  data () {
    return {}
  },
  mounted () {
    setTimeout(() => {
      this.fetchLang('Admin')
      this.fetchLang('AdminOrtu')   
      this.fetchLang('AdminUser')          
    }, 1000)
  },
  setup () {
    
    return {}
  }
}
</script>
