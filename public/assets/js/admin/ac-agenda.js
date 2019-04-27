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
        agenda: `${admin}agenda/`,
        error: {},
        alert: {
            class: 'alert bg-danger', show: false,
            header: 'Sukses', text: 'heheheh',
        },
        flashAlert: {
            class: 'bg-success', show: false, title: 'Sukses',
            text: 'Data peserta didik baru berhasil disimpan',
            icon: 'la-thumbs-o-up'
        },
        helper: {
            saveAndClose: false, fullDayCheck: true,
        },
        locale: {
            english: 'en', indonesia: 'id'
        },
        guests: [], 
        guestWrapper: [],
    },
    mounted() {
        this.getEvents()
        this.runDateTimePicker()
        this.runICheck()
        this.runSwitchery()
        this.searchGuest()
        this.pushGuest()
        this.getLanguageResources('AdminAgenda')
    },
    methods: {
        searchGuest() {
            var obj = this
            $(".select2-data-ajax").select2({
                ajax: {
                    url: function(params) {
                        return `${obj.agenda}search-guest/${params.term}`
                    } ,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        obj.guests = data
                        return {
                            results: data
                        }
                    },
                    cache: true,
                }
            });
        },
        filterGuest() {
            let finalGuest = []
            this.guestWrapper.forEach(el => {
                if(finalGuest.indexOf(el) === -1) {
                    finalGuest.push(el)
                }
            })
            
            let filtered = finalGuest.filter(e => {
                return e.match(/[0-9]/)
            })
            this.guestWrapper = filtered
        },
        pushGuest() {
            let obj = this
            $('.select2-data-ajax').on('select2:select', function(e) {
                let selectValue = $(this).val()
                selectValue.forEach(el => {
                    if(obj.guestWrapper.indexOf(el) === -1) {
                        obj.guestWrapper.push(el)
                    }
                })
                
                let allGuests = obj.guestWrapper.filter(guest => {
                    return guest.match(/wali/)
                })

                if(allGuests.length > 0) {
                    allGuests.forEach(el => {
                        if(el === 'wali_kelas') {
                            let waliKelas = obj.guests[1].children
                            waliKelas.forEach(v => {
                                obj.guestWrapper.push(v.id)
                            })
                        }

                        if(el === 'wali_murid') {
                            let waliMurid = obj.guests[2].children
                            waliMurid.forEach(v => {
                                obj.guestWrapper.push(v.id)
                            })
                        }
                    })
                }
            })
        },
        getEvents() {
            $.ajax({
                url: `${this.agenda}get-events`,
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
                        eventClick: function (calEvent, jsEvent, view) {
                            alert(`Agenda ${calEvent.title} dengan ID ${calEvent.id}`)
                        }
                    })
                }
            })
        },
    }
})