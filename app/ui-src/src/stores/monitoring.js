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
      message: 'Loading status...',
      status: 4,
      presence: {
        monthlyPercentage: '%',
        periodPercentage: '%',
      },
    },
    todaySchedule: [],
  }),
  actions: {
    getTodaySchedule() {
      parent
        .get('get-today-schedule', {
          headers: { Authorization: bearerToken },
        })
        .then(({ data }) => {
          this.todaySchedule = data
        })
    },
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
