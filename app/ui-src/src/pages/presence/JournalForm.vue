<template>
  <q-dialog 
    v-model="$store.state.presence.showJournalForm">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('absensi_jurnal_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">          
          <q-input outlined :label="$t('absensi_isi_jurnal')" dense v-model="journal.description" type="textarea" />
          <error :label="error.description" />
          <q-separator />

          <q-checkbox 
            v-model="$store.state.presence.helper.homework" 
            @update:model-value="addHomework"
            :label="$t('absensi_sertakan_pr')" 
          />

        <div v-if="helper.homework" class="q-gutter-xs">
          <q-input outlined :label="$t('absensi_input_judul')" dense v-model="journal.homework_title" />
          <error :label="error.homework_title" />

          <q-input outlined :label="$t('absensi_detail_pr')" dense v-model="journal.homework_description" type="textarea" />
          <error :label="error.homework_description" />

          <q-input v-model="selectedDate" outlined dense mask="date" :rules="['date']">
            <template v-slot:append>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy ref="qDateProxy" cover transition-show="scale" transition-hide="scale">
                  <q-date v-model="selectedDate" today-btn>
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup :label="$t('tutup')" color="primary" flat />
                    </div>
                  </q-date>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>   
        </div>
          
        </q-form>
        <q-btn outline color="secondary" style="width: 100%;" 
          v-if="$store.state.presence.salinJurnal"
          @click="$store.dispatch('presence/copyJournal')">
          {{ $t('absensi_salin_jurnal_label') }}
        </q-btn>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" color="negative" v-close-popup />
        <q-btn :label="$t('simpan')" :disable="disableSaveButton" @click="save" color="primary" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { ref } from 'vue'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { mapState, useStore } from 'vuex'
import { todayStr } from '../../composables/date'
import { date } from 'quasar'

export default {
  name: 'JournalForm',
  computed: {
    ...mapState('presence', {
      error: state => state.error,
      helper: state => state.helper,
      disableSaveButton: state => state.helper.disableSaveButton,
      journal: state => state.journal
    }),
  },
  setup() {
    const store = useStore()

    const selectedDate = ref(todayStr)

    const addHomework = () => {
      store.state.presence.journal.due_date = date.formatDate(todayStr, 'YYYY-MM-DD')
    }
    
    const save = () => {
      store.dispatch('presence/saveJournal')
    }

    if(store.state.presence.journal.description !== '') {
      store.state.presence.salinJurnal = false
    }

    return {
      save,
      maximizedDialog, cardDialog,
      addHomework,
      selectedDate,
    }
  }
}
</script>
