<template>
  <q-card-section>
    <q-form class="q-gutter-xs">
      <div class="row">
        <div class="col-12 col-sm-6 q-mt-sm q-pr-sm">
          <q-input
            outlined
            dense
            :label="$t('siabsen_jam_masuk')"
            v-model="store.presenceConfig.intime"
            readonly
          >
            <template v-slot:append>
              <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy
                  cover
                  transition-show="scale"
                  transition-hide="scale"
                >
                  <q-time
                    v-model="store.presenceConfig.intime"
                    mask="HH:mm"
                    format24h
                    :minute-options="minuteOptions"
                  >
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-time>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
        </div>
        <div class="col-12 col-sm-6 q-my-sm q-pr-sm">
          <q-input
            outlined
            dense
            :label="$t('siabsen_jam_pulang')"
            v-model="store.presenceConfig.outtime"
            readonly
          >
            <template v-slot:append>
              <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy
                  cover
                  transition-show="scale"
                  transition-hide="scale"
                >
                  <q-time
                    v-model="store.presenceConfig.outtime"
                    mask="HH:mm"
                    format24h
                    :minute-options="minuteOptions"
                  >
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-time>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
        </div>
        <div class="col-12 col-sm-6 q-mt-sm q-pr-sm">
          <q-input
            outlined
            dense
            label="Latitude"
            v-model="store.presenceConfig.lat"
          />
          <error :label="error.lat" />
        </div>
        <div class="col-12 col-sm-6 q-my-sm q-pr-sm">
          <q-input
            outlined
            dense
            label="Longitude"
            v-model="store.presenceConfig.long"
          />
          <error :label="error.long" />
        </div>
      </div>
      <div class="q-pr-sm">
        <q-btn
          style="width: 100%"
          :href="mapsUrl"
          target="_blank"
          :class="addButton"
          icon="location_on"
          :label="$t('siabsen_open_maps')"
        />
      </div>
      <div class="row">
        <div class="col-12 col-sm-6 q-mt-md q-pr-sm">
          <q-input
            maxlength="3"
            outlined
            dense
            :label="$t('siabsen_toleransi_telat')"
            v-model="store.presenceConfig.tolerance"
          />
          <error :label="error.tolerance" />
        </div>
        <div class="col-12 col-sm-6 q-my-md q-pr-sm">
          <q-input
            outlined
            dense
            :label="$t('siabsen_batas_range')"
            v-model="store.presenceConfig.range"
          />
          <error :label="error.range" />
        </div>
      </div>
    </q-form>
  </q-card-section>
  <q-separator />
  <q-card-actions align="right">
    <q-btn
      :label="$t('simpan')"
      class="mobile-form-btn save-btn q-ml-md"
      :disable="store.helper.disableSaveButton"
      @click="save"
      unelevated
      style="margin-right: 20px"
    />
  </q-card-actions>
</template>

<script>
import { computed } from 'vue'
import { useSiabsenStore } from 'src/stores/siabsen'
import { addButton } from 'src/composables/mode'

export default {
  setup() {
    const store = useSiabsenStore()
    store.getDetailConfig()

    store.helper.disableSaveButton = false
    return {
      store,
      addButton,
      error: computed(() => store.configError),
      mapsUrl: computed(() => {
        let lat = store.presenceConfig.lat,
          long = store.presenceConfig.long

        return `https://www.google.com/maps/@${lat},${long},15z`
      }),
      minuteOptions: [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50, 55],
      save() {
        store.saveConfig()
      },
    }
  },
}
</script>
