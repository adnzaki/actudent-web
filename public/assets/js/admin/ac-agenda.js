/**
 * Actudent Agenda scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const agenda = new Vue({
    el: '#agenda-content',
    mixins: [SSPaging, plugin],
    data: {
        siswa: `${admin}AgendaController/`,
        error: { 
        },
        alert: {
            class: 'alert bg-danger', show: false,
            header: 'Sukses', text: 'heheheh',
        },
        flashAlert: {
            class: 'bg-success', show: false,
            title: 'Sukses', text: 'Data peserta didik baru berhasil disimpan', 
            icon: 'la-thumbs-o-up'
        },
        helper: {
            saveAndClose: false,
        },
    },
    mounted() {
        //this.runCalendar()
        this.getLanguageResources()
    },
    methods: {
    }
})