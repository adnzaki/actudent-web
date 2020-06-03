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
            app: `${this.auth}pengaturan-aplikasi/`,
            user: `${admin}`
        },
        theme: '', appLang: '',
    },
    mounted() {
        this.getWarnaTema()
        this.getLanguageResources('AdminSetting')
        this.getBahasa()
        this.runICheck('blue')
        this.getThemeValue()
        this.getLangValue()
        this.setting.app = `${this.auth}pengaturan-aplikasi/`
    },
    methods: {
        setTheme() {
            window.location.href = this.themeUrl
        },
        setBahasa() {
            window.location.href = this.languageUrl
        },
        getWarnaTema() {
            $(`#${warnaTema}`).iCheck('check')
        },
        getThemeValue() {
            let obj = this
            $('#theme-option input').on('ifChecked', function() {
                obj.theme = $(this).val()
            })
        },
        getBahasa() {
            $(`#${bahasa}`).iCheck('check')
        },
        getLangValue() {
            let obj = this
            $('#lang-option input').on('ifChecked', function() {
                obj.appLang = $(this).val()
            })
        },
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