/**
 * Actudent Score scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2020
 */

const nilai = new Vue({
    el: '#nilai-content',
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
    },
    mounted() {
        this.getLanguageResources('AdminNilai')
    },
    methods: {
        
    },
    computed: {
        
    },
})