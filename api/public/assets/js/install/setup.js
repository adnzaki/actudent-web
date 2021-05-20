/**
 * Actudent Installer scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2021
 * @link        https://wolestech.com
 */
const app = new Vue({
    el: '#install-content',
    mixins: [plugin],
    data() {
        return {
            install: `${install}setup/`,
            register: `${install}registrasi`,
            alert: {
                class: 'bg-primary', show: false,
                header: '', text: '',
            },
            helper: {
                disableSaveButton: false,
                showSaveButton: true, showSuccessText: false,
                showPleaseWait: false,
            },
            progressText: '',
            successText: '',
            confirmInstall: '',
        }
    },
    mounted() {
        let getLang = () => {
            this.getLanguageResources('Setup')
            this.getLanguageResources('Admin')            
        }

        let obj = this
        async function exec() {
            await getLang()
            setTimeout(() => {
                obj.confirmInstall = obj.lang.install_continue
            }, 3000);
        }

        exec()
    },
    methods: {
        createTimelogModule() {
            this.execute('timelog', 'timelog', () => {                
                this.installSuccess()
            })
        },
        createSchoolModule() {
            this.execute('school', this.lang.navbar_sekolah, () => {                
                this.createTimelogModule()                
            })
        },
        createScoreModule() {
            this.execute('score', this.lang.menu_nilai, () => {                
                this.createSchoolModule()                
            })
        },
        createMessageModule() {
            this.execute('message', this.lang.menu_pesan, () => {                
                this.createScoreModule()                
            })
        },
        createTimelineModule() {
            this.execute('timeline', this.lang.menu_timeline, () => {                
                this.createMessageModule()                
            })
        },
        createAgendaModule() {
            this.execute('agenda', this.lang.menu_agenda, () => {                
                this.createTimelineModule()                
            })
        },
        createPresenceModule() {
            this.execute('presence', this.lang.menu_kehadiran, () => {                
                this.createAgendaModule()                
            })
        },
        createScheduleModule() {
            this.execute('schedule', this.lang.menu_jadwal, () => {                
                this.createPresenceModule()                
            })
        },
        createLessonsModule() {
            this.execute('lessons', this.lang.menu_mapel, () => {                
                this.createScheduleModule()
            })
        },
        createRoomModule() {
            this.execute('room', this.lang.menu_ruang, () => {
                this.createLessonsModule()
            })
        },
        createStudentModule() {
            this.execute('student', this.lang.menu_siswa, () => {
                this.createRoomModule()
            })
        },
        createGradeModule() {
            this.execute('grade', this.lang.menu_kelas, () => {
                this.createStudentModule()
            })
        },
        createStaffModule() {
            this.execute('staff', this.lang.menu_pegawai, () => {
                this.createGradeModule()
            })
        },
        createParentModule() {
            this.execute('parent', this.lang.menu_parent, () => {
                this.createStaffModule()
            })
        },
        createUserModule() {
            this.execute('user', this.lang.menu_pengguna, () => {
                this.createParentModule()
            })
        },      
        installSuccess() {
            this.helper.showSuccessText = true
            this.helper.showPleaseWait = false
            this.successText = this.lang.install_success
            this.confirmInstall = this.lang.install_redirecting
            this.progressText = ''    
            setTimeout(() => {
                window.location.href = this.register
            }, 2000)
        },
        execute(url, moduleName, nextTask) {
            this.helper.showPleaseWait = true
            this.helper.disableSaveButton = true
            this.confirmInstall = this.lang.install_waiting
            setTimeout(() => {                
                // timelog is the last step of the installation
                if(moduleName === 'timelog') {
                    this.progressText = this.lang.install_final
                } else {
                    let installText = this.lang.install_progress
                    this.progressText = installText.replace('%s', moduleName)
                }

                fetch(`${this.install}create-module/${url}`)
                    .then(response => response.json())
                    .then(msg => {
                        if(msg.status === 'OK') {                        
                            nextTask()
                        }
                    })                
            }, 1000);
        }
    },
    computed: {
        
    },
})