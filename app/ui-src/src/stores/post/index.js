import { defineStore } from 'pinia'
import state from './state'
import actions from './actions'

export const usePostStore = defineStore('post', {
  state,
  getters: {
    galleryCount: state => {
      return state.forms.gallery.length + state.galleryList.length
    }
  },
  actions,
})