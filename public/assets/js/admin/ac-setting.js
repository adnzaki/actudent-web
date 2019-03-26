/**
 * Actudent "Pengaturan" scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const setting = new Vue({
    el: '#setting-content',
    mixins: [SSPaging, plugin],
    data: {
        setting: {
            app: `${admin}pengaturan-aplikasi/`,
            user: `${admin}`
        },
        theme: '', appLang: '',
    },
    mounted() {
        this.getWarnaTema()
        this.getLanguageResources('AdminSetting')
        this.getBahasa()
    },
    methods: {
        setTheme() {
            window.location.href = this.themeUrl
        },
        setBahasa() {
            window.location.href = this.languageUrl
        },
        getWarnaTema() {
            switch (warnaTema) {
                case 'semi-dark':       this.theme = 'semi-dark'; break;
                case 'light-blue':      this.theme = 'light-blue'; break;
                case 'night-vision':    this.theme = 'night-vision'; break;
                default: 'not a valid theme'; break;
            }
        },
        getBahasa() {
            switch (bahasa) {
                case 'english':     this.appLang = 'english'; break;
                case 'indonesia':   this.appLang = 'indonesia'; break;
                default: 'not a valid language'; break;
            }
        }
    },
    computed: {
        themeUrl() {
            return `${this.setting.app}set-tema/${this.theme}`
        },
        languageUrl() {
            return `${this.setting.app}set-bahasa/${this.appLang}`
        }
    }
})