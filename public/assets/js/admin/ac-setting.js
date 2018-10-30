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
            (warnaTema === 'menu-dark') ? this.theme = 'semi-dark' : this.theme = 'light-blue'
        }
    },
    computed: {
        themeUrl() {
            return `${this.setting}setWarnaTema/${this.theme}`
        }
    }
})