<template>
  <div style="margin-top: -15px">
    <q-list class="q-px-md q-mt-sm">
      <q-expansion-item
        class="shadow-3 overflow-hidden q-mb-md"
        style="border-radius: 15px"
        expand-separator
        icon="perm_identity"
        :label="$trim(item.name, 30)"
        :caption="item.nip"
        header-class="bg-primary text-white"
        expand-icon-class="text-white"
        default-opened
        v-for="(item, index) in data" :key="index">
          <q-card>
            <q-card-section class="q-px-none q-pt-sm">
              <div class="row q-mb-sm">
                <div class="col-6 text-center">
                  <p class="text-grey-8" style="font-size: 12px">{{ $t('siabsen_in') }}</p>
                  <q-chip style="margin-top: -10px" size="md" color="blue" text-color="white">
                    <strong v-if="item.in !== '-'">{{ item.in }}</strong>
                    <strong v-else>--:--:--</strong>
                  </q-chip>
                </div>
                <div class="col-6 text-center">
                  <p class="text-grey-8" style="font-size: 12px">{{ $t('siabsen_out') }}</p>
                  <q-chip style="margin-top: -10px" size="md" color="blue" text-color="white">
                    <strong v-if="item.out !== '-'">{{ item.out }}</strong>
                    <strong v-else>--:--:--</strong>
                  </q-chip>
                </div>
              </div>
              <div class="row q-mb-md">
                <div class="col-4 text-center">
                  <small class="text-grey-9">{{ $t('siabsen_terlambat') }}</small><br />
                  <q-badge color="negative" :label="badgeLabel(item.late)" />
                </div>
                <q-separator vertical />
                <div class="col-4 text-center">
                  <small class="text-grey-9">{{ $t('siabsen_worktime') }}</small><br />
                  <q-badge color="blue" :label="badgeLabel(item.workTime)" />
                </div>
                <q-separator vertical />
                <div class="col-3 text-center q-ml-sm">
                  <small class="text-grey-9">{{ $t('siabsen_overtime') }}</small><br />
                  <q-badge color="green" :label="badgeLabel(item.overtime)" />
                </div>
              </div>
            </q-card-section>
            <q-card-actions align="center" style="margin-top: -20px">
              <q-btn class="stafflist-btn" :disable="disableBtn(item.in, item.out)" :label="$t('siabsen_detail_absensi')" 
                @click="showImage(item.inPhoto, item.outPhoto)" color="accent" />
            </q-card-actions>
          </q-card>
        </q-expansion-item>
    </q-list>
    <!-- <q-scroll-area class="no-paging-scroll-area">
    </q-scroll-area> -->
  </div>
</template>
<style>
  .stafflist-btn {
    width: 100%;
    border-radius: 30px;
    padding-top: 5px !important;
    padding-bottom: 5px !important;
  }
</style>

<script>
import { useStore } from 'vuex'
import { checkColWidth } from 'src/composables/screen'
import { ref, computed } from 'vue'
import { t } from 'src/composables/common'

export default {
  setup () {
    const store = useStore()

    return {
      badgeLabel(text) {
        return text !== '-' ? text : `0 ${t('siabsen_menit')}`
      },
      expanded: ref(true),
      disableBtn(inPhoto, outPhoto) {
        return inPhoto === '-' && outPhoto === '-' ? true : false
      },
      showImage(inPhoto, outPhoto) {
        store.state.siabsen.inPhotoURL = inPhoto
        store.state.siabsen.outPhotoURL = outPhoto
        store.state.siabsen.showPresenceDetail = true
      },
      data: computed(() => store.state.siabsen.paging.data),
      checkColWidth,
    }
  }
}
</script>