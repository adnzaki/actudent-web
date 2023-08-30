import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const usePostStore = defineStore('post', {
  state,
  getters: {},
  actions,
})