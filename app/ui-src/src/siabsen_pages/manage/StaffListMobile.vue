<template>
  <div style="margin-top: -15px">
    <q-list class="q-px-md q-mt-sm">
      <q-expansion-item
        id="list"
        :class="[shadow, 'overflow-hidden q-mb-md']"
        style="border-radius: 15px"
        expand-separator
        expand-icon-toggle
        icon="perm_identity"
        :label="$trim(item.name, 30)"
        :caption="item.nip"
        :header-class="[headerMobileList, 'text-white']"
        expand-icon-class="text-white"
        default-opened
        v-for="(item, index) in data"
        :key="index"
      >
        <q-card :class="cardColor">
          <q-card-section class="q-px-none q-pt-sm">
            <div class="row q-mb-sm">
              <div class="col-6 text-center">
                <p :class="textColor" style="font-size: 12px">
                  {{ $t('siabsen_in') }}
                </p>
                <q-chip
                  style="margin-top: -10px"
                  size="md"
                  color="blue"
                  text-color="white"
                >
                  <strong v-if="item.in !== '-'">{{ item.in }}</strong>
                  <strong v-else>--:--:--</strong>
                </q-chip>
              </div>
              <div class="col-6 text-center">
                <p :class="textColor" style="font-size: 12px">
                  {{ $t('siabsen_out') }}
                </p>
                <q-chip
                  style="margin-top: -10px"
                  size="md"
                  color="blue"
                  text-color="white"
                >
                  <strong v-if="item.out !== '-'">{{ item.out }}</strong>
                  <strong v-else>--:--:--</strong>
                </q-chip>
              </div>
            </div>
            <div class="row q-mb-md">
              <div class="col-4 text-center">
                <small class="text-grey-9">{{ $t('siabsen_terlambat') }}</small
                ><br />
                <q-badge color="negative" :label="badgeLabel(item.late)" />
              </div>
              <q-separator vertical />
              <div class="col-4 text-center">
                <small class="text-grey-9">{{ $t('siabsen_worktime') }}</small
                ><br />
                <q-badge color="blue" :label="badgeLabel(item.workTime)" />
              </div>
              <q-separator vertical />
              <div class="col-3 text-center q-ml-sm">
                <small class="text-grey-9">{{ $t('siabsen_overtime') }}</small
                ><br />
                <q-badge color="green" :label="badgeLabel(item.overtime)" />
              </div>
            </div>
          </q-card-section>
          <q-card-actions align="center" style="margin-top: -20px">
            <q-btn
              :class="['stafflist-btn', addButton]"
              :disable="disableBtn(item.in, item.out)"
              :label="$t('siabsen_detail_absensi')"
              @click="showImage(item.inPhoto, item.outPhoto)"
            />
          </q-card-actions>
        </q-card>
      </q-expansion-item>
    </q-list>
    <!-- <q-scroll-area class="no-paging-scroll-area">
    </q-scroll-area> -->
  </div>
</template>

<script setup>
import { checkColWidth } from 'src/composables/screen'
import { ref, computed } from 'vue'
import { t, addButton } from 'src/composables/common'
import { useSiabsenStore } from 'src/stores/siabsen'
import { usePagingStore } from 'ss-paging-vue'
import {
  headerMobileList,
  cardColor,
  shadow,
  textColor,
} from '../siabsen-common'
import { useQuasar } from 'quasar'

const store = useSiabsenStore()
const paging = usePagingStore()
const $q = useQuasar()

const badgeLabel = (text) => {
  return text !== '-' ? text : `0 ${t('siabsen_menit')}`
}
const expanded = ref(true)

const disableBtn = (inPhoto, outPhoto) => {
  return inPhoto === '-' && outPhoto === '-' ? true : false
}

const showImage = (inPhoto, outPhoto) => {
  store.inPhotoURL = inPhoto
  store.outPhotoURL = outPhoto
  store.showPresenceDetail = true
}

const data = computed(() => paging.state.data)
</script>
