<template>
  <q-dialog no-backdrop-dismiss v-model="$store.state.siabsen.showPermitForm"
    @before-show="formOpen"
    @hide="formClose"
    :maximized="maximizedDialog()">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ $t('siabsen_form_izin_title') }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          
          <q-input outlined dense v-model="permitDateStr" readonly>
            <template v-slot:append>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                  <q-date @update:model-value="dateChanged" 
                    v-model="formData.permit_date" mask="YYYY-MM-DD"
                    :options="dateOptions">
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-date>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
          <div class="row">
            <div class="col-12 col-sm-6 q-pr-xs q-mt-md q-mb-sm">
              <q-input outlined dense v-model="formData.permit_starttime" readonly>
                <template v-slot:append>
                  <q-icon name="access_time" class="cursor-pointer">
                    <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                      <q-time v-model="formData.permit_starttime" mask="HH:mm" 
                        format24h 
                        :minute-options="[0, 15, 30, 45]">
                        <div class="row items-center justify-end">
                          <q-btn v-close-popup label="Close" color="primary" flat />
                        </div>
                      </q-time>
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
            <div class="col-12 col-sm-6 q-pr-xs q-my-md">
              <q-input outlined dense v-model="formData.permit_endtime" readonly>
                <template v-slot:append>
                  <q-icon name="access_time" class="cursor-pointer">
                    <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                      <q-time v-model="formData.permit_endtime" mask="HH:mm" 
                        format24h 
                        :minute-options="[0, 15, 30, 45]">
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

          <q-select class="q-mb-lg"
            outlined
            :label="$t('siabsen_permit_type')"
            v-model="permitType"
            :options="permitOptions"
            dense
          />
  
          <q-input outlined :label="$t('siabsen_alasan_izin')" dense v-model="formData.permit_reason" />
          <error :label="error.permit_reason" />  
          
          <q-file 
            color="grey-3" outlined dense 
            v-model="attachment" 
            :label="$t('siabsen_lampiran_izin')"
            @update:model-value="uploadFile"
            accept="image/*">
            <template v-slot:prepend>
              <q-icon name="cloud_upload" />
            </template>
          </q-file>
          <error v-if="attachmentError !== ''" :label="attachmentError" />
        </q-form>
        
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn flat :label="$t('tutup')" v-if="!$q.screen.lt.sm" color="negative" v-close-popup />
        <q-btn class="mobile-form-btn" :label="$t('simpan')" :disable="disableSaveButton" @click="save" color="primary" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed, ref, watch } from 'vue'
import { useStore } from 'vuex'
import { date, useQuasar } from 'quasar'
import { maximizedDialog, cardDialog } from 'src/composables/screen'
import { selectedLang } from 'src/composables/date'
import { siabsen, bearerToken, createFormData, t } from 'src/composables/common'

export default {
  setup() { 
    const store = useStore()
    const $q = useQuasar()

    const permitType = ref({})

    const permitOptions = ref([])

    setTimeout(() => {
      permitType.value = {
        label: t('siabsen_izin_full'), value: 'none'
      }

      permitOptions.value = [
        { label: t('siabsen_izin_full'), value: 'none' },
        { label: t('siabsen_izin_masuk'), value: 'masuk' },
        { label: t('siabsen_izin_pulang'), value: 'pulang' }
      ]
    }, 1500)

    let formValue = {
      permit_date: date.formatDate(new Date(), 'YYYY-MM-DD'),
      permit_starttime: '08:00',
      permit_endtime: '12:00',
      permit_reason: '',
      permit_photo: '',
    }

    const strFormat = $q.screen.gt.sm ? 'dddd, DD MMMM YYYY' : 'ddd, DD-MMM-YYYY'    

    const formatDate = val => date.formatDate(val, strFormat, selectedLang)
    const permitDateStr = ref(formatDate(new Date))

    const dateChanged = val => {
      permitDateStr.value = formatDate(new Date(val))
    }

    const attachment = ref([])
    const attachmentError = ref('')

    const dateOptions = val => {
      return val >= date.formatDate(new Date, 'YYYY/MM/DD')
    }

    const formData = ref(formValue)
    const saveStatus = computed(() => store.state.siabsen.saveStatus)
    const save = () => {
      formData.value.permit_presence = permitType.value.value
      store.dispatch('siabsen/sendPermitRequest', formData.value)
    }

    const uploadFile = val => {
      // clear any existing file before upload..
      formClose()

      const uploadData = new FormData()
      uploadData.append('attachment', val)
      const notifyProgress = $q.notify({
        group: false,
        spinner: true,
        message: t('siabsen_upload_progress'),
        color: 'info',
        position: 'center',
        timeout: 0,
      })
      
      siabsen.post('unggah-lampiran', uploadData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          Authorization: bearerToken
        }
      })
        .then(({ data }) => {
          if(data.msg === 'OK') {
            attachmentError.value = ''
            store.state.siabsen.disableSaveButton = false
            formData.value.permit_photo = data.img
          } else {
            attachmentError.value = data.attachment
            store.state.siabsen.disableSaveButton = true
          }
          
          notifyProgress({
            timeout: 1
          })

          console.log(formData.value)
        })
        .catch(error => console.error(error))
    }

    const formOpen = () => {
      attachment.value = []
      store.state.siabsen.disableSaveButton = true
      if(saveStatus.value === 200) {
        formValue = {
          permit_date: date.formatDate(new Date(), 'YYYY-MM-DD'),
          permit_starttime: '08:00',
          permit_endtime: '12:00',
          permit_presence: permitType.value.value,
          permit_reason: '',
          permit_photo: '',
        }

        formData.value = formValue
        store.state.siabsen.saveStatus = 500
      }
    }

    const formClose = () => {
      if(saveStatus.value === 500 && attachment.value !== []) {
        const data = { url: formData.value.permit_photo }
        siabsen.post('hapus-lampiran', data, {
          headers: { Authorization: bearerToken },
          transformRequest: [data => {
            return createFormData(data)
          }]
        })
          .then(() => {
            console.info('Form canceled, attachment removed if exists.')
          })
      }
    }    
    
    return {
      permitType, permitOptions,
      save,
      uploadFile,
      dateOptions,
      formData, formClose, formOpen,
      permitDateStr,
      error: computed(() => store.state.siabsen.permitError),
      attachment, attachmentError,
      dateChanged,
      disableSaveButton: computed(() => store.state.siabsen.disableSaveButton),
      cardDialog, maximizedDialog
    }
  }
}
</script>