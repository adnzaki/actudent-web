import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const useLessonStore = defineStore('lesson', {
  state,
  getters: {},
  actions,
})