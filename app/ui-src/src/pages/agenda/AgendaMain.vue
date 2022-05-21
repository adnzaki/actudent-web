<template>
  <div :class="wrapperPadding()">    
    <q-card class="my-card">
      <q-card-section>
        <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">{{ $t('menu_agenda') }}</div>
        <div class="text-h6 text-capitalize" v-else>{{ $t('menu_agenda') }}</div>
        <div :class="['row', titleSpacing()]">
        </div>
      </q-card-section>
      <agenda-form />
      <delete-confirm 
        vuex-module="agenda" 
        :custom-text="$t('agenda_delete_confirm')" 
        action="delete" />
      <calendar />
    </q-card>
  </div>
</template>

<script>
import { wrapperPadding, titleSpacing } from 'src/composables/screen'
import Calendar from './Calendar.vue'
import AgendaForm from './AgendaForm.vue'

export default {
  components: { Calendar, AgendaForm },
  name: 'AgendaMain',
  setup () {
    return { wrapperPadding, titleSpacing }
  }
}
</script>
