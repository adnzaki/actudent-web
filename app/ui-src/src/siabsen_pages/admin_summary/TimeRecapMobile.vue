<template>
  <div class="q-px-md q-mb-lg" style="margin-top: -10px">
    <q-card :class="['shadow-8', bgColor]" :style="{ borderRadius: '10px', height: cardHeight }">
      <q-card-section>
        <div class="text-subtitle1 q-mb-xs text-uppercase text-white">
          <q-icon name="watch_later" size="sm" style="bottom: 2px" />
          {{ $t('siabsen_rekap_waktu') }}
        </div>
        <q-separator color="blue-grey-1" />
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">{{ $t('siabsen_terlambat') }}</div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">{{ presenceDetail.late }}</div>
          </div>          
        </div>
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">{{ $t('siabsen_worktime') }}</div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">{{ presenceDetail.work }}</div>
          </div>          
        </div>
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">{{ $t('siabsen_overtime') }}</div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">{{ presenceDetail.over }}</div>
          </div>          
        </div>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import { inject } from 'vue'
import { useQuasar } from 'quasar'

export default {
  props: {
    bgColor: {
      type: String,
      default: 'bg-blue'
    }
  },
  setup() {
    const presenceDetail = inject('presenceDetail')
    const $q = useQuasar()

    return {
      presenceDetail,
      cardHeight: $q.screen.lt.sm ? '150px' : '180px'
    }
  },
}
</script>