<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showSettingsForm"
    @before-show="store.getSettings()"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" style="width: 400px">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('menu_pengaturan') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form>
          <q-input
            outlined
            :label="`${$t('jadwal_label_alokasi')} (${$t('jadwal_menit')})`"
            dense
            v-model="store.schedule.allocation"
            :rules="[
              (val) =>
                (val.match(/[^0-9]/) === null && val !== '') ||
                $t('jadwal_alokasi_natural'),
            ]"
            class="q-mb-xs"
          />
          <ac-error :label="error.lesson_hour" />

          <q-input
            outlined
            v-model="store.schedule.startTime"
            mask="time"
            :rules="['time']"
          >
            <template v-slot:append>
              <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy
                  cover
                  transition-show="scale"
                  transition-hide="scale"
                >
                  <q-time v-model="store.schedule.startTime" format24h>
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-time>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
          <ac-error :label="error.start_time" />
        </q-form>
      </q-card-section>

      <q-separator />

      <q-card-actions align="right">
        <q-btn
          v-if="!$q.screen.lt.sm"
          flat
          :label="$t('tutup')"
          color="negative"
          v-close-popup
          class="close-btn"
        />
        <q-btn
          :label="$t('simpan')"
          :disable="disableSaveButton"
          @click="store.saveSettings()"
          class="mobile-form-btn save-btn"
          unelevated
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed } from 'vue'
import { useScheduleStore } from 'src/stores/schedule'
import { maximizedDialog } from '../../composables/screen'

export default {
  name: 'MappingSettingForm',
  setup() {
    const store = useScheduleStore()

    const disableSaveButton = computed(() => store.schedule.disableSaveButton)

    return {
      store,
      maximizedDialog,
      disableSaveButton,
      error: computed(() => store.error),
    }
  },
}
</script>
