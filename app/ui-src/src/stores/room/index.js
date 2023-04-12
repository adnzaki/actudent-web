import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const useRoomStore = defineStore('room', {
  state,
  getters: {},
  actions,
})