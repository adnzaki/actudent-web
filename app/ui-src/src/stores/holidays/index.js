import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const useHolidaysStore = defineStore('holidays', {
  state,
  getters: {},
  actions,
})
