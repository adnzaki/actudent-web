import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const useParentStore = defineStore('parent', {
  state,
  getters: {},
  actions,
})