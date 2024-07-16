import { defineStore } from 'pinia'
import {
  t,
  admin,
  axios,
  parent,
  timeout,
  bearerToken,
  createFormData,
  conf,
} from '../composables/common'

import { usePagingStore as paging } from 'ss-paging-vue'

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
    homework: [],
    showSpinner: false,
    selectedPeriod: {
      month: '1',
      year: 2024,
    },
    monthlyPresence: [],
    showMonthlyPresence: true,
  }),
  actions: {
    getMonthlyPresence() {
      parent
        .get(
          `get-presence-detail/${this.selectedPeriod.month}/${this.selectedPeriod.year}`,
          {
            headers: { Authorization: bearerToken },
          },
        )
        .then(({ data }) => {
          this.monthlyPresence = data
        })
    },
    getRecentPost() {
      // try to reset first
      const limit = 3
      paging().state.rows = limit

      paging().getData({
        token: bearerToken,
        lang: localStorage.getItem(conf.userLang),
        limit,
        offset: 0,
        orderBy: 'date',
        searchBy: ['timeline_title', 'timeline_content', 'tb_timeline.created'],
        sort: 'DESC',
        search: '',
        url: `${conf.adminAPI}post/get/public/0/`,
        autoReset: {
          active: true,
          timeout: 500,
        },
      })
    },
    getHomework() {
      parent
        .get('get-homework-info', {
          headers: { Authorization: bearerToken },
        })
        .then(({ data }) => {
          this.homework = data
        })
    },
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
