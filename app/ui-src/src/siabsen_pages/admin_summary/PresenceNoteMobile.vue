<template>
  <div class="q-px-md q-mb-lg" style="margin-top: -10px">
    <q-card :class="['shadow-8', bgColor]" style="border-radius: 10px">
      <q-card-section>
        <div class="text-subtitle1 q-mb-xs text-uppercase text-white">
          <q-icon name="summarize" size="sm" style="bottom: 2px" />
          {{ $t('siabsen_presence_note') }}
        </div>
        <q-separator color="blue-grey-1" />
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">{{ $t('absensi_hadir') }}</div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">{{ presenceDetail.present }} {{ $t('hari') }}</div>
          </div>          
        </div>
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">{{ $t('absensi_izin') }}</div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">{{ presenceDetail.permit }} {{ $t('hari') }}</div>
          </div>          
        </div>
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">{{ $t('absensi_alfa') }}</div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">{{ presenceDetail.absent }} {{ $t('hari') }}</div>
          </div>          
        </div>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import { inject } from 'vue'

export default {
  props: {
    bgColor: {
      type: String,
      default: 'bg-teal'
    }
  },
  setup() {
    const presenceDetail = inject('presenceDetail')
    return {
      presenceDetail
    }
  },
}
</script>