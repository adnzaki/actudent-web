<template>
  <q-dialog v-model="$store.state.schedule.showSettingsForm"
    @before-show="$store.commit('schedule/getSettings')">
    <q-card class="q-pa-sm" style="width: 400px">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('menu_pengaturan') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-md q-mb-md">
          <q-input outlined :label="`${$t('jadwal_label_alokasi')} (${$t('jadwal_menit')})`" 
            dense v-model="$store.state.schedule.schedule.allocation"
            :rules="[val => val.match(/[^0-9]/) === null && val !== '' || $t('jadwal_alokasi_natural')]" 
          />

          <q-input outlined v-model="$store.state.schedule.schedule.startTime" mask="time" :rules="['time']">
            <template v-slot:append>
              <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                  <q-time v-model="$store.state.schedule.schedule.startTime" format24h>
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-time>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
        </q-form>

      </q-card-section>

      <q-separator/>

      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" color="negative" v-close-popup />
        <q-btn :label="$t('simpan')" 
          :disable="disableSaveButton" 
          @click="$store.dispatch('schedule/saveSchedules')" 
          color="primary" padding="8px 20px" 
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed } from 'vue'
import { useStore } from 'vuex'
import { useI18n } from 'vue-i18n'

export default {
  name: 'MappingSettingForm',
  setup() {
    const { t } = useI18n()
    const store = useStore()

    const disableSaveButton = computed(() => store.state.schedule.schedule.disableSaveButton)

    return {
      disableSaveButton
    }
  }
}
</script>
