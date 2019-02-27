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
        agenda: `${admin}AgendaController/`,
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
        locale: {
            english: 'en', indonesia: 'id'
        }
    },
    mounted() {
        this.getEvents()
        this.getLanguageResources()
    },
    methods: {
        getEvents() {
            $.ajax({
                url: `${this.agenda}getEvents`,
                type: 'get',
                dataType: 'json',
                success: data => {
                    $('#fc-agenda-views').fullCalendar({
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        defaultDate: moment().format('YYYY-MM-DD'),
                        defaultView: 'month',
                        editable: false,
                        eventLimit: true,
                        events: data,
                        locale: this.locale[bahasa],
                        timeFormat: 'HH:mm',
                        slotLabelFormat: 'HH:mm',
                        eventClick: function(calEvent, jsEvent, view) {
                            alert(`Agenda ${calEvent.title} dengan ID ${calEvent.id}`)
                        }
                    })
                }
            })
        },
    }
})