<template>
  <q-dialog v-model="$store.state.siabsen.showPermitDetail" 
    :maximized="maximizedDialog()">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('siabsen_permit_detail') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          
          <q-input outlined dense v-model="$store.state.siabsen.permitDetail.permit_date" readonly />
          <div class="row">
            <div class="col-12 col-sm-6 q-pr-xs q-mt-md q-mb-sm">
              <q-input outlined dense v-model="$store.state.siabsen.permitDetail.permit_starttime" readonly />
            </div>
            <div class="col-12 col-sm-6 q-pr-xs q-my-md">
              <q-input outlined dense v-model="$store.state.siabsen.permitDetail.permit_endtime" readonly />
            </div>
          </div>
  
          <q-input outlined :label="$t('siabsen_alasan_izin')" dense readonly v-model="$store.state.siabsen.permitDetail.permit_reason" />
          <q-btn target="_blank" style="width: 100%;" class="q-mt-md"
            color="accent" :label="$t('feedback_label_att')" 
            :href="$store.state.siabsen.permitDetail.permit_photo" />
        </q-form>
        
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" v-if="!$q.screen.lt.sm" color="negative" v-close-popup />
        <q-btn-dropdown class="mobile-form-btn" style="padding-left: 17px;" label="Status" v-if="$q.cookies.get(conf.userType) === '1'" color="primary">
          <q-list>
            <q-item clickable v-close-popup @click="setStatus('approved', $store.state.siabsen.permitDetail.permit_id)">
              <q-item-section>
                <q-item-label>{{ $t('siabsen_approve_permit') }}</q-item-label>
              </q-item-section>
            </q-item>
            <q-item clickable v-close-popup @click="setStatus('rejected', $store.state.siabsen.permitDetail.permit_id)">
              <q-item-section>
                <q-item-label>{{ $t('siabsen_reject_permit') }}</q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-btn-dropdown>
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { useStore } from 'vuex'
import { maximizedDialog, cardDialog } from 'src/composables/screen'
import { conf } from 'src/composables/common'

export default {
  setup() { 
    const store = useStore()
    
    return {
      maximizedDialog,
      setStatus: (val, id ) => {
        store.dispatch('siabsen/setPermitStatus', {
          status: val, 
          id
        })
      },
      conf,
      cardDialog
    }
  }
}
</script>