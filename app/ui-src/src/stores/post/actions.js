import {
  Cookies,
  conf,
  bearerToken,
  admin,
  timeout,
  errorNotif,
  createFormData,
  pengguna,
  t,
  flashAlert
} from '../../composables/common'

import { Notify } from 'quasar'
import { usePagingStore as paging } from 'ss-paging-vue'

export default {
  deletePost() {
    // show notify
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('timeline_delete_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    const data = { id: JSON.stringify(this.selectedPosts) }
    admin.post(`${this.postApi}delete`, data, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(() => {
        this.helper.disableSaveButton = false
        this.deleteConfirm = false
        notifyProgress({
          message: t('timeline_delete_success'),
          color: 'positive',
          icon: 'done',
          spinner: false,
          timeout
        })

        // refresh data
        this.resetForm()
      })
  },
  removeFeaturedImage() {
    admin.get(`${this.postApi}remove-image/${this.forms.featured_image}`, {
      headers: { Authorization: bearerToken },
    }).then(({ data }) => {
      this.forms.featured_image = null
    })
  },
  removeGalleryImage({ filename, index, limit }) {
    admin.get(`${this.postApi}remove-image/${filename}`, {
      headers: { Authorization: bearerToken },
    }).then(({ data }) => {
      this.forms.gallery.splice(index, 1)
      if (this.galleryCount < limit) {
        this.disableGalleryUploader = false
      }
    })
  },
  deleteImage(url, id, type) {
    admin.get(`${this.postApi}${url}/${id}`, {
      headers: { Authorization: bearerToken },
    }).then(({ data }) => {
      if (type === 'post') {
        this.forms.featured_image = null
      } else {
        const index = this.galleryList.findIndex(item => item.id === id)
        this.galleryList.splice(index, 1)
      }
    })
  },
  save() {
    let url
    this.isEditForm ? url = `save/${this.postId}` : url = 'save'
    this.helper.disableSaveButton = true
    const notifyProgress = Notify.create({
      group: false,
      spinner: true,
      message: t('timeline_save_progress'),
      color: 'info',
      position: 'center',
      timeout: 0,
    })

    this.forms.imageGallery = JSON.stringify(this.forms.gallery)

    admin.post(`${this.postApi}${url}`, this.forms, {
      headers: { Authorization: bearerToken },
      transformRequest: [data => {
        return createFormData(data)
      }]
    })
      .then(response => {
        notifyProgress({ timeout })
        this.helper.disableSaveButton = false
        const res = response.data
        if (res.code === '500') {
          this.error = res.msg
          notifyProgress({
            message: `Error! ${t('timeline_error_save')}`,
            color: 'negative',
            spinner: false
          })
        } else {
          this.saveStatus = 200

          this.resetForm()
          if (this.isEditForm) {
            this.isEditForm = false
            notifyProgress({
              message: `${t('sukses')} ${t('timeline_save_update')}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          } else {
            const insertMessage = this.forms.timeline_status === 'public' ? t('timeline_save_public') : t('timeline_save_draft')
            notifyProgress({
              message: `${t('sukses')} ${insertMessage}`,
              color: 'positive',
              icon: 'done',
              spinner: false
            })
          }

          this.showForm = false
          this.galleryList = []
          this.forms.gallery = []
        }
      })
  },
  resetForm() {
    this.error = {}
    this.current = 1
    paging().reloadData()
  },
  getPosts() {
    const limit = 25
    paging().state.rows = limit

    paging().getData({
      token: bearerToken,
      lang: localStorage.getItem(conf.userLang),
      limit,
      offset: this.current - 1,
      orderBy: 'date',
      searchBy: ['timeline_title', 'timeline_content'],
      sort: 'DESC',
      search: '',
      url: `${conf.adminAPI}post/get/${this.postType}/${this.mypost}/`,
      autoReset: {
        active: true,
        timeout: 500
      },
    })
  },
  getDetail(id) {
    this.error = {}
    admin.get(`${this.postApi}get-detail/${id}`, {
      headers: { Authorization: bearerToken }
    })
      .then(({ data }) => {
        const { post, gallery } = data
        this.forms.timeline_title = post.timeline_title
        this.forms.timeline_content = post.timeline_content
        this.forms.timeline_status = post.timeline_status
        this.forms.featured_image = post.featured_image
        this.galleryList = gallery
        this.forms.gallery = []
        this.postId = id
        this.isEditForm = true
        this.showForm = true
      })
  },
  closeDeleteConfirm() {
    this.selectedRooms = []
    this.deleteConfirm = false
    this.checkAll = false
  },
  showDeleteConfirm(id) {
    this.selectedPosts = []
    this.selectedPosts.push(id)
    this.deleteConfirm = true
  },
  selectAll() {
    if (this.checkAll) {
      this.paging().data.forEach(item => {
        this.selectedRooms.push(item.room_id)
      })
    } else {
      this.selectedRooms = []
    }
  },
  multipleDeleteConfirm() {
    if (this.selectedPosts.length > 0) {
      this.deleteConfirm = true
    } else {
      flashAlert(t('pilih_data_dulu'), 'negative')
    }
  },
}