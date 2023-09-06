<template>
  <div :class="wrapperPadding()">
    <q-card class="my-card">
      <q-card-section class="q-mb-md">
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t('menu_parent') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('menu_parent') }}
        </div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <row-dropdown class="q-mt-sm" />
          <search-box :label="$t('ortu_cari')" class="q-mt-sm" />
        </div>
      </q-card-section>
      <add-parent-form />
      <edit-parent-form />
      <delete-confirm :store="parent" @action="parent.deleteParent()" />
      <parent-table />
    </q-card>
  </div>
</template>

<script>
import ParentTable from './ParentTable.vue'
import MainButton from './MainButton.vue'
import AddParentForm from './AddParentForm.vue'
import EditParentForm from './EditParentForm.vue'
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import { useParentStore } from 'src/stores/parent'

export default {
  name: 'ParentMain',
  components: {
    ParentTable,
    MainButton,
    AddParentForm,
    EditParentForm,
  },
  setup() {
    return {
      titleSpacing,
      wrapperPadding,
      parent: useParentStore(),
    }
  },
}
</script>
