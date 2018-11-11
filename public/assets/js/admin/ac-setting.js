/**
 * Actudent "Pengaturan" scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const setting = new Vue({
    el: '#setting-content',
    mixins: [SSPaging],
    data: {
        setting: `${admin}SettingController/`,
        theme: '',
    },
    mounted() {
        this.getWarnaTema()
    },
    methods: {
        setTheme() {
            window.location.href = this.themeUrl
        },
        getWarnaTema() {
            switch (warnaTema) {
                case 'semi-dark':       this.theme = 'semi-dark'; break;
                case 'light-blue':      this.theme = 'light-blue'; break;
                case 'night-vision':    this.theme = 'night-vision'; break;
                default: 'not a valid theme'; break;
            }
        }
    },
    computed: {
        themeUrl() {
            return `${this.setting}setWarnaTema/${this.theme}`
        }
    }
})