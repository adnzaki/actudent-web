import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const useClassStore = defineStore('class', {
  state,
  getters: {},
  actions,
})