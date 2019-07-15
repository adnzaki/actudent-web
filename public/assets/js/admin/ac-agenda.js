/**
 * Actudent Agenda scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2019
 */

const agenda = new Vue({
    el: '#agenda-content',
    mixins: [SSPaging, plugin],
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
            leave: 'animated slideOutRight'
        },
        helper: {
            fullDayEvent: false,
            timeStart: '00:00', timeEnd: '23:59',
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
        agendaStart: '', agendaEnd: '',
    },
    mounted() {
        this.fullCalendar.defaultStart = moment().startOf('month').format('YYYY-MM-DD')
        this.fullCalendar.defaultEnd = moment().endOf('month').format('YYYY-MM-DD')
        this.getEvents(
            this.fullCalendar.view, 
            this.fullCalendar.defaultStart, 
            this.fullCalendar.defaultEnd
        )
        setTimeout(() => {
            this.eventNav()  
            this.setView()          
        }, 1000);
        this.runDatePicker()
        this.runTimePicker()
        this.runICheck()
        this.runSwitchery()
        this.setFullDayEvent()
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
        save() {
            this.filterGuest()
            let form = $('#formTambahAgenda')
            let beforeRequest = () => {
                let dateStart = $('input[name=agendaDateStart]').val(),
                    dateEnd = $('input[name=agendaDateEnd]').val(),
                    timeStart = $('input[name=timestart]').val(),
                    timeEnd = $('input[name=timeend]').val()       
                
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
            }

            let obj = this
            async function postRequest() {
                // wait until beforeRequest() is done 
                await beforeRequest()

                // do the post request!
                let data = form.serialize(),
                    fileInput = $('input[name=agenda_attachment]').val(),
                    hasAttachment
                (fileInput !== '') ? hasAttachment = true : hasAttachment = false
                $.ajax({
                    url: `${obj.agenda}save`,
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                    beforeSend: () => {
                        obj.alert.text = obj.lang.agenda_saving_progress
                        obj.alert.show = true
                    },
                    success: res => {
                        if(res.code === '500') {
                            obj.error = res.msg

                            // set error alert
                            obj.alert.class = 'bg-danger'
                            obj.alert.header = 'Error!'
                            obj.alert.text = obj.lang.agenda_error_text

                            // hide after 3000 ms and change the class and text
                            setTimeout(() => {
                                obj.alert.show = false
                                obj.alert.class = 'bg-primary'
                                obj.alert.header = ''
                                obj.alert.text = obj.lang.agenda_saving_progress
                            }, 3000);
                        } else {
                            obj.alert.show = false
                            // clear error messages if exists
                            obj.error = {}

                            // reset form
                            form.trigger('reset')

                            // set fullDayEvent to false
                            let switchery = document.querySelector('#allDayEvent')
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

                            // if the form has attachment, upload it
                            if(hasAttachment) {
                                obj.uploadFile(res.insertID)
                            }

                            // reload events on calendar
                            $('#fc-agenda-views').fullCalendar('destroy')
                            obj.getEvents(obj.fullCalendar.view, obj.fullCalendar.defaultStart, obj.fullCalendar.defaultEnd)

                            // show success alert and close the modal
                            obj.alert.show = true
                            $('#agendaModal').modal('hide')

                            // hide success alert after 3500 ms
                            setTimeout(() => {
                                obj.alert.show = false
                            }, 3500);
                        }
                    },
                    error: () => console.error('Network error')
                })  
            }

            // execute them all!!
            postRequest()
        },
        uploadFile(insertID) {
            let form = document.forms.namedItem('upload-file'),
                data = new FormData(form),
                req = new XMLHttpRequest
                req.open('POST', `${this.agenda}upload/${insertID}`, true)
                req.responseType = 'json'
                req.onload = obj => {
                    if(req.response.msg === 'OK') {
                        this.error = {}
                        document.getElementById('upload-file').reset()
                    } else {
                        this.error = req.response
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
            function run(today = false) {
                obj.fullCalendar.show = false
                setTimeout(() => {
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
                }, 300)
            }
            
            $('body').on('click', 'button.fc-prev-button', function() {
                obj.transitionClass.enter = 'animated slideInRight'
                obj.transitionClass.leave = 'animated slideOutLeft'
                setTimeout(() => {
                    run()           
                    setTimeout(() => {
                        todayButton()
                    }, 800);      
                }, 50);
            })

            $('body').on('click', 'button.fc-next-button', function() {
                obj.transitionClass.enter = 'animated slideInLeft'
                obj.transitionClass.leave = 'animated slideOutRight'
                setTimeout(() => {
                    run()    
                    setTimeout(() => {
                        todayButton()
                    }, 800);          
                }, 50);
            }) 

            function todayButton() {
                $('button.fc-today-button').on('click', function() {
                    setTimeout(() => {
                        run(true)              
                    }, 50);
                })
            }   
        },
        eventLoadTrigger() {
            let intervalStart = $('#fc-agenda-views').fullCalendar('getView').intervalStart,    
                intervalEnd = $('#fc-agenda-views').fullCalendar('getView').intervalEnd,
                dateStart = intervalStart._d,
                dateEnd = intervalEnd._d
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
            })

            function getInterval() {
                obj.fullCalendar.defaultStart = moment().startOf(obj.calendarUnit).format('YYYY-MM-DD')
                obj.fullCalendar.defaultEnd = moment().endOf(obj.calendarUnit).format('YYYY-MM-DD')
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
            $.ajax({
                url: `${this.agenda}get-events/${viewStart}/${viewEnd}`,
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
                            alert(`Agenda ${calEvent.title} dengan ID ${calEvent.id}`)
                        }
                    })
                }
            })
        },
        setFullDayEvent() {
            let fullDay = document.querySelector('#allDayEvent')
            let obj = this
            fullDay.onchange = function() {
                obj.helper.fullDayEvent = fullDay.checked
                $('input[name=timestart]').val(obj.helper.timeStart)
                $('input[name=timeend]').val(obj.helper.timeEnd)
                if(!fullDay.checked) {
                    setTimeout(() => {
                        obj.runTimePicker()
                        $('input[name=timestart]').val('')
                        $('input[name=timeend]').val('')
                    }, 200)
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