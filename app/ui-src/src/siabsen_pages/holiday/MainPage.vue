<template>
  <div :class="wrapperPadding()">
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
          {{ $t('siabsen_holiday') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('siabsen_holiday') }}
        </div>
        <div :class="['row', titleSpacing()]">
          <main-button class="q-mt-sm" />
          <row-dropdown class="q-mt-sm" />
          <search-box :label="$t('siabsen_holiday_search')" class="q-mt-sm" />
        </div>
      </q-card-section>
      <!-- <add-parent-form />
      <edit-parent-form /> -->
      <delete-confirm :store="store" @action="store.deleteHoliday()" />
      <!-- <parent-table /> -->
    </q-card>
  </div>
</template>

<script>
// import ParentTable from "./ParentTable.vue";
import MainButton from './MainButton.vue'
// import AddParentForm from "./AddParentForm.vue";
// import EditParentForm from "./EditParentForm.vue";
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import { useSiabsenStore } from 'src/stores/siabsen'

export default {
  name: 'MainPage',
  components: {
    // ParentTable,
    MainButton,
    // AddParentForm,
    // EditParentForm,
  },
  setup() {
    return {
      titleSpacing,
      wrapperPadding,
      store: useSiabsenStore(),
    }
  },
}
</script>
