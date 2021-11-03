<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_kelas') }}</div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('menu_kelas') }}</div>
      <div :class="['row', titleSpacing()]">
        <main-button class="q-mt-sm" />
        <row-dropdown vuex-module="grade" class="q-mt-sm" />
        <search-box :label="$t('kelas_cari')" vuex-module="grade" class="q-mt-sm" />
      </div>
    </q-card-section>
    <add-class-form />
    <edit-class-form />
    <delete-confirm vuex-module="grade" action="deleteClass" />
    <class-table />
  </q-card>
</template>

<script>
import { onMounted} from 'vue'
import { useStore } from 'vuex'
import { titleSpacing } from 'src/composables/screen'
import MainButton from './MainButton.vue'
import ClassTable from './ClassTable.vue'
import AddClassForm from './AddClassForm.vue'
import EditClassForm from './EditClassForm.vue'

export default {
  name: 'ClassList',
  components: {
    MainButton,
    ClassTable,
    AddClassForm,
    EditClassForm
  },
  setup () {   
    const store = useStore()

    onMounted(() => {
      store.commit('grade/getTeacher')
    }) 
    
    return { 
      titleSpacing 
    }
  }
}
</script>
