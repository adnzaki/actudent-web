import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const useSessionStore = defineStore('sessions', {
  state,
  getters: {},
  actions,
})
