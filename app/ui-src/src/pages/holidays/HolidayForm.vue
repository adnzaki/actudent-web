<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showForm"
    @before-show="formOpen"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t('libur_add_form') }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>
      <q-card-section class="scroll card-section"
        ><q-form class="q-gutter-xs">
          <q-input
            outlined
            :label="$t('libur_col_title')"
            dense
            v-model="store.postData.holiday_title"
          />
          <ac-error :label="error.holiday_title" />

          <!-- Start date -->
          <q-input outlined dense v-model="dateStartText" readonly>
            <template v-slot:append>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy
                  cover
                  transition-show="scale"
                  transition-hide="scale"
                >
                  <q-date v-model="store.postData.start_date" mask="YYYY-MM-DD">
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-date>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
          <ac-error :label="error.start_date" />
          <!-- #Start Date -->

          <!-- End date -->
          <q-input outlined dense v-model="dateEndText" readonly>
            <template v-slot:append>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy
                  cover
                  transition-show="scale"
                  transition-hide="scale"
                >
                  <q-date v-model="store.postData.end_date" mask="YYYY-MM-DD">
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-date>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
          <ac-error :label="error.end_date" />
          <!-- #End Date -->
        </q-form></q-card-section
      >
      <q-separator />
      <q-card-actions align="right">
        <q-btn
          flat
          :label="$t('tutup')"
          v-if="!$q.screen.lt.sm"
          color="negative"
          v-close-popup
          class="close-btn"
        />
        <q-btn
          :label="$t('simpan')"
          class="mobile-form-btn save-btn"
          unelevated
          :disable="store.disableSaveButton"
          @click="store.save()"
        />
      </q-card-actions> </q-card
  ></q-dialog>
</template>

<script setup>
import { ref, computed } from 'vue'
import { date, useQuasar } from 'quasar'
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { useHolidaysStore } from 'src/stores/holidays'
import { selectedLang } from '../../composables/date'
import { t } from 'src/composables/common'

const store = useHolidaysStore()
const error = computed(() => store.error)

// managing start and end date value
const dateFormat = 'YYYY-MM-DD'
const defaultDateValue = ref(date.formatDate(new Date(), dateFormat))

const formOpen = () => {
  store.postData.start_date = defaultDateValue.value
  store.postData.end_date = defaultDateValue.value
}

// managing start and end date text that will be shown to users
const dateTextFormat = 'DD MMMM YYYY'
const formatDate = (val) => date.formatDate(val, dateTextFormat, selectedLang)
const dateStartText = computed(
  () => `${t('libur_start_date')}: ${formatDate(store.postData.start_date)}`,
)
const dateEndText = computed(
  () => `${t('libur_end_date')}: ${formatDate(store.postData.end_date)}`,
)
</script>
