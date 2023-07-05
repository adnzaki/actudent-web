import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const useSiabsenStore = defineStore('siabsen', {
  state,
  getters: {},
  actions,
})