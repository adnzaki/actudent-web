/**
 * Actudent Agenda scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2019
 */

const agenda = new Vue({
    el: '#agenda-content',
    mixins: [plugin],
    data: {
        agenda: `${admin}agenda/`,
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        fullCalendar: {
            show: true,
            view: 'month',
            defaultStart: '',
            defaultEnd: '',
        },        
        transitionClass: {
            enter: 'animated slideInLeft',
            leave: 'animated slideOutRight',
        },
        helper: {
            fullDayEvent: false,
            timeStart: '00:00', timeEnd: '23:30',
            hasAttachment: false, disableSaveButton: false,
            fileUploaded: '',
            showSaveButton: true, showDeleteButton: false,
        },
        locale: {
            english: 'en', indonesia: 'id'
        },
        searchParam: '', searchTimeout: false,
        searchResultWrapper: false,
        // storage for data that returned from server
        guests: [],
        // data to be sent to server
        guestWrapper: [], 
        // data to be displayed to user
        guestToDisplay: [],
        // data that come from "Semua wali kelas xxx" or "Semua wali murid xxx"
        guestWrapperAll: [],
        agendaStart: '', agendaEnd: '', agendaStartEdit: '', agendaEndEdit: '',
        eventDetail: { data: '', dataForPlugin: '', guests: '' },
    },
    mounted() {
        let thisMonth, nextMonth, start, end
            
        thisMonth = moment().get('month')
        nextMonth = thisMonth + 1

        start = moment().startOf('month')
        end = moment().month(nextMonth).startOf('month')
        this.fullCalendar.defaultStart = start.format('YYYY-MM-DD')
        this.fullCalendar.defaultEnd = end.format('YYYY-MM-DD')

        this.getEvents(
            this.fullCalendar.view, 
            this.fullCalendar.defaultStart, 
            this.fullCalendar.defaultEnd
        )
        setTimeout(() => {
            this.eventNav()  
            this.setView()          
        }, 1000);
        this.runDatePicker('.pickadate-add')
        this.runTimePicker('.pickatime-add')
        this.runICheck()     
        this.onModalClose('#agendaModal')
        this.onModalClose('#editAgenda', true)
        this.setFullDayEvent({ fullDay: '#allDayEvent', pickatime: '.pickatime-add' })
        this.getLanguageResources('AdminAgenda')
    },
    methods: {
        searchGuest() {
            // open the result wrapper
            this.searchResultWrapper = true
            
            // prevent request until searchTimeout is true
            if(!this.searchTimeout) {
                this.searchTimeout = true
                // wait for 300ms before processing request to server
                setTimeout(() => {
                    let keyword
                    if(this.searchParam === '') {
                        keyword = ''
                    } else {
                        keyword = `/${this.searchParam}`
                    }
                    $.ajax({
                        url: `${this.agenda}search-guest${keyword}`,
                        type: 'get',
                        dataType: 'json',
                        success: data => {
                            this.guests = data
                        }
                    })
                    // turn back searchTimeout to false
                    this.searchTimeout = false
                }, 300)
            }
        },
        getEventDetail(eventID) {
            this.validateFile('update-file')
            let obj = this
            $.ajax({
                url: `${obj.agenda}get-event-detail/${eventID}`,
                type: 'get',
                dataType: 'json',
                success: res => {
                    obj.eventDetail = res
                    obj.agendaStartEdit = res.dataForPlugin.agenda_start
                    obj.agendaEndEdit = res.dataForPlugin.agenda_end

                    // set and re-initialize datepicker and timepicker
                    let dateStart = obj.runDatePicker('#pickadate-edit-start').pickadate('picker')
                    dateStart.set('select', res.dataForPlugin.agendaDateStart, { format: 'yyyy-mm-dd' })
                    
                    let dateEnd = obj.runDatePicker('#pickadate-edit-end').pickadate('picker')
                    dateEnd.set('select', res.dataForPlugin.agendaDateEnd, { format: 'yyyy-mm-dd' })
                    obj.setTimePicker({ 
                        start: res.dataForPlugin.agendaTimeStart,
                        end: res.dataForPlugin.agendaTimeEnd
                    })
                    
                    
                    // initialize Switchery
                    setTimeout(() => {
                        obj.runSwitchery('#all-day-edit')
                        // set fullDayEvent to true if started from 00:00 to 23:30
                        if(res.dataForPlugin.agendaTimeStart === '00:00' 
                        && res.dataForPlugin.agendaTimeEnd === '23:30') {
                            obj.helper.fullDayEvent = true
                            let sw = document.querySelector('#all-day-edit')
                            if(!sw.checked) {
                                sw.click()
                            }
                        }
    
                        // initialize full day event
                        obj.setFullDayEvent({ fullDay: '#all-day-edit', pickatime: '.pickatime-edit' }, true)
                    }, 300);
                    

                    // set priority
                    $(`input#${res.data.agenda_priority}`).iCheck('check')

                    // loop guests from response, push them to guestWrapper, guestToDisplay
                    if(res.guests !== null) {
                        res.guests.forEach(val => {
                            obj.pushGuest({
                                id: val.user_id,
                                text: val.user_name,
                            })
                        })
                    }

                    if(res.data.agenda_attachment !== null) {
                        obj.helper.hasAttachment = true
                    }

                    // show the modal
                    $('#editAgenda').modal('show')                                            
                }
            })
        },
        setTimePicker(data) {
            let timeStart = this.runTimePicker('#pickatime-edit-start').pickatime('picker')
            timeStart.set('select', data.start)
            setTimeout(() => {
                let timeEnd = this.runTimePicker('#pickatime-edit-end').pickatime('picker')
                timeEnd.set('select', data.end)                        
            }, 50);
        },
        save(edit = false, id = null) {
            this.filterGuest()
            var form, url, uploadSelector,
                dateStartSelector, dateEndSelector,
                timeStartSelector, timeEndSelector

            if(edit) {
                form = $('#formEditAgenda')
                url = `${this.agenda}save/${id}`
                uploadSelector = 'update-file'
                dateStartSelector = 'agendaDateStartEdit'
                dateEndSelector = 'agendaDateEndEdit'
                timeStartSelector = 'timestartEdit'
                timeEndSelector = 'timeendEdit'
            } else {
                form = $('#formTambahAgenda')
                url = `${this.agenda}save`
                uploadSelector = 'upload-file'
                dateStartSelector = 'agendaDateStart'
                dateEndSelector = 'agendaDateEnd'
                timeStartSelector = 'timestart'
                timeEndSelector = 'timeend'
            }

            let beforeRequest = () => {
                let dateStart = $(`input[name=${dateStartSelector}]`).val(),
                    dateEnd = $(`input[name=${dateEndSelector}]`).val(),
                    timeStart = $(`input[name=${timeStartSelector}]`).val(),
                    timeEnd = $(`input[name=${timeEndSelector}]`).val()       
                
                if(this.helper.fullDayEvent) {
                    timeStart = this.helper.timeStart
                    timeEnd = this.helper.timeEnd                    
                } 
    
                // convert date to timestamp and parse to string
                let eventStart =  Date.parse(`${dateStart}T${timeStart}`).toString(),
                    eventEnd = Date.parse(`${dateEnd}T${timeEnd}`).toString()
    
                // only get the first 10 chars to match PHP timestamp
                this.agendaStart = eventStart.substr(0,10)
                this.agendaEnd = eventEnd.substr(0,10)
                this.agendaStartEdit = eventStart.substr(0,10)
                this.agendaEndEdit = eventEnd.substr(0,10)
            }

            let obj = this
            async function postRequest() {
                // wait until beforeRequest() is done 
                await beforeRequest()

                // do the post request!
                let data = form.serialize(),
                    hasAttachment,
                    fileInput = $(`#${uploadSelector} input[name=agenda_attachment]`).val()

                if(fileInput !== '') {
                    hasAttachment = true
                } else {
                    hasAttachment = false
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    beforeSend: () => {
                        obj.alert.text = obj.lang.agenda_saving_progress
                        obj.alert.show = true
                        obj.helper.disableSaveButton = true
                    },
                    success: res => {
                        obj.helper.disableSaveButton = false
                        if(res.code === '500') {
                            obj.error = res.msg

                            // set error alert
                            obj.alert.class = 'bg-danger'
                            obj.alert.header = 'Error!'
                            obj.alert.text = obj.lang.agenda_error_text

                            // hide after 3000 ms and change the class and text to default
                            setTimeout(() => {
                                obj.alert.show = false
                                obj.alert.class = 'bg-primary'
                                obj.alert.header = ''
                                obj.alert.text = obj.lang.agenda_saving_progress
                            }, 3000);
                        } else {
                            // if the form has attachment, upload it
                            if(hasAttachment) {
                                obj.uploadRequest(`${obj.agenda}upload/${res.id}`, uploadSelector)
                            }
                            
                            // reset everything
                            if(edit) {
                                obj.resetForm(form, 'edit')
                            } else {
                                obj.resetForm(form, 'insert')
                            }
                        }
                    },
                    error: () => console.error('Network error')
                })  
            }

            // execute them all!!
            postRequest()
        },        
        showAddAgendaForm() {
            $('#agendaModal').modal('show')
            this.validateFile('upload-file')

            // as onModalClose() changes the value of this.helper.fullDayEvent
            // to "false", we need to check if Switchery state is "checked" or not
            // because we do not reset Switchery state when modal is closed
            // so if Switchery is "checked", we have to change this.helper.fullDayEvent
            // to "true" again so we can disable the time picker 
            let sw = document.querySelector('#allDayEvent')
            if(sw.checked) {
                this.helper.fullDayEvent = true
            }

            // now initialize Switchery again
            setTimeout(() => {
                this.runSwitchery('#allDayEvent')                
            }, 300);
        },
        deleteAgenda() {
            let obj = this
            $.ajax({
                url: `${this.agenda}delete/${this.eventDetail.data.agenda_id}`,
                type: 'POST',
                dataType: 'json',
                beforeSend: () => {
                    obj.alert.text = obj.lang.agenda_delete_progress
                    obj.alert.show = true
                    obj.helper.disableSaveButton = true
                },
                success: msg => {
                    obj.helper.disableSaveButton = false
                    this.helper.showDeleteButton = false
                    this.helper.showSaveButton = true
                    obj.resetForm($('#formEditAgenda'), 'delete')
                }
            })
        },
        resetForm(form, type) {
            let obj = this
            obj.alert.show = false
            // clear error messages if exists
            obj.error = {}

            // reset form
            form.trigger('reset')

            // set fullDayEvent to false
            let switchery
            if(type === 'edit') {
                switchery = document.querySelector('#all-day-edit')
            } else {
                switchery = document.querySelector('#allDayEvent')
            }
            obj.helper.fullDayEvent = false
            switchery.click()
            if(switchery.checked === true) {
                switchery.click()
                obj.helper.fullDayEvent = false
            }                            

            // set priority to normal by re-running iCheck
            obj.runICheck()

            // reset guest
            obj.guestToDisplay = []
            obj.guestWrapper = []                            

            // reload events on calendar
            $('#fc-agenda-views').fullCalendar('destroy')
            obj.getEvents(obj.fullCalendar.view, obj.fullCalendar.defaultStart, obj.fullCalendar.defaultEnd)

            // show success alert and close the modal
            obj.alert.show = true    
            if(type === 'insert') {
                obj.alert.text = obj.lang.agenda_insert_success 
            } else if(type === 'edit') {
                obj.alert.text = obj.lang.agenda_edit_success                        
            } else {
                obj.alert.text = obj.lang.agenda_delete_success
            }

            $('#agendaModal').modal('hide')   
            $('#editAgenda').modal('hide')

            // hide success alert after 3500 ms
            setTimeout(() => {
                obj.alert.show = false
            }, 3500);
        },
        toggleFormAction(event = 'delete') {
            if(event === 'edit') {
                this.helper.showDeleteButton = false
                this.helper.showSaveButton = true
            } else {
                this.helper.showSaveButton = false
                this.helper.showDeleteButton = true
            }
        },
        onModalClose(target, isEditForm = false) {
            let obj = this
            $(target).on('hidden.bs.modal', function() {
                obj.helper.fullDayEvent = false
                obj.resetSwitchery()
                obj.error = {}
                if(isEditForm) {
                    obj.guestWrapper = []
                    obj.guestToDisplay = []
                    obj.guestWrapperAll = []
                    $('input#normal').iCheck('check')
                    obj.resetSwitchery(true)
                    obj.helper.hasAttachment = false
                    obj.helper.fileUploaded = ''
                    let formUpload = document.forms.namedItem('update-file')
                    formUpload.reset()
                }
            })
        },
        validateFile(formName) {
            let obj = this
            $('input[name=agenda_attachment]').on('change', function() {
                obj.uploadRequest(`${obj.agenda}validate-file`, formName, true)
                if(obj.eventDetail.data.agenda_attachment !== undefined) {
                    obj.helper.fileUploaded = obj.eventDetail.data.agenda_attachment
                }
            })
        },
        uploadRequest(url, formName, validate = false) {
            let form = document.forms.namedItem(formName),
                data = new FormData(form),
                req = new XMLHttpRequest
            req.open('POST', url, true)
            req.responseType = 'json'
            req.onload = obj => {
                if(req.response.msg === 'OK') {
                    this.error = {}
                    this.helper.disableSaveButton = false
                    if(validate === false) {
                        document.getElementById(formName).reset()
                    }
                } else {
                    this.error = req.response
                    this.helper.disableSaveButton = true
                }
            }
            req.send(data)
        },
        filterGuest() {
            // filter guest IDs before send them to server, no duplicate!
            if(this.guestWrapperAll.length > 0) {
                this.guestWrapperAll.forEach(el => {
                    if (this.guestWrapper.indexOf(el.id) === -1) {
                        this.guestWrapper.push(el.id)
                    }
                })
            }
        },
        pushGuest(data) {
            // check if the data has been in this.guestWrapper or not
            // if negative, push them 
            if(this.guestWrapper.indexOf(data.id) === -1) {
                this.guestWrapper.push(data.id)
                this.guestToDisplay.push({
                    id: data.id, name: data.text
                })
            }
        },
        pushAll(type) {
            // grab the guests by their types: wali_kelas or wali_murid
            let src = this.guests[type]

            // do not let users see the error in console!
            if(src !== undefined) {
                src.forEach(el => {
                    this.guestWrapperAll.push({
                        id: el.id, relation: `${type}-${this.searchParam}`
                    })
                })
                
                let text
                (type === 'wali_kelas') ? text = this.lang.agenda_all_walikelas : text = this.lang.agenda_all_parent
    
                // display guest by type such as "wali_kelas" or "wali_murid"
                this.guestToDisplay.push({
                    id: `${type}-${this.searchParam}`, 
                    name: `${text} "${this.searchParam}"`,
                })
            }
        },
        removeGuest(param) {
            // check if ID contains word like "wali_kelas" or "wali_murid"
            // if null, remove individual guest
            if(param.id.match(/wali/) === null) {
                let itemToRemove = this.guestWrapper.indexOf(param.id)    
                this.guestWrapper.splice(itemToRemove, 1)
                this.guestToDisplay.splice(itemToRemove, 1)
            } else {
                // create a temporary array 
                let tempArray = []     
                let display = this.guestToDisplay           
                this.guestWrapperAll.forEach(el => {
                    // if relation does not match with param.id
                    // push them to temporary array: tempArray
                    if(el.relation !== param.id) {
                        tempArray.push({
                            id: el.id, relation: el.relation
                        })
                    }
                    // replace original data with the new one
                    this.guestWrapperAll = tempArray

                    // get the guestToDisplay ID
                    let displayID = display.map(item => item.id).indexOf(el.id)

                    // if it's exist in guestWrapper and not exist in guestToDisplay,
                    // remove it to ensure that we do not have any duplicate values
                    if(this.guestWrapper.indexOf(el.id) !== -1 && displayID === -1) {
                        let idx = this.guestWrapper.indexOf(el.id)
                        this.guestWrapper.splice(idx, 1)
                    }
                })                

                // search guest that displayed to user
                // if matched, delete it                
                let index = display.findIndex(el => {
                    return el.id === param.id
                })
                display.splice(index, 1)
            }
        },
        clearResult() {
            this.searchResultWrapper = false 
            this.searchParam = ''
            this.guests = []
        },
        eventNav() {
            let obj = this
            
            $('body').on('click', 'button.fc-prev-button', function() {
                obj.transitionClass.enter = 'animated slideInRight'
                obj.transitionClass.leave = 'animated slideOutLeft'
                setTimeout(() => {
                    obj.execNav()           
                    setTimeout(() => {
                        obj.todayButton()
                    }, 800);      
                }, 50);
            })

            $('body').on('click', 'button.fc-next-button', function() {
                obj.transitionClass.enter = 'animated slideInLeft'
                obj.transitionClass.leave = 'animated slideOutRight'
                setTimeout(() => {
                    obj.execNav()    
                    setTimeout(() => {
                        obj.todayButton()
                    }, 800);          
                }, 50);
            }) 
        },        
        setView() {
            let obj = this

            $('body').on('click', 'button.fc-month-button', function() {
                obj.fullCalendar.view = 'month'
                getInterval()
                let dateInt = obj.eventLoadTrigger(),
                    start = moment([dateInt.start[2], dateInt.start[1]]).startOf(obj.calendarUnit).format('YYYY-MM-DD'),
                    end = moment([dateInt.start[2], dateInt.start[1]]).endOf(obj.calendarUnit).format('YYYY-MM-DD')                
                obj.fullCalendar.show = false 
                obj.execFullCalendar(start, end)
            })

            $('body').on('click', 'button.fc-agendaDay-button', function() {
                obj.fullCalendar.view = 'agendaDay'
                getInterval()
                obj.execNav(true)   
                setTimeout(() => {
                    obj.todayButton()
                }, 800);  
            })

            $('body').on('click', 'button.fc-agendaWeek-button', function() {
                obj.fullCalendar.view = 'agendaWeek'
                getInterval()
                let dateInt = obj.eventLoadTrigger(),
                    start   = moment([
                        dateInt.start[2], dateInt.start[1], dateInt.start[0]
                    ]).startOf(obj.calendarUnit).format('YYYY-MM-DD HH:mm:ss'),
                    
                    end = moment([
                        dateInt.start[2], dateInt.start[1], dateInt.start[0]
                    ]).endOf(obj.calendarUnit).format('YYYY-MM-DD HH:mm:ss')
                
                obj.fullCalendar.show = false 
                obj.execFullCalendar(start, end)
                setTimeout(() => {
                    obj.todayButton()
                }, 800);    
            })

            function getInterval() {
                obj.fullCalendar.defaultStart = moment().startOf(obj.calendarUnit).format('YYYY-MM-DD')
                obj.fullCalendar.defaultEnd = moment().endOf(obj.calendarUnit).format('YYYY-MM-DD')
            }
        },
        todayButton() {
            let obj = this
            $('button.fc-today-button').on('click', function() {
                setTimeout(() => {
                    obj.execNav(true)             
                }, 50);
            })
        },
        execNav(today = false) {
            let obj = this
            obj.fullCalendar.show = false
            let my = obj.eventLoadTrigger(),    
                view,
                start, end
            
            if(today) {
                start = obj.fullCalendar.defaultStart
                end = obj.fullCalendar.defaultEnd
            } else {
                start = moment([my.start[2], my.start[1], my.start[0]]).format('YYYY-MM-DD') 
                end = moment([my.end[2], my.end[1], my.end[0]]).format('YYYY-MM-DD') 
            }
            obj.execFullCalendar(start, end)
        },
        eventLoadTrigger() {
            let intervalStart = $('#fc-agenda-views').fullCalendar('getView').intervalStart,    
                intervalEnd = $('#fc-agenda-views').fullCalendar('getView').intervalEnd,
                dateStart = intervalStart._d,
                dateEnd = intervalEnd._d,
                dayStart = dateStart.getDate(),
                dayEnd = dateEnd.getDate(),
                monthStart = dateStart.getMonth(),
                monthEnd = dateEnd.getMonth(),

                // year must be the same
                year = dateStart.getFullYear()       
                
            return {
                start: [dayStart, monthStart, year],
                end: [dayEnd, monthEnd, year]
            }
        },
        execFullCalendar(start, end) {
            setTimeout(() => {
                this.fullCalendar.show = true
                $('#fc-agenda-views').fullCalendar('destroy')
                this.getEvents(this.fullCalendar.view, start, end)   
            }, 300);
        },
        getEvents(defaultView, viewStart, viewEnd) {
            let obj = this
            $.ajax({
                url: `${obj.agenda}get-events/${viewStart}/${viewEnd}`,
                type: 'get',
                dataType: 'json',
                success: data => {
                    $('#fc-agenda-views').fullCalendar({
                        events: data,
                        header: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'month,agendaWeek,agendaDay'
                        },
                        defaultDate: moment(viewStart).format('YYYY-MM-DD'),
                        defaultView: defaultView,
                        editable: false,
                        eventLimit: true, 
                        firstDay: 0,   
                        locale: this.locale[bahasa],
                        timeFormat: 'HH:mm',
                        slotLabelFormat: 'HH:mm',
                        eventClick: function (calEvent, jsEvent, view) {
                            obj.getEventDetail(calEvent.id)
                        }
                    })
                }
            })
        },
        setFullDayEvent(selector, isEdit = false) {
            let fullDay = document.querySelector(selector.fullDay)
            let obj = this
            let timestart, timeend
            if(isEdit) {
                timestart = 'timestartEdit'
                timeend = 'timeendEdit'
            } else {
                timestart = 'timestart'
                timeend = 'timeend'
            }
            fullDay.onchange = function() {
                obj.helper.fullDayEvent = fullDay.checked
                $(`input[name=${timestart}]`).val(obj.helper.timeStart)
                $(`input[name=${timeend}]`).val(obj.helper.timeEnd)
                if(!fullDay.checked) {
                    if(isEdit === false) {
                        setTimeout(() => {
                            obj.runTimePicker(selector.pickatime)
                            $(`input[name=${timestart}]`).val('')
                            $(`input[name=${timeend}]`).val('')
                        }, 200)
                    } else {
                        obj.setTimePicker({
                            start: obj.eventDetail.dataForPlugin.agendaTimeStart,
                            end: obj.eventDetail.dataForPlugin.agendaTimeEnd,
                        })
                    }
                } 
            }
        },
    },
    computed: {
        calendarUnit() {
            let unit
            switch (this.fullCalendar.view) {
                case 'month': unit = 'month'; break;
                case 'agendaWeek': unit = 'week'; break;
                case 'agendaDay': unit = 'day'; break;
                default: 'Unknown value'; break;
            }

            return unit
        },
        timepickerStatus() {
            if(this.helper.fullDayEvent) {
                return 'cursor-disabled'
            } else {
                return ''
            }
        },
    },
})