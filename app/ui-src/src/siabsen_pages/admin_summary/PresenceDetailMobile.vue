<template>
  <div class="mobile-only">
    <presence-note-mobile />
    <time-recap-mobile />
    <div class="q-px-md">
      <div class="text-subtitle-2 text-uppercase text-bold">
        {{ $t('siabsen_detail_absensi') }}
      </div>
    </div>
    <q-list class="q-px-md q-mt-sm q-mb-xl">
      <q-expansion-item
        class="shadow-3 overflow-hidden q-mb-md"
        style="border-radius: 15px"
        expand-separator
        expand-icon-toggle
        icon="perm_identity"
        :label="$formatDate(item.date)"
        header-class="bg-primary text-white"
        expand-icon-class="text-white"
        default-opened
        v-for="(item, index) in presenceDetail.data"
        :key="index"
      >
        <q-card>
          <q-card-section class="q-px-none q-pt-md q-pb-xs">
            <q-chip
              square
              v-if="item.status !== '0'"
              style="font-size: 12px; top: 0; right: -7px"
              class="absolute"
              size="sm"
              :color="badgeColor(item.status)"
              text-color="white"
            >
              {{ item.label }}
            </q-chip>
            <div class="row q-mb-sm q-mt-sm">
              <div class="col-6 text-center">
                <p class="text-grey-8" style="font-size: 12px">
                  {{ $t('siabsen_in') }}
                </p>
                <q-chip
                  style="margin-top: -10px"
                  size="md"
                  :color="timeColor(item.required)"
                  text-color="white"
                >
                  <strong v-if="item.in !== '-'">{{ item.in }}</strong>
                  <strong v-else>--:--</strong>
                </q-chip>
              </div>
              <div class="col-6 text-center">
                <p class="text-grey-8" style="font-size: 12px">
                  {{ $t('siabsen_out') }}
                </p>
                <q-chip
                  style="margin-top: -10px"
                  size="md"
                  :color="timeColor(item.required)"
                  text-color="white"
                >
                  <strong v-if="item.out !== '-'">{{ item.out }}</strong>
                  <strong v-else>--:--</strong>
                </q-chip>
              </div>
            </div>
            <div class="row q-mb-md">
              <div class="col-4 text-center">
                <small class="text-grey-9">{{ $t('siabsen_terlambat') }}</small
                ><br />
                <small class="text-caption text-bold text-negative">{{
                  badgeLabel(item.late)
                }}</small>
              </div>
              <q-separator vertical />
              <div class="col-4 text-center">
                <small class="text-grey-9">{{ $t('siabsen_worktime') }}</small
                ><br />
                <small class="text-caption text-bold text-blue">{{
                  badgeLabel(item.work)
                }}</small>
              </div>
              <q-separator vertical />
              <div class="col-3 text-center q-ml-sm">
                <small class="text-grey-9">{{ $t('siabsen_overtime') }}</small
                ><br />
                <small class="text-caption text-bold text-positive">{{
                  badgeLabel(item.over)
                }}</small>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </q-expansion-item>
    </q-list>
    <q-separator />
  </div>
</template>

<script>
import { computed, provide } from 'vue'
import { t } from 'src/composables/common'
import TimeRecapMobile from './TimeRecapMobile.vue'
import { useSiabsenStore } from 'src/stores/siabsen'
import { checkColWidth } from 'src/composables/screen'
import PresenceNoteMobile from './PresenceNoteMobile.vue'

export default {
  components: { TimeRecapMobile, PresenceNoteMobile },
  setup() {
    const store = useSiabsenStore()
    const presenceDetail = computed(() => store.presenceDetail)
    provide('presenceDetail', presenceDetail)

    return {
      timeColor: (required) => (required === '1' ? 'blue' : 'grey-4'),
      badgeLabel(text) {
        return text !== '-' ? text : `0 ${t('siabsen_menit')}`
      },
      badgeColor: (status) => {
        const colors = {
          alfa: 'negative',
          hadir: 'positive',
          izin: 'blue',
        }

        return colors[status]
      },
      presenceDetail,
      checkColWidth,
    }
  },
}
</script>
