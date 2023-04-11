import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const useEmployeeStore = defineStore('employee', {
  state,
  getters: {},
  actions,
})