<template>
  <q-dialog
    no-backdrop-dismiss
    v-model="store.showPermitForm"
    @before-show="formOpen"
    @hide="formClose(null)"
    :maximized="maximizedDialog()"
  >
    <q-card class="q-pa-sm" :style="cardDialog()">
      <q-card-section class="row items-center q-pb-none">
        <div class="text-h6 text-capitalize">
          {{ $t('siabsen_form_izin_title') }}
        </div>
        <q-space />
        <q-btn icon="close" flat round dense v-close-popup />
      </q-card-section>

      <q-card-section class="scroll card-section">
        <q-form class="q-gutter-xs">
          <q-input outlined dense v-model="permitDateStr" readonly>
            <template v-slot:append>
              <q-icon name="event" class="cursor-pointer">
                <q-popup-proxy
                  cover
                  transition-show="scale"
                  transition-hide="scale"
                >
                  <q-date
                    @update:model-value="dateChanged"
                    v-model="formData.permit_date"
                    mask="YYYY-MM-DD"
                    :options="dateOptions"
                  >
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
              <q-input
                outlined
                dense
                v-model="formData.permit_starttime"
                readonly
              >
                <template v-slot:append>
                  <q-icon name="access_time" class="cursor-pointer">
                    <q-popup-proxy
                      cover
                      transition-show="scale"
                      transition-hide="scale"
                    >
                      <q-time
                        v-model="formData.permit_starttime"
                        mask="HH:mm"
                        format24h
                        :minute-options="[0, 15, 30, 45]"
                      >
                        <div class="row items-center justify-end">
                          <q-btn
                            v-close-popup
                            label="Close"
                            color="primary"
                            flat
                          />
                        </div>
                      </q-time>
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
            <div class="col-12 col-sm-6 q-pr-xs q-my-md">
              <q-input
                outlined
                dense
                v-model="formData.permit_endtime"
                readonly
              >
                <template v-slot:append>
                  <q-icon name="access_time" class="cursor-pointer">
                    <q-popup-proxy
                      cover
                      transition-show="scale"
                      transition-hide="scale"
                    >
                      <q-time
                        v-model="formData.permit_endtime"
                        mask="HH:mm"
                        format24h
                        :minute-options="[0, 15, 30, 45]"
                      >
                        <div class="row items-center justify-end">
                          <q-btn
                            v-close-popup
                            label="Close"
                            color="primary"
                            flat
                          />
                        </div>
                      </q-time>
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
            </div>
          </div>

          <q-select
            class="q-mb-lg"
            outlined
            :label="$t('siabsen_permit_type')"
            v-model="permitType"
            :options="permitTypeOptions"
            dense
          />

          <q-select
            class="q-mb-lg"
            outlined
            :label="$t('siabsen_permit_for')"
            v-model="permitNeeds"
            :options="permitNeedsOptions"
            dense
          />

          <q-input
            outlined
            :label="$t('siabsen_alasan_izin')"
            dense
            v-model="formData.permit_reason"
            :rules="[
              (val) => (val && val.length > 0) || $t('permit_reason_required'),
            ]"
          />
          <ac-error
            :label="error.permit_reason"
            v-if="error.permit_reason !== undefined"
          />

          <q-file
            color="grey-3"
            outlined
            dense
            v-model="attachment"
            :label="$t('siabsen_lampiran_izin')"
            @update:model-value="uploadFile"
            accept="image/*"
          >
            <template v-slot:prepend>
              <q-icon name="cloud_upload" />
            </template>
          </q-file>
          <ac-error v-if="attachmentError !== ''" :label="attachmentError" />
          <q-btn
            v-if="
              store.formType === 'edit' &&
              store.permitDetail.permit_photo !== ''
            "
            target="_blank"
            style="width: 100%"
            :class="['q-mt-md', addButton]"
            :label="$t('feedback_label_att')"
            :href="store.permitDetail.permit_photo"
          />
        </q-form>
      </q-card-section>
      <q-separator />
      <q-card-actions align="right">
        <q-btn
          flat
          :label="$t('tutup')"
          v-if="!$q.screen.lt.sm"
          class="close-btn"
          v-close-popup
        />
        <q-btn
          class="mobile-form-btn save-btn"
          :label="$t('simpan')"
          @click="save"
          padding="8px 20px"
        />
      </q-card-actions>
    </q-card>
  </q-dialog>
</template>

<script>
import { computed, ref, watch, onMounted } from 'vue'
import { useSiabsenStore } from 'src/stores/siabsen'
import { date, useQuasar } from 'quasar'
import { maximizedDialog, cardDialog } from 'src/composables/screen'
import { selectedLang } from 'src/composables/date'
import {
  siabsen,
  bearerToken,
  createFormData,
  t,
  addButton,
  conf,
} from 'src/composables/common'
import { lang } from 'src/i18n/fetch-lang'

export default {
  setup() {
    const store = useSiabsenStore()
    const $q = useQuasar()

    const permitType = ref(null)
    const permitNeeds = ref(null)
    const permitTypeOptions = ref([])
    const permitNeedsOptions = ref([])

    let defaultFormValues = {
      permit_date: date.formatDate(new Date(), 'YYYY-MM-DD'),
      permit_starttime: '08:00',
      permit_endtime: '12:00',
      permit_reason: '',
      permit_photo: '',
      permit_presence: null,
      permit_type: null,
    }

    const formData = ref(defaultFormValues)

    const strFormat = $q.screen.gt.sm
      ? 'dddd, DD MMMM YYYY'
      : 'ddd, DD-MMM-YYYY'

    const formatDate = (val) => date.formatDate(val, strFormat, selectedLang)
    const permitDateStr = ref(formatDate(new Date()))

    const dateChanged = (val) => {
      permitDateStr.value = formatDate(new Date(val))
    }

    const attachment = ref([])
    const attachmentError = ref('')

    const dateOptions = (val) => {
      return val >= date.formatDate(new Date(), 'YYYY/MM/DD')
    }

    const saveStatus = computed(() => store.saveStatus)
    const save = () => {
      if (
        permitType.value === null ||
        permitNeeds.value === null ||
        formData.value.permit_reason === ''
      ) {
        $q.notify({
          color: 'negative',
          message: t('siabsen_permit_error'),
          icon: 'warning',
          position: 'center',
        })
      } else {
        formData.value.permit_type = permitType.value.value
        formData.value.permit_presence = permitNeeds.value.value

        const id =
          store.formType === 'edit' ? store.permitDetail.permit_id : null
        store.sendPermitRequest(formData.value, id, () => {
          formData.value = defaultFormValues
          attachment.value = []

          // return the form type into add mode
          store.formType = 'add'
        })
      }
    }

    const uploadFile = (val) => {
      // ensure that if the user uploads a file,
      // remove any existing image, whether it is in
      // server or client.
      formClose(() => {
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

        siabsen
          .post('unggah-lampiran', uploadData, {
            headers: {
              'Content-Type': 'multipart/form-data',
              Authorization: bearerToken,
            },
          })
          .then(({ data }) => {
            if (data.msg === 'OK') {
              attachmentError.value = ''
              formData.value.permit_photo = data.img
            } else {
              attachmentError.value = data.attachment
            }

            notifyProgress({
              timeout: 1,
            })
          })
          .catch((error) => console.error(error))
      })
    }

    const formOpen = () => {
      attachment.value = []
      permitTypeOptions.value = [
        { label: t('siabsen_permit_sick'), value: 'sick' },
        { label: t('siabsen_permit_outstation'), value: 'outstation' },
        { label: t('siabsen_permit_others'), value: 'others' },
      ]

      permitNeedsOptions.value = [
        { label: t('siabsen_izin_full'), value: 'none' },
        { label: t('siabsen_izin_masuk'), value: 'masuk' },
        { label: t('siabsen_izin_pulang'), value: 'pulang' },
      ]

      if (store.formType === 'edit') {
        formData.value = {
          permit_date: store.permitDetail.permit_date,
          permit_starttime: store.permitDetail.permit_starttime,
          permit_endtime: store.permitDetail.permit_endtime,
          permit_reason: store.permitDetail.permit_reason,
          permit_photo: store.permitDetail.permit_photo,
        }

        permitDateStr.value = store.permitDetail.permit_date_str
        permitType.value = permitTypeOptions.value.find(
          (item) => item.value === store.permitDetail.permit_type,
        )
        permitNeeds.value = permitNeedsOptions.value.find(
          (item) => item.value === store.permitDetail.permit_presence,
        )
      } else {
        formData.value = defaultFormValues

        permitType.value = null
        permitNeeds.value = null
      }
    }

    const formClose = (next) => {
      if (typeof attachment.value === 'object') {
        siabsen
          .post(
            'hapus-lampiran',
            { url: formData.value.permit_photo },
            {
              headers: { Authorization: bearerToken },
              transformRequest: [
                (data) => {
                  return createFormData(data)
                },
              ],
            },
          )
          .then(() => {
            if (next === null) {
              attachment.value = []
              formData.value.permit_photo = ''
            } else {
              next()
            }
          })
      }
    }

    return {
      store,
      addButton,
      permitType,
      permitNeeds,
      save,
      uploadFile,
      dateOptions,
      formData,
      formClose,
      formOpen,
      permitDateStr,
      error: computed(() => store.permitError),
      attachment,
      attachmentError,
      dateChanged,
      permitTypeOptions,
      permitNeedsOptions,
      disableSaveButton: computed(() => store.helper.disableSaveButton),
      cardDialog,
      maximizedDialog,
    }
  },
}
</script>
