<template>
  <q-card class="my-card">
    <q-card-section>
      <div class="row">
        <q-btn
          color="teal"
          flat
          rounded
          class="back-button"
          icon="arrow_back"
          @click="$router.push('/teacher-presence/events')"
        />
        <div
          class="text-subtitle1 text-uppercase q-mt-xs page-title-pl-5"
          v-if="$q.screen.lt.sm"
        >
          {{ $t('siabsen_event_attendance') }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('siabsen_event_attendance') }}
        </div>
      </div>
    </q-card-section>
    <!-- content here -->
    <q-card-section>
      <div class="row q-mb-sm" style="margin-top: -15px">
        <div class="col-12 col-md-2">{{ $t('agenda_label_nama') }}:</div>
        <div class="col-12 col-md-10">
          <strong>{{ agenda.agenda_name }}</strong>
        </div>
      </div>
      <div class="row q-mb-sm">
        <div class="col-12 col-md-2">{{ $t('agenda_label_start') }}:</div>
        <div class="col-12 col-md-10">
          <strong>{{
            $formatDate(agenda.agenda_start, 'dddd, DD MMM YYYY | HH:mm')
          }}</strong>
        </div>
      </div>
      <div class="row q-mb-sm">
        <div class="col-12 col-md-2">{{ $t('agenda_label_end') }}:</div>
        <div class="col-12 col-md-10">
          <strong>{{
            $formatDate(agenda.agenda_end, 'dddd, DD MMM YYYY | HH:mm')
          }}</strong>
        </div>
      </div>
      <div class="row q-mb-sm">
        <div class="col-12 col-md-2">{{ $t('agenda_detail_title') }}:</div>
        <div class="col-12 col-md-10">
          <strong>{{ agenda.agenda_description }}</strong>
        </div>
      </div>
    </q-card-section>
    <guest-list />
  </q-card>
</template>

<script>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import GuestList from './GuestList.vue'
import { useAgendaStore } from 'src/stores/agenda'
import { useSiabsenStore } from 'src/stores/siabsen'
import { titleSpacing } from 'src/composables/screen'

export default {
  components: {
    GuestList,
  },
  setup() {
    const store = useSiabsenStore()
    const agenda = useAgendaStore()
    const route = useRoute()

    store.getAttendance(route.params.agendaId)
    store.getDetail(route.params.agendaId)

    return {
      agenda: computed(() => agenda.detail),
      titleSpacing,
    }
  },
}
</script>
