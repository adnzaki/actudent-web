<template>
  <div class="q-px-md q-mb-lg" style="margin-top: -10px">
    <q-card
      :class="[shadow, bgColor]"
      :style="{ borderRadius: '10px', height: cardHeight }"
    >
      <q-card-section>
        <div class="text-subtitle1 q-mb-xs text-uppercase text-white">
          <q-icon name="watch_later" size="sm" style="bottom: 2px" />
          {{ $t('siabsen_rekap_waktu') }}
        </div>
        <q-separator color="blue-grey-1" />
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">
              {{ $t('siabsen_terlambat') }}
            </div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">
              {{ presenceDetail.late }}
            </div>
          </div>
        </div>
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">
              {{ $t('siabsen_worktime') }}
            </div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">
              {{ presenceDetail.work }}
            </div>
          </div>
        </div>
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">
              {{ $t('siabsen_overtime') }}
            </div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">
              {{ presenceDetail.over }}
            </div>
          </div>
        </div>
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
import { inject, computed } from 'vue'
import { useQuasar } from 'quasar'

const $q = useQuasar()
const props = defineProps({
  bgColor: {
    type: String,
    default: 'bg-blue',
  },
})

const cardHeight = $q.screen.lt.sm ? '150px' : '180px'
const presenceDetail = inject('presenceDetail')
const shadow = computed(() => ($q.dark.isActive ? '' : 'shadow-8'))
</script>
