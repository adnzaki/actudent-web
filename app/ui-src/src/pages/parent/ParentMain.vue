<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-h6 text-capitalize">{{ lang.menu_parent }}</div>
        <div class="row q-mt-md">
          <main-button class="q-mt-sm" />
          <row-dropdown vuex-module="parent" class="q-mt-sm" />
          <search-box :label="lang.ortu_cari" vuex-module="parent" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-parent-form />
      <edit-parent-form />
      <delete-confirm vuex-module="parent" action="deleteParent" />
      <parent-table />
    </q-card>
  </div>
</template>

<script>
import { computed } from 'vue'
import ParentTable from './ParentTable.vue'
import MainButton from './MainButton.vue'
import AddParentForm from './AddParentForm.vue'
import EditParentForm from './EditParentForm.vue'
import { wrapperPadding } from 'src/composables/screen'

export default {
  name: 'ParentMain',
  components: { 
    ParentTable, MainButton,
    AddParentForm, EditParentForm
  },
  provide() {
    return {
      textLang: computed(() => this.lang)
    }
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
    
    return { wrapperPadding }
  }
}
</script>
