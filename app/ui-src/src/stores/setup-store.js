import { defineStore } from 'pinia'
import { conf, install, createFormData } from 'src/composables/common'
import { Notify, Loading } from 'quasar'

export const useSetupStore = defineStore('setup', {
  state: () => {
    return {
      showProgressMessage: true,
      progressMessage: 'Installing %s module...',
      installSuccess: false,
      postData: {
        organization_name: '',
        subscription_type: 'Free',
        database_name: '',
        token: '',
        db_user: '',
        db_password: '',
      },
      error: {},
      progressColor: 'bg-accent',
      disableButton: false,
      timeout: 3000,
    }
  },
  actions: {
    checkInstallation() {
      const loading = Loading.show({
        message: 'Checking database installation...',
        group: 'check',
      })

      install
        .get('check')
        .then(({ data }) => {
          if (data.status === 1) {
            loading({
              message:
                'Database has been installed, access to this feature is disabled. Redirecting to login page...',
            })

            setTimeout(() => {
              Loading.hide()
              window.location.href = conf.loginUrl()
            }, 4000)
          } else {
            setTimeout(() => {
              Loading.hide()
            }, 1000)
          }
        })
        .catch(() => {
          setTimeout(() => {
            Loading.hide()
          }, 1000)
        })
    },
    setupOrganization() {
      install
        .post('create-organization', this.postData, {
          transformRequest: [(data) => createFormData(data)],
        })
        .then(({ data }) => {
          const loading = Notify.create({
            message: data.msg,
            spinner: false,
            color: data.status === 'failed' ? 'negative' : 'positive',
            icon: data.status === 'failed' ? 'report_problem' : 'verified',
            position: 'center',
            timeout: 0,
          })

          setTimeout(() => {
            loading()
            window.location.href = conf.loginUrl()
          }, this.timeout + 1000)
        })
    },
    createTimelog() {
      this.doInstall('timelog', () => {
        const loading = Notify.create({
          group: false,
          spinner: true,
          message:
            'Database successfully installed. Setting up organization details...',
          color: 'positive',
          position: 'center',
          timeout: this.timeout,
        })
        setTimeout(() => {
          this.setupOrganization()
        }, this.timeout)
      })
    },
    createHolidays() {
      this.doInstall('holidays', () => this.createTimelog())
    },
    createSetting() {
      this.doInstall('setting', () => this.createHolidays())
    },
    createSchool() {
      this.doInstall('school', () => this.createSetting())
    },
    createTimeline() {
      this.doInstall('timeline', () => this.createSchool())
    },
    createAgenda() {
      this.doInstall('agenda', () => this.createTimeline())
    },
    createPresence() {
      this.doInstall('presence', () => this.createAgenda())
    },
    createSchedule() {
      this.doInstall('schedule', () => this.createPresence())
    },
    createLesson() {
      this.doInstall('lessons', () => this.createSchedule())
    },
    createRoom() {
      this.doInstall('room', () => this.createLesson())
    },
    createStudent() {
      this.doInstall('student', () => this.createRoom())
    },
    createGrade() {
      this.doInstall('grade', () => this.createStudent())
    },
    createStaff() {
      this.doInstall('staff', () => this.createGrade())
    },
    createParent() {
      this.doInstall('parent', () => this.createStaff())
    },
    createSession() {
      this.doInstall('session', () => this.createParent())
    },
    createUser() {
      this.doInstall('user', () => this.createSession())
    },
    doInstall(module, next) {
      const loading = Notify.create({
        group: 'notify',
        spinner: true,
        message: this.progressMessage.replace('%s', module),
        color: 'accent',
        position: 'center',
        timeout: 0,
      })

      install
        .post(`create/${module}`, this.postData, {
          transformRequest: [(data) => createFormData(data)],
        })
        .then(({ data }) => {
          if (data.status === 'OK') {
            setTimeout(() => {
              if (module === 'timelog') loading()
              next()
            }, 500)
          } else {
            setTimeout(() => {
              loading()

              Notify.create({
                message:
                  'Installation failed, please provide a valid developer token.',
                timeout: this.timeout + 1000,
                icon: 'report_problem',
                color: 'negative',
                position: 'center',
              })

              this.disableButton = false
            }, 1000)
          }
        })
        .catch(() => {
          loading()
          this.disableButton = false
        })
    },
    setupDatabase() {
      //this.showProgressMessage = true
      this.disableButton = true
      const loading = Notify.create({
        group: false,
        spinner: true,
        message: 'Setting up database...',
        color: 'accent',
        position: 'center',
        timeout: 0,
      })

      install
        .post('setup-database', this.postData, {
          transformRequest: [(data) => createFormData(data)],
        })
        .then(({ data }) => {
          if (data.status === 'OK') {
            setTimeout(() => {
              loading()
              this.createUser()
            }, 3000)
          } else {
            loading({
              color: 'negative',
              message: 'There is a problem while setting up the database.',
              icon: 'report_problem',
              spinner: false,
            })
            this.disableButton = false
          }
        })
    },
    validateForm() {
      this.showProgressMessage = true
      this.disableButton = true
      const loading = Notify.create({
        group: false,
        spinner: true,
        message: 'Validating forms...',
        color: 'accent',
        position: 'center',
        timeout: 0,
      })

      install
        .post('validate', this.postData, {
          transformRequest: [(data) => createFormData(data)],
        })
        .then(({ data }) => {
          loading({ timeout: this.timeout })
          if (data.status === 'success') {
            this.setupDatabase()
            loading({ timeout: 1 })
            this.error = {}
          } else {
            loading({
              color: 'negative',
              message:
                'Unable to install database, please fill in the form correctly.',
              icon: 'report_problem',
              spinner: false,
            })
            this.error = data.msg
            this.disableButton = false
          }
        })
    },
  },
})
