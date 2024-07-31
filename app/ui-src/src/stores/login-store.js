import { defineStore } from 'pinia'
import {
  t,
  core,
  admin,
  axios,
  parent,
  timeout,
  bearerToken,
  createFormData,
  conf,
} from '../composables/common'

import { Notify, Cookies, Loading } from 'quasar'

export const useLoginStore = defineStore('login', {
  state: () => ({
    username: '',
    password: '',
    message: '',
    showMessage: false,
    messageClass: 'black',
    error: {},
    remember: true,
    requirePassword: 1,
  }),
  getters: {},
  actions: {
    updateDb() {
      core.get('check-db').then(({ data }) => {
        if (data.shouldUpdate === 1) {
          const loading = Loading.show({
            message: 'Memperbarui database ke versi terbaru...',
            group: 'check',
          })
          setTimeout(() => {
            core.get('update-db').then(({ data }) => {
              loading({ message: 'Database telah diperbarui ke versi terbaru' })
              setTimeout(() => {
                Loading.hide('check')
              }, 1000)
            })
          }, 1000)
        }
      })
    },
    validate() {
      this.message = ''
      this.showMessage = true
      const hideMsg = () => (this.showMessage = false)
      if (this.username === '' || this.password === '') {
        this.message = t('userpassword_wajib')
        this.messageClass = 'negative'
        setTimeout(hideMsg, 6000)
      } else {
        const postData = {
          username: this.username,
          password: this.password,
          requirePassword: this.requirePassword,
        }

        this.message = t('mengautentikasi')
        this.messageClass = Cookies.get('theme') === 'dark' ? 'white' : 'black'

        core
          .post('login/validasi', postData, {
            transformRequest: [(data) => createFormData(data)],
          })
          .then(({ data }) => {
            if (data.msg === 'expired' || data.msg === 'maximum_session') {
              this.messageClass = 'negative'
              this.message = data.note
            } else {
              if (data.msg === 'valid') {
                this.requirePassword = 1
                this.message = t('login_sukses')
                this.messageClass = 'positive'

                if (this.remember) {
                  conf.cookieExp *= 12 * 30 * 12 // 360 days
                }

                const dt = new Date(),
                  now = dt.getTime(),
                  expMs = now + conf.cookieExp,
                  exp = new Date(expMs),
                  cookieOptions = {
                    expires: exp.toUTCString(),
                    path: '/',
                    sameSite: 'None',
                    secure: true,
                  }

                Cookies.set(conf.cookieName, data.token, cookieOptions)
                Cookies.set(conf.userType, data.level, cookieOptions)

                // set copy_presence option
                if (localStorage.getItem('copy_presence') === null) {
                  localStorage.setItem('copy_presence', 0)
                }

                // always re-set the language after login successful
                localStorage.setItem(conf.userLang, data.lang)

                // redirect to dashboard depend on user type...
                if (data.level === '1') {
                  window.location.href = conf.homeUrl()
                  localStorage.removeItem('grade_id')
                } else if (data.level === '2' || data.level === '0') {
                  localStorage.setItem('grade_id', data.grade)
                  window.location.href = conf.teacherHomeUrl()
                } else if (data.level === '3') {
                  window.location.href = conf.parentHomeUrl()
                  localStorage.removeItem('grade_id')
                  localStorage.setItem('studentName', data.student.student_name)
                  localStorage.setItem('studentNis', data.student.student_nis)
                }
              } else if (data.msg === 'unauthorized') {
                this.messageClass = 'negative'
                this.message = t('salah_akses')

                setTimeout(hideMsg, 8000)
              } else {
                this.messageClass = 'negative'
                this.message = t('invalid_login')

                setTimeout(hideMsg, 4000)
              }
            }
          })
      }
    },
  },
})
