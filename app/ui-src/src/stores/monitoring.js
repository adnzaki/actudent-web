import { defineStore } from 'pinia'
import {
  t,
  admin,
  axios,
  parent,
  timeout,
  bearerToken,
  createFormData,
} from '../composables/common'

import { date } from 'quasar'
import { Notify } from 'quasar'

export const useMonitoringStore = defineStore('monitoring', {
  state: () => ({
    baseUrl: 'parent/',
    presenceInfo: {
      message: 'Loading info...',
      status: 4,
      presence: {
        monthlyPercentage: '',
        periodPercentage: '',
      },
    },
    // presenceInfo: {},
  }),
  actions: {
    getPresenceInfo() {
      parent
        .get('get-presence-info', {
          headers: { Authorization: bearerToken },
        })
        .then(({ data }) => {
          this.presenceInfo = data
        })
    },
  },
})
