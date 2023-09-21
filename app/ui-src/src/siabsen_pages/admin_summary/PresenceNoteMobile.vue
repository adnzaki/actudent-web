<template>
  <div class="q-px-md q-mb-lg" style="margin-top: -10px">
    <q-card
      :class="[shadow, bgColor]"
      style="border-radius: 10px; min-height: 180px"
    >
      <q-card-section>
        <div class="text-subtitle1 q-mb-xs text-uppercase text-white">
          <q-icon name="summarize" size="sm" style="bottom: 2px" />
          {{ $t('siabsen_presence_note') }}
        </div>
        <q-separator color="blue-grey-1" />
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">
              {{ $t('absensi_hadir') }}
            </div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">
              {{ presenceDetail.present }} {{ $t('hari') }}
            </div>
          </div>
        </div>
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">
              {{ $t('absensi_izin') }}
            </div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">
              {{ presenceDetail.permit }} {{ $t('hari') }}
            </div>
          </div>
        </div>
        <div class="row q-mt-sm">
          <div class="col-8">
            <div class="text-body2 text-bold text-white">
              {{ $t('absensi_alfa') }}
            </div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">
              {{ presenceDetail.absent }} {{ $t('hari') }}
            </div>
          </div>
        </div>
        <div class="row q-mt-sm" @click="accumulationInfo = !accumulationInfo">
          <div class="col-8 cursor-pointer">
            <div class="text-body2 text-bold text-white">
              {{ $t('siabsen_akumulasi_hadir') }}
              <q-icon style="margin-top: -5px" name="o_info" />
              <q-tooltip anchor="bottom end" self="center end">{{
                $t('siabsen_akumulasi_desc')
              }}</q-tooltip>
              <p v-if="accumulationInfo && $q.screen.lt.sm">
                <small
                  ><i>{{ $t('siabsen_akumulasi_desc') }}</i></small
                >
              </p>
            </div>
          </div>
          <div class="col-4">
            <div class="text-body2 text-right text-bold text-white">
              {{ presenceDetail.accumulation }} {{ $t('hari') }}
            </div>
          </div>
        </div>
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
import { inject, ref, computed } from 'vue'
import { useQuasar } from 'quasar'

const $q = useQuasar()
const props = defineProps({
  bgColor: {
    type: String,
    default: 'bg-teal',
  },
})

const presenceDetail = inject('presenceDetail')
const accumulationInfo = ref(false)
const shadow = computed(() => ($q.dark.isActive ? '' : 'shadow-8'))
</script>
