import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const useScheduleStore = defineStore('schedule', {
  state,
  getters: {},
  actions,
})