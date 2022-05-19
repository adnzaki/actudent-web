<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_agenda') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('menu_agenda') }}</div>
        <div :class="['row', titleSpacing()]">
          <!-- <main-button class="q-mt-sm" />
          <row-dropdown vuex-module="parent" class="q-mt-sm" />
          <search-box :label="$t('ortu_cari')" vuex-module="parent" class="q-mt-sm" /> -->
        </div>
      </q-card-section>
      <agenda-add-form />
      <!-- <delete-confirm vuex-module="parent" action="deleteParent" /> -->
      <!-- <parent-table /> -->
      <calendar />
    </q-card>
  </div>
</template>

<script>
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import Calendar from './Calendar.vue'
import AgendaAddForm from './AgendaAddForm.vue'

export default {
  components: { Calendar, AgendaAddForm },
  name: 'AgendaMain',
  setup () {
    return { wrapperPadding, titleSpacing }
  }
}
</script>
