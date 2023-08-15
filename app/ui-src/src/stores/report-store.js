import { defineStore } from "pinia";
import { admin, conf, install, createFormData, bearerToken, t } from 'src/composables/common'
import { Notify, Loading } from "quasar";

export const useReportStore = defineStore('report-setting', {
  state() {
    return {
      signOptions: [],
      daily_journal_sign: null,
      daily_presence_sign: null,
      monthly_presence_sign: null,
      monthly_summary_sign: null,
      semester_summary_sign: null,
      disableButton: false,
    }
  },
  actions: {
    save(value, type) {
      const notify = Notify.create({
        message: t('saving_report_progress'),
        color: 'info',
        spinner: true,
        timeout: 0,
        group: false,
        position: 'center'
      })

      admin.post(`pengaturan-laporan/set-sign/${value}/${type}`, {}, {
        headers: { Authorization: bearerToken }
      }).then(({ data }) => {
        if (data.status === 'OK') {
          notify({
            message: t('saving_report_success'),
            color: 'positive',
            spinner: false,
            icon: 'done',
            timeout: 3500
          })
        } else {
          notify({
            message: t('saving_report_failed'),
            color: 'negative',
            spinner: false,
            timeout: 3500
          })
        }
      })
    },
    getSignSetting(type) {
      admin
        .get(`pengaturan-laporan/get-signs/${type}`, {
          headers: { Authorization: bearerToken },
        })
        .then(({ data }) => this[type] = data)
    }
  }
})