<template>
  <q-dialog v-model="$store.state.agenda.showForm"
    @before-show="formOpen"
    @hide="$store.state.agenda.isEditForm = false">
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ cardTitle }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>
      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">     
          <q-input outlined :label="$t('agenda_label_nama') + ' (' + $t('agenda_input_nama') + ')'" dense v-model="formData.agenda_name" />
          <error :label="error.agenda_name" />  

          <!-- Agenda start date -->
          <q-input outlined dense v-model="dateStartStr" readonly>
            <template v-slot:prepend>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                  <q-date @update:model-value="pickerStartChanged" v-model="dateStartRaw" mask="YYYY-MM-DD HH:mm">
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-date>
                </q-popup-proxy>
              </q-icon>
            </template>

            <template v-slot:append>
              <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                  <q-time @update:model-value="pickerStartChanged" v-model="dateStartRaw" mask="YYYY-MM-DD HH:mm" format24h>
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-time>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
          <error :label="error.agenda_start" />
          <!-- ####### Agenda start date close -->

          <!-- Agenda end date -->
          <q-input outlined dense v-model="dateEndStr" readonly>
            <template v-slot:prepend>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                  <q-date @update:model-value="pickerEndChanged" v-model="dateEndRaw" mask="YYYY-MM-DD HH:mm">
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-date>
                </q-popup-proxy>
              </q-icon>
            </template>

            <template v-slot:append>
              <q-icon name="access_time" class="cursor-pointer">
                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                  <q-time @update:model-value="pickerEndChanged" v-model="dateEndRaw" mask="YYYY-MM-DD HH:mm" format24h>
                    <div class="row items-center justify-end">
                      <q-btn v-close-popup label="Close" color="primary" flat />
                    </div>
                  </q-time>
                </q-popup-proxy>
              </q-icon>
            </template>
          </q-input>
          <error :label="error.agenda_end" />
          <!-- ####### Agenda end date close -->

          <q-input autogrow outlined :label="$t('agenda_label_desc')" dense v-model="formData.agenda_description" />
          <error :label="error.agenda_description" />


          <p>{{ $t('agenda_label_prior') }}:</p>
          <div class="row" style="margin-top: -25px; margin-left: -10px;">
            <div class="col-4">
              <q-radio size="lg" v-model="formData.agenda_priority" checked-icon="task_alt" unchecked-icon="panorama_fish_eye" val="high" :label="$t('agenda_input_highprior')" />
            </div>
            <div class="col-4">
              <q-radio size="lg" v-model="formData.agenda_priority" checked-icon="task_alt" unchecked-icon="panorama_fish_eye" val="normal" :label="$t('agenda_input_normalprior')" />
            </div>
            <div class="col-4">
              <q-radio size="lg" v-model="formData.agenda_priority" checked-icon="task_alt" unchecked-icon="panorama_fish_eye" val="low" :label="$t('agenda_input_lowprior')" />
            </div>
          </div>

          <q-input outlined :label="$t('agenda_input_loc')" dense v-model="formData.agenda_location" />
          <error :label="error.agenda_location" />

          <!-- <q-input outlined readonly :label="guestLabel" 
            dense v-model="formData.agenda_guest"
            input-class="cursor-pointer"
            @click="showGuestDialog">
            <template v-slot:prepend>
              <q-badge v-for="(item, index) in guestWrapper" :key="index" color="blue" :label="item.label" />
            </template>
          </q-input>
          <error :label="error.agenda_guest" /> -->

          <q-file
            color="grey-3" outlined dense 
            v-model="attachment" 
            :label="$t('agenda_label_att')"
            @update:model-value="uploadFile"
            accept="application/pdf">
            <template v-slot:prepend>
              <q-icon name="cloud_upload" />
            </template>
          </q-file>
          <error v-if="attachmentError !== ''" :label="attachmentError" />
          <p v-if="isEditForm 
            && formData.agenda_attachment !== null 
            && formData.agenda_attachment !== ''
            && formData.agenda_attachment !== 'null'">
            {{ $t('agenda_label_att_name') }}
            <a :href="attachmentUrl" target="_blank">
              <q-badge color="blue" class="cursor-pointer" :label="formData.agenda_attachment" />
            </a>
          </p>

        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn outline :label="$t('hapus')" @click="$store.state.agenda.deleteConfirm = true" color="negative" />
        <q-btn outline :label="$t('tutup')" color="deep-purple" v-close-popup />
        <q-btn :label="$t('simpan')" @click="save" :disable="disableSaveButton" color="primary" padding="8px 20px" />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { cardDialog } from '../../composables/screen'
import { ref, computed } from 'vue'
import { useStore } from 'vuex'
import { date, useQuasar } from 'quasar'
import { selectedLang } from '../../composables/date'
import { t, axios, bearerToken, conf } from 'src/composables/common'

export default {
  name: 'AgendaForm',
  setup() {
    const store = useStore()
    const $q = useQuasar()
    const defaultDateValue = date.formatDate(new Date(), 'YYYY-MM-DD HH:mm')
    const dateStartRaw = ref(defaultDateValue)
    const dateEndRaw = ref(date.formatDate(date.addToDate(defaultDateValue, { hours: 1 }), 'YYYY-MM-DD HH:mm'))
    const isEditForm = computed(() => store.state.agenda.isEditForm)

    let formValue = {
      agenda_name: '',
      agenda_start: '',
      agenda_end: '',
      agenda_description: '',
      agenda_priority: 'normal',
      agenda_location: '',
      agenda_guest: '',
      agenda_attachment: '',
    }
    
    const guestWrapper = ref([])

    const strFormat = 'dddd, DD MMMM YYYY | HH:mm'
    const formData = ref(formValue)
    const formatDate = val => date.formatDate(val, strFormat, selectedLang)
    const dateStartStr = ref(formatDate(new Date))
    const dateEndStr =  ref(formatDate(date.addToDate(defaultDateValue, { hours: 1 })))

    const pickerStartChanged = val => {
      dateStartStr.value = formatDate(new Date(val))
    }

    const pickerEndChanged = val => {
      dateEndStr.value = formatDate(new Date(val))
    }

    const attachment = ref('')
    const attachmentUrl = ref('')
    const formOpen = () => {
      const details = computed(() => store.state.agenda.detail).value
      if(isEditForm.value) {        
        formData.value = {
          agenda_name: details.agenda_name,
          agenda_description: details.agenda_description,
          agenda_priority: details.agenda_priority,
          agenda_location: details.agenda_location,
          agenda_attachment: details.agenda_attachment,
        }

        dateStartRaw.value = details.agenda_start
        dateEndRaw.value = details.agenda_end

        dateStartStr.value = formatDate(details.agenda_start)
        dateEndStr.value = formatDate(details.agenda_end)
        attachmentUrl.value = store.getters['agenda/agendaApi'] +
                              'display-attachment/' +
                              details.agenda_id + '/' +
                              $q.cookies.get(conf.cookieName)

      } else {
        const saveStatus = computed(() => store.state.agenda.saveStatus)
        if(saveStatus.value === 200 || !isEditForm.value) {
          formData.value = {
            agenda_name: '',
            agenda_description: '',
            agenda_priority: 'normal',
            agenda_location: '',
            agenda_attachment: '',
          }
  
          attachment.value = ''
          dateStartStr.value = formatDate(new Date)
          dateEndStr.value =  formatDate(date.addToDate(defaultDateValue, { hours: 1 }))
  
          store.state.agenda.saveStatus = 500
        }
      }
    }

    const save = () => {
      const phpTimestamp = val => Date.parse(val).toString().substring(0, 10)
      formData.value.agenda_start = phpTimestamp(dateStartRaw.value)
      formData.value.agenda_end = phpTimestamp(dateEndRaw.value)

      if(isEditForm.value) {
        store.dispatch('agenda/save', {
          data: formData.value,
          edit: true,
          id: store.state.agenda.detail.agenda_id
        })
      } else {
        store.dispatch('agenda/save', {
          data: formData.value,
          edit: false,
          id: null
        })
      }
    }

    const attachmentError = ref('')

    const uploadFile = val => {
      store.state.agenda.helper.disableSaveButton = true
      const uploadData = new FormData()
      uploadData.append('attachment', val)
      axios.post(`${store.getters['agenda/agendaApi']}upload`, uploadData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          Authorization: bearerToken
        }
      })
        .then(({ data }) => {
          if(data.msg === 'OK') {
            attachmentError.value = ''
            store.state.agenda.helper.disableSaveButton = false
            formData.value.agenda_attachment = data.filename
          } else {
            attachmentError.value = data
            store.state.agenda.helper.disableSaveButton = true
          }

          console.log(formData.value)
        })
        .catch(error => console.error(error))
    }

    const showGuestDialog = () => {

    }

    return {
      cardTitle: computed(() => isEditForm.value ? t('agenda_edit_title') : t('agenda_form_title')),
      isEditForm,
      attachmentUrl,
      showGuestDialog,
      error: computed(() => store.state.agenda.error),
      disableSaveButton: computed(() => store.state.agenda.helper.error),
      formData,
      cardDialog,
      pickerStartChanged,
      pickerEndChanged,
      dateStartStr: computed(() => `${t('agenda_label_start')}: ${dateStartStr.value}`), 
      dateEndStr: computed(() => `${t('agenda_label_end')}: ${dateEndStr.value}`),
      dateStartRaw, dateEndRaw,
      save, uploadFile,
      attachment, attachmentError,
      formOpen,
      guestWrapper,
      guestLabel: computed(() => guestWrapper.value.length > 0 ? '' : t('agenda_label_guest'))
    }
  }
}
</script>
