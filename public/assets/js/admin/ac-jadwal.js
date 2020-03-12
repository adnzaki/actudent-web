/**
 * Actudent Schedules scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2020
 */

const jadwal = new Vue({
    el: '#jadwal-content',
    mixins: [SSPaging, plugin],
    data: {
        jadwal: `${admin}jadwal/`,
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
        this.reset()
        setTimeout(() => {

        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminJadwal')
    },
    methods: {
    },
})