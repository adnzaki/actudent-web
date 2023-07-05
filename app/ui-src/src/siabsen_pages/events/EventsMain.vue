<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="text-subtitle1 text-uppercase" v-if="$q.screen.lt.sm">
        {{ $t('siabsen_kegiatan') }}
      </div>
      <div class="text-h6 text-capitalize" v-else>
        {{ $t('siabsen_kegiatan') }}
      </div>
      <div :class="['row', titleSpacing()]" style="margin-top: 0"></div>
    </q-card-section>
    <agenda-form />
    <month-selector class="q-pa-md" />
    <events-list class="mobile-hide" />
    <events-list-mobile class="mobile-only" />
    <presence-dialog presence-type="agenda" />
    <!-- content here -->
  </q-card>
</template>

<script>
import { titleSpacing } from 'src/composables/screen'
import MonthSelector from './MonthSelector.vue'
import EventsList from './EventsList.vue'
import AgendaForm from 'src/pages/agenda/AgendaForm.vue'
import PresenceDialog from '../dashboard/PresenceDialog.vue'
import EventsListMobile from './EventsListMobile.vue'
import { useQuasar } from 'quasar'
import { provide } from 'vue'
import { useSiabsenStore } from 'src/stores/siabsen'
import { t } from 'src/composables/common'

export default {
  components: {
    MonthSelector,
    EventsList,
    AgendaForm,
    PresenceDialog,
    EventsListMobile,
  },
  setup() {
    const store = useSiabsenStore()
    const $q = useQuasar()

    const openPresenceDialog = (id, canPresent) => {
      if (canPresent === 1) {
        store.presenceType = 'agenda'
        store.agendaId = id
        store.showPresenceDialog = true
      } else {
        if (canPresent === 'ended') {
          $q.dialog({
            title: 'Info',
            message: t('siabsen_event_ended'),
          })
        } else if (canPresent === 'not_started') {
          $q.dialog({
            title: 'Info',
            message: t('siabsen_event_not_started'),
          })
        } else {
          $q.dialog({
            title: 'Info',
            message: t('siabsen_sudah_absen'),
          })
        }
      }
    }

    provide('openPresenceDialog', openPresenceDialog)

    return {
      titleSpacing,
    }
  },
}
</script>
