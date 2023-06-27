<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('menu_kelas') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>{{ $t('menu_kelas') }}</div>
      <div :class="['row', titleSpacing()]">
        <main-button class="q-mt-sm" />
        <row-dropdown class="q-mt-sm" />
        <search-box :label="$t('ortu_cari')" class="q-mt-sm" />
      </div>
    </q-card-section>
    <add-class-form />
    <edit-class-form />
    <delete-confirm :store="store" @action="store.deleteClass()" />
    <class-table />
  </q-card>
</template>

<script>
import { onMounted } from 'vue'
import ClassTable from './ClassTable.vue'
import MainButton from './MainButton.vue'
import AddClassForm from './AddClassForm.vue'
import EditClassForm from './EditClassForm.vue'
import { useClassStore } from 'src/stores/class'
import { titleSpacing } from 'src/composables/screen'

export default {
  name: 'ClassList',
  components: {
    MainButton,
    ClassTable,
    AddClassForm,
    EditClassForm,
  },
  setup() {
    const store = useClassStore()

    onMounted(() => {
      store.getTeacher()
    })

    return {
      titleSpacing,
      store,
    }
  },
}
</script>
