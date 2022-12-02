import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const useStudentStore = defineStore('student', {
  state,
  getters: {},
  actions,
})