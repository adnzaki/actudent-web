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
        guests: [
            {
                text: 'Semua',
                children: [
                    {
                        id: 1,
                        text: 'Semua Wali Kelas'
                    },
                    {
                        id: 2,
                        text: 'Semua Wali Murid'
                    },
                    {
                        id: 3,
                        text: 'Staff'
                    },
                ],
            },
            {
                text: 'Daftar Wali Kelas',
                children: [],
            },
            {
                text: 'Daftar Wali Murid',
                children: [],
            }
        ],
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
        }
    },
    mounted() {
        this.getEvents()
        this.runDateTimePicker()
        this.runICheck()
        this.runSwitchery()
        this.initSelect2Agenda()
        this.getLanguageResources('AdminAgenda')
        this.checkAllGuests()
    },
    methods: {
        initSelect2Agenda() {
            var obj = this
            $(".select2-data-ajax").select2({
                ajax: {
                    url: function(params) {
                        return `${obj.agenda}search-guest/${params.term}`
                    } ,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data
                        }
                    },
                    cache: true,
                }
            });
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
        checkAllGuests() {
            $('#all-guest').on('ifChecked', function () {
                $('.guest-list input').each(function () {
                    $(this).iCheck('check')
                    $(this).iCheck('disable')
                })
            })

            $('#all-guest').on('ifUnchecked', function () {
                $('.guest-list input').each(function () {
                    $(this).iCheck('uncheck')
                    $(this).iCheck('enable')
                })
            })
        }
    }
})