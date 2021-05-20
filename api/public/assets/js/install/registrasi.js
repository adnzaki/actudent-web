/**
 * Actudent Register scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2021
 * @link        https://wolestech.com
 */
const app = new Vue({
    el: '#register-content',
    mixins: [plugin],
    data() {
        return {
            register: `${install}registrasi/`,
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
        this.getLanguageResources('Registration')
        this.getLanguageResources('Admin')            
    },
    methods: {
        
    },
    computed: {
        
    },
})