<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showJournalForm"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t('absensi_jurnal_title') }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('absensi_isi_jurnal')"
            dense
            v-model="store.journal.description"
            type="textarea"
          />
          <ac-error :label="error.description" />
          <q-separator />

          <q-checkbox
            v-model="store.helper.homework"
            @update:model-value="addHomework"
            :label="$t('absensi_sertakan_pr')"
          />

          <div v-if="store.helper.homework" class="q-gutter-xs">
            <q-input
              outlined
              :label="$t('absensi_input_judul')"
              dense
              v-model="store.journal.homework_title"
            />
            <ac-error :label="error.homework_title" />

            <q-input
              outlined
              :label="$t('absensi_detail_pr')"
              dense
              v-model="store.journal.homework_description"
              type="textarea"
            />
            <ac-error :label="error.homework_description" />

            <q-input
              v-model="store.journal.due_date"
              outlined
              dense
              mask="date"
              :rules="['date']"
            >
              <template v-slot:append>
                <q-icon name="event" class="cursor-pointer">
                  <q-popup-proxy
                    ref="qDateProxy"
                    cover
                    transition-show="scale"
                    transition-hide="scale"
                  >
                    <q-date v-model="store.journal.due_date" today-btn>
                      <div class="row items-center justify-end">
                        <q-btn
                          v-close-popup
                          :label="$t('tutup')"
                          color="primary"
                          flat
                        />
                      </div>
                    </q-date>
                  </q-popup-proxy>
                </q-icon>
              </template>
            </q-input>
          </div>
        </q-form>
        <q-btn
          outline
          color="secondary"
          style="width: 100%"
          class="q-mt-sm"
          :disable="disableSaveButton"
          v-if="store.salinJurnal"
          @click="store.copyJournal()"
        >
          {{ $t('absensi_salin_jurnal_label') }}
        </q-btn>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn
          flat
          v-if="!$q.screen.lt.sm"
          :label="$t('tutup')"
          color="negative"
          v-close-popup
        />
        <q-btn
          class="mobile-form-btn"
          :label="$t('simpan')"
          :disable="disableSaveButton"
          @click="save"
          color="primary"
          padding="8px 20px"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { date } from 'quasar'
import { computed } from 'vue'
import { todayStr } from '../../composables/date'
import { usePresenceStore } from 'src/stores/presence'
import { maximizedDialog, cardDialog } from '../../composables/screen'

export default {
  name: 'JournalForm',
  setup() {
    const store = usePresenceStore()

    const addHomework = () => {
      store.journal.due_date = date.formatDate(todayStr, 'YYYY-MM-DD')
    }

    const save = () => {
      store.saveJournal()
    }

    if (store.journal.description !== '') {
      store.salinJurnal = false
    }

    return {
      save,
      store,
      addHomework,
      maximizedDialog,
      cardDialog,
      error: computed(() => store.error),
      disableSaveButton: computed(() => store.helper.disableSaveButton),
    }
  },
}
</script>
