<template>
  
  <q-list>
    <q-expansion-item
        v-model="expanded"
        class="shadow-3 overflow-hidden q-mb-md"
        style="border-radius: 25px"
        expand-separator
        icon="perm_identity"
        :label="$t(`day${parseInt(day)+1}`)"
        :caption="caption"
        header-class="bg-primary text-white"
        expand-icon-class="text-white">
        <q-card>
          <q-card-section>
            <q-toggle :label="$t('siabsen_must_present')" 
              v-model="store.state.siabsen.scheduleDays['day' + props.day]['value']" />
            <div class="row q-mb-md">
              <div :class="['col-12 col-sm-6 q-mt-sm', prSm()]">
                <q-input outlined dense :label="$t('siabsen_jam_masuk')" :disable="!currentDay"
                  v-model="$store.state.siabsen.scheduleDays['day' + day]['timein']" readonly>
                  <template v-slot:append>
                  <q-icon name="access_time" class="cursor-pointer">
                    <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                      <q-time v-model="$store.state.siabsen.scheduleDays['day' + day]['timein']" mask="HH:mm:ss" 
                        format24h 
                        :minute-options="minuteOptions">
                        <div class="row items-center justify-end">
                          <q-btn v-close-popup label="Close" color="primary" flat />
                        </div>
                      </q-time>
                    </q-popup-proxy>
                  </q-icon>
                </template>
                </q-input>
              </div>
              <div :class="['col-12 col-sm-6 q-mt-sm', prSm()]">
                <q-input outlined dense :label="$t('siabsen_jam_pulang')" :disable="!currentDay"
                  v-model="$store.state.siabsen.scheduleDays['day' + day]['timeout']" readonly>
                  <template v-slot:append>
                  <q-icon name="access_time" class="cursor-pointer">
                    <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                      <q-time v-model="$store.state.siabsen.scheduleDays['day' + day]['timeout']" mask="HH:mm:ss" 
                        format24h 
                        :minute-options="minuteOptions">
                        <div class="row items-center justify-end">
                          <q-btn v-close-popup label="Close" color="primary" flat />
                        </div>
                      </q-time>
                    </q-popup-proxy>
                  </q-icon>
                </template>
                </q-input>
              </div>
            </div>
          </q-card-section>
        </q-card>
    </q-expansion-item>
  </q-list>
</template>

<style>
.q-item__label--caption {
	color: rgba(255, 255, 255, 0.7) !important;
}
</style>

<script setup>
import { useQuasar } from 'quasar'
import { watch, computed } from 'vue'
import { useStore } from 'vuex'
import { t } from 'src/composables/common'

const $q = useQuasar()
const store = useStore()

const currentDay = computed(() => store.state.siabsen.scheduleDays['day' + props.day]['value'])

const caption = computed(() => {
  return currentDay.value ? t('siabsen_must_present') : t('siabsen_no_schedule')
}) 

const mustAttend = computed(() => currentDay.value)
watch(mustAttend, () => {
  const timeinConfig = computed(() => store.state.siabsen.presenceConfig.intime)
  const timeoutConfig = computed(() => store.state.siabsen.presenceConfig.outtime)

  if(mustAttend.value) {
    store.state.siabsen.scheduleDays['day' + props.day]['timein'] = timeinConfig.value + ':00'
    store.state.siabsen.scheduleDays['day' + props.day]['timeout'] = timeoutConfig.value + ':00'
  } else {
    store.state.siabsen.scheduleDays['day' + props.day]['timein'] = ''
    store.state.siabsen.scheduleDays['day' + props.day]['timeout'] = ''
  }
})

const props = defineProps(['day', 'expanded'])

const prSm = () => {
  return $q.screen.lt.sm ? '' : 'q-pr-sm'
}

const minuteOptions = [
  0, 5, 10, 15, 20, 25, 
  30, 35, 40, 45, 50, 55
]

</script>