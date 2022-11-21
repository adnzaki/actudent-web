<template>
  <q-dialog no-backdrop-dismiss v-model="$store.state.siabsen.showScheduleForm"
    :maximized="maximizedDialog()"
    @before-show="formOpen"
    @hide="formClose">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize" v-if="$q.screen.lt.sm">
          {{ $store.state.siabsen.staffName }}
        </div>
        <div class="text-h6 text-capitalize" v-else>
          {{ $t('siabsen_atur_jadwal') }}
          {{ $store.state.siabsen.staffName }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>
      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-toggle :label="$t('siabsen_show_all')" v-model="expanded" />
          <daily-schedule day="0" :expanded="expanded" />
          <daily-schedule day="1" :expanded="expanded" />
          <daily-schedule day="2" :expanded="expanded" />
          <daily-schedule day="3" :expanded="expanded" />
          <daily-schedule day="4" :expanded="expanded" />
          <daily-schedule day="5" :expanded="expanded" />
          <daily-schedule day="6" :expanded="expanded" />
        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" v-if="!$q.screen.lt.sm" color="negative" v-close-popup />
        <q-btn class="mobile-form-btn" :label="$t('simpan')" :disable="disableSaveButton" @click="save" color="accent" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { maximizedDialog, cardDialog } from 'src/composables/screen'
import { useStore } from 'vuex'
import DailySchedule from './DailySchedule.vue'
import { ref, computed } from 'vue'

export default {
  components: { DailySchedule },
  setup() {
    const store = useStore()

    return {
      formClose() {
        store.state.siabsen.scheduleDays = {}
      },
      formOpen() {
        store.commit('siabsen/getDetailConfig')
        store.state.siabsen.disableSaveButton = false
      },
      save() {
        store.dispatch('siabsen/updatePresenceSchedule')
      },
      disableSaveButton: computed(() => store.state.siabsen.disableSaveButton),
      expanded: ref(false),
      maximizedDialog, cardDialog
    }
  }
}
</script>