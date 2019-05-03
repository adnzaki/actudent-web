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
    },
    mounted() {
        this.getEvents()
        this.runDateTimePicker()
        this.runICheck()
        this.runSwitchery()
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
                (type === 'wali_kelas') ? text = 'Semua wali kelas' : text = 'Semua wali murid'
    
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
    },
})