<template>
  <q-dialog v-model="$store.state.agenda.showForm"
    @before-show="formOpen"
    @hide="formHide"
    :maximized="maximizedDialog()">
    <guest-selector />
    <q-card class="q-pa-sm" :style="cardDialog()" v-if="$store.state.agenda.mainForm">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">{{ cardTitle }}</div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>
      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">     
          <q-input :readonly="readonly" outlined :label="$t('agenda_label_nama') + ' (' + $t('agenda_input_nama') + ')'" dense v-model="formData.agenda_name" />
          <error :label="error.agenda_name" />  

          <!-- Agenda start date -->
          <q-input outlined dense v-model="dateStartStr" readonly>
            <template v-slot:prepend>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                  <q-date :disable="readonly" @update:model-value="pickerStartChanged" v-model="dateStartRaw" mask="YYYY-MM-DD HH:mm">
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
                  <q-time :disable="readonly" @update:model-value="pickerStartChanged" v-model="dateStartRaw" mask="YYYY-MM-DD HH:mm" format24h>
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
                  <q-date :disable="readonly" @update:model-value="pickerEndChanged" v-model="dateEndRaw" mask="YYYY-MM-DD HH:mm">
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
                  <q-time :disable="readonly" @update:model-value="pickerEndChanged" v-model="dateEndRaw" mask="YYYY-MM-DD HH:mm" format24h>
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

          <q-input :readonly="readonly" autogrow outlined :label="$t('agenda_label_desc')" dense v-model="formData.agenda_description" />
          <error :label="error.agenda_description" />

          <q-btn icon="turned_in" 
            style="width: 100%" color="accent" 
            :label="$t('agenda_add_guests')" v-if="userType === '1'"
            @click="showGuestSelector" />

          <p class="q-mt-md">{{ $t('agenda_label_prior') }}:</p>
          <div class="row" style="margin-top: -25px; margin-left: -10px;">
            <div class="col-12 col-md-4">
              <q-radio :disable="readonly" size="lg" v-model="formData.agenda_priority" checked-icon="task_alt" unchecked-icon="panorama_fish_eye" val="high" :label="$t('agenda_input_highprior')" />
            </div>
            <div class="col-12 col-md-4">
              <q-radio :disable="readonly" class="radio" size="lg" v-model="formData.agenda_priority" checked-icon="task_alt" unchecked-icon="panorama_fish_eye" val="normal" :label="$t('agenda_input_normalprior')" />
            </div>
            <div class="col-12 col-md-4">
              <q-radio :disable="readonly" class="radio" size="lg" v-model="formData.agenda_priority" checked-icon="task_alt" unchecked-icon="panorama_fish_eye" val="low" :label="$t('agenda_input_lowprior')" />
            </div>
          </div>

          <q-input :readonly="readonly" outlined :label="$t('agenda_input_loc')" dense v-model="formData.agenda_location" />
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

          <q-file :readonly="readonly"
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
        <!-- delete button for desktop -->
        <q-btn outline 
          v-if="$q.cookies.get(conf.userType) === '1' && isEditForm && !$q.screen.lt.sm" 
          :label="$t('hapus')" @click="$store.state.agenda.deleteConfirm = true" 
          color="negative" />
        <!-- #END -->

        <q-btn outline v-if="!$q.screen.lt.sm" :label="$t('tutup')" :color="closeBtnColor" v-close-popup />
        <q-btn v-if="$q.cookies.get(conf.userType) === '1'" class="mobile-form-btn" :label="$t('simpan')" @click="save" :disable="disableSaveButton" color="primary" padding="8px 20px" />

        <!-- delete button for mobile -->
        <q-btn outline 
          v-if="$q.cookies.get(conf.userType) === '1' && isEditForm && $q.screen.lt.sm" 
            class="mobile-form-btn" 
            style="margin-left: -10px;"
            :label="$t('hapus')" 
            @click="$store.state.agenda.deleteConfirm = true" 
            color="negative" />
        <!-- #END -->

      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<style lang="sass" scoped>
@media(max-width: $breakpoint-sm-max)
  .radio
    margin-top: -10px
  
</style>

<script>
import { maximizedDialog, cardDialog } from '../../composables/screen'
import { ref, computed, provide } from 'vue'
import { useStore } from 'vuex'
import { date, useQuasar } from 'quasar'
import { selectedLang } from '../../composables/date'
import { t, axios, bearerToken, conf, userType } from 'src/composables/common'
import GuestSelector from './GuestSelector.vue'

export default {
  name: 'AgendaForm',
  components: { GuestSelector },
  setup() {
    const store = useStore()
    const $q = useQuasar()
    const dateModelFormat = 'YYYY-MM-DD HH:mm'
    const defaultDateValue = date.formatDate(new Date(), dateModelFormat)
    const defaultDateEndValue = date.formatDate(date.addToDate(defaultDateValue, { hours: 1 }), dateModelFormat)
    const dateStartRaw = ref(defaultDateValue)
    const dateEndRaw = ref(defaultDateEndValue)
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

    const strFormat = $q.screen.gt.sm ? 'dddd, DD MMMM YYYY | HH:mm' : 'ddd, DD-MMM-YYYY | HH:mm'
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

    const attachment = ref([])
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
  
          attachment.value = []
          dateStartStr.value = formatDate(new Date)
          dateEndStr.value =  formatDate(date.addToDate(defaultDateValue, { hours: 1 }))
          dateStartRaw.value = defaultDateValue
          dateEndRaw.value = defaultDateEndValue
  
          store.state.agenda.saveStatus = 500
        }
      }
    }

    const save = () => {
      const phpTimestamp = val => Date.parse(val).toString().substring(0, 10)
      formData.value.agenda_start = phpTimestamp(dateStartRaw.value)
      formData.value.agenda_end = phpTimestamp(dateEndRaw.value)

      const agendaGuest = computed(() => store.state.agenda.guests)
      if(agendaGuest.value.length > 0) {
        formData.value.agenda_guest = JSON.stringify(agendaGuest.value)
      }

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

    const formHide = () => {
      if(store.state.agenda.isEditForm) {
        dateStartRaw.value = defaultDateValue
        dateEndRaw.value = defaultDateEndValue
      }

      store.state.agenda.isEditForm = false
    }

    const disableSaveButton = computed(() => store.state.agenda.helper.disableSaveButton)
    provide('shared', {
      disableSaveButton,
      store
    })

    return {
      showGuestSelector() {
        store.state.agenda.mainForm = false
      },
      userType,
      closeBtnColor: computed(() => $q.dark.isActive ? 'warning' : 'deep-purple'),
      formHide,
      readonly: computed(() => $q.cookies.get(conf.userType) === '1' ? false : true),
      conf,
      cardTitle: computed(() => isEditForm.value ? t('agenda_edit_title') : t('agenda_form_title')),
      isEditForm,
      attachmentUrl,
      error: computed(() => store.state.agenda.error),
      disableSaveButton,
      formData,
      cardDialog, maximizedDialog,
      pickerStartChanged,
      pickerEndChanged,
      dateStartStr: computed(() => {
        let prefix = ''
        if($q.screen.gt.sm) {
          prefix = `${t('agenda_label_start')}: `
        }

        return `${prefix}${dateStartStr.value}`
      }), 
      dateEndStr: computed(() => {
        let prefix = ''
        if($q.screen.gt.sm) {
          prefix = `${t('agenda_label_end')}: `
        }

        return `${prefix}${dateEndStr.value}`
      }),
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
