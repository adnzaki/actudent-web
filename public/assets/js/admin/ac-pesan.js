/**
 * Actudent message scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2020
 */

const pesan = new Vue({
    el: '#pesan-content',
    mixins: [SSPaging, plugin],
    data: {
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        helper: {
            disableSaveButton: false,
            showSaveButton: true, showDeleteButton: false,
            deleteProgress: false,
        },
        spinner: false,
    },
    mounted() {
        this.runSelect2()
        this.getLanguageResources('AdminPesan')
        this.getLanguageResources('Admin')

    },
    methods: {
    },
    computed: {        
        pesan() {
            if(actudentSection === 'admin') {
                return `${admin}pesan/`
            } else {
                return `${guru}pesan/`
            }
        },
    },
})