/**
 * Actudent Presence scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2020
 */

const absensi = new Vue({
    el: '#absensi-content', 
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
            day: '', gradeID: '', jadwalLength: 0,
            homework: false, scheduleID: '', journalID: '',
            activeDate: '', presenceButtons: false, salinJurnal: true,
            journalStatus: 'false', archivePage: true, archiveButton: false,
            presenceGrid: true, backToArchive: false,
        },
        // The URL to get presence data
        urlAbsen: '',

        checkAll: false, absenSiswa: [], izinAbsen: '',
        siswa: [], jurnal: {}, homework: {},
        spinner: false, spinnerTimeout: 250,
        journalArchive: [], presenceArchive: { 
            lesson: '', journal: '', 
            homework: '', dueDate: '' 
        },
        guru: {
            jadwal: [], 
            helper: {
                showJadwal: true, showAbsen: false,
                closePresenceButton: false,
            }
        }
    },
    mounted() {
        // setTimeout(() => {
        //     this.getMapel()
        // }, 200);
        this.runSelect2()

        if(actudentSection === 'admin') {
            this.getRombel()        
        }

        let t0 = performance.now()
        this.getLanguageResources('AdminAbsensi')
        this.getLanguageResources('Admin')
        this.getLanguageResources('GuruAbsensi')
        this.setDatePicker()        
        this.onModalClose('#jurnalModal')
        this.onModalClose('#izinModal')
        let t1 = performance.now()

        if(actudentSection === 'guru') {
            setTimeout(() => {
                this.getJadwalGuru()
            }, (t1-t0) + 200);
        }
    },
    methods: {
        showPresencePage(grade, schedule) {
            this.guru.helper.showAbsen = true
            this.guru.helper.closePresenceButton = true
            this.guru.helper.showJadwal = false
            this.helper.gradeID = grade
            this.helper.scheduleID = schedule
            this.checkJurnal()
        },
        closePresencePage() {
            this.guru.helper.showAbsen = false
            this.guru.helper.closePresenceButton = false
            this.guru.helper.showJadwal = true
            setTimeout(() => {
                this.setDatePicker()                        
            }, 200);
        },
        getJadwalGuru() {
            $.ajax({
                url: `${this.absensi}daftar-jadwal/${this.helper.day}`,
                dataType: 'json',
                success: res => {
                    this.guru.jadwal = res
                }
            }) 
        },
        //------------------------- Admin Section here --------------------------
        getRombel() {
            $('#pilihKelas').select2()               
            $.ajax({
                url: `${this.absensi}get-rombel`,
                dataType: 'json',
                success: res => {
                    $('#pilihKelas').select2({
                        data: res
                    })              
                    setTimeout(() => {
                        this.onRombelChanged()
                        this.onMapelChanged()
                    }, 50);              
                }
            })   
        },
        getAbsensi(url, useSpinner = false) {
            $.ajax({
                url: url,
                dataType: 'json',
                beforeSend: () => {
                    if(useSpinner) {
                        this.spinner = true                    
                    }
                },
                success: res => {
                    if(useSpinner) {
                        setTimeout(() => {
                            this.spinner = false                            
                        }, this.spinnerTimeout);
                    }
                    this.siswa = res
                }
            })  
        },   
        getJadwal() {
            if(this.helper.day !== '' && this.helper.gradeID !== '') {
                $.ajax({
                    url: `${this.absensi}get-jadwal/${this.helper.day}/${this.helper.gradeID}`,
                    dataType: 'json',
                    success: res => {
                        this.helper.jadwalLength = res.length
                        let t1 = performance.now()
                        $('#pilihMapel').html('').select2({
                            data: res
                        })     
                        let t2 = performance.now()
                        setTimeout(() => {
                            this.helper.scheduleID = $('#pilihMapel').val()      
                            this.checkJurnal()
                        }, (t2-t1) + 200);
                    }
                })                  
            }
        },
        checkJurnal() {
            if(this.helper.gradeID !== '') {
                let baseURL = `${this.absensi}get-absen/${this.helper.gradeID}/`
                this.urlAbsen = `${baseURL}null/null`
    
                if(this.helper.scheduleID !== '' && this.helper.scheduleID !== null) {
                    $.ajax({
                        url: `${this.absensi}cek-jurnal/${this.helper.scheduleID}/${this.helper.activeDate}`,
                        dataType: 'json',
                        beforeSend: () => {
                            this.spinner = true
                        },
                        success: res => {
                            this.helper.journalStatus = res.status
                            setTimeout(() => {
                                this.spinner = false                                
                            }, this.spinnerTimeout)
                            if(res.status === 'true') {
                                this.helper.presenceButtons = true
                                this.helper.journalID = res.id
                                this.urlAbsen = `${baseURL}${res.id}/${this.helper.activeDate}`
                            } else {
                                this.helper.presenceButtons = false                            
                            }   
                            
                            // get presence data
                            this.getAbsensi(this.urlAbsen)
                        }
                    })  
                } else {
                    this.helper.presenceButtons = false
                    this.getAbsensi(this.urlAbsen, true) // use spinner
                }
            }
        },
        saveJurnal() {
            let form = $('#formJurnal').serialize()
            let url = `${this.absensi}save/${this.helper.scheduleID}/${this.helper.activeDate}`,
                includeHomework
            (this.helper.homework) ? includeHomework = 'true' : includeHomework = 'false'
            $.ajax({
                url: `${url}/${includeHomework}`,
                type: 'POST',
                dataType: 'json',
                data: form,
                beforeSend: () => {
                    this.alert.header = ''
                    this.alert.text = this.lang.absensi_jurnal_save_progress
                    this.alert.show = true
                    this.helper.disableSaveButton = true
                },
                success: res => {
                    this.helper.disableSaveButton = false
                    if(res.code === '500') {
                        this.error = res.msg

                        // set error alert
                        this.alert.class = 'bg-danger'
                        this.alert.header = 'Error!'
                        this.alert.text = this.lang.absensi_jurnal_error_save

                        // hide after 3000 ms and change the class and text to default
                        setTimeout(() => {
                            this.alert.show = false
                            this.alert.class = 'bg-primary'
                            this.alert.header = ''
                            this.alert.text = ''
                        }, 3000);
                    } else {
                        this.resetJournal($('#formJurnal'))
                    }
                }
            })
        },
        saveAbsen(status, studentID = null, mark = '') {
            let data = []
            if(studentID === null) {
                this.absenSiswa.forEach(id => {
                    data.push({status: status, mark: mark, id: id})
                })
            } else {
                data = [
                    { status: status, mark: mark, id: studentID }
                ]
            }

            absen = JSON.stringify(data)
            $.ajax({
                url: `${this.absensi}simpan-absen/${status}/${this.helper.journalID}/${this.helper.activeDate}`,
                type: 'post',
                dataType: 'json',
                data: { absen: absen },
                beforeSend: () => {
                    this.spinner = true
                },
                success: () => {
                    this.spinner = false
                    this.absenSiswa = []
                    if(this.checkAll) {
                        this.checkAll = false
                    }

                    // reload presence data
                    this.getAbsensi(this.urlAbsen)
                }
            })
        },
        multiPresence() {
            if(this.absenSiswa.length === 0) {
                this.alert.header = 'Error!'
                this.alert.class = 'bg-danger'
                this.alert.text = this.lang.pilih_data_dulu
                this.alert.show = true
                setTimeout(() => {
                    this.alert.show = false
                }, 3500);
            } else {
                $('#izinModal').modal('show')
            }
        },
        resetJournal(form = '') {
            this.alert.show = false

            // clear error messages if exists
            this.error = {}

            // reset form
            if(form !== '') {
                form.trigger('reset')
            }

            // reload table
            this.checkJurnal()
                
            this.alert.text = this.lang.absensi_jurnal_success_save 
            $('#jurnalModal').modal('hide')

            this.alert.header = this.lang.sukses
            this.alert.class = 'bg-success'
            this.alert.show = true

            setTimeout(() => {
                this.alert.show = false
                this.alert.header = ''
                this.alert.class = 'bg-primary'
                this.alert.text = ''
            }, 3500);
        },
        openJurnalModal() {
            if(this.helper.journalStatus === 'true') {
                this.helper.salinJurnal = false
                this.getJurnal()
            }
            $('#jurnalModal').modal('show')            
        },
        openIzinModal(id, note) {
            this.absenSiswa = []
            this.absenSiswa.push(id)
            this.izinAbsen = note
            $('#izinModal').modal('show')
        },
        validasiIzin() {
            let form = $('#formIzin').serialize()
            $.ajax({
                url: `${this.absensi}izin`,
                type: 'POST',
                dataType: 'json',
                data: form,
                beforeSend: () => {
                    this.alert.header = ''
                    this.alert.text = this.lang.absensi_izin_progress
                    this.alert.show = true
                    this.helper.disableSaveButton = true
                },
                success: res => {
                    this.helper.disableSaveButton = false
                    if(res.code === '500') {
                        // set error alert
                        this.alert.class = 'bg-danger'
                        this.alert.header = 'Error!'
                        this.alert.text = res.msg.presence_mark

                        // hide after 3000 ms and change the class and text to default
                        setTimeout(() => {
                            this.alert.show = false
                            this.alert.class = 'bg-primary'
                            this.alert.header = ''
                            this.alert.text = ''
                        }, 3000);
                    } else {
                        this.alert.show = false

                        $('#izinModal').modal('hide')
                        this.saveAbsen(2, null, this.izinAbsen)
                        this.izinAbsen = ''
                    }
                }
            })
        },
        copyJurnal() {
            $.ajax({
                url: `${this.absensi}salin-jurnal/${this.helper.scheduleID}/${this.helper.activeDate}`,
                dataType: 'json',
                beforeSend: () => {
                    this.alert.header = ''
                    this.alert.class = 'bg-primary'
                    this.alert.show = true
                    this.alert.text = this.lang.absensi_salin_jurnal_progress
                },
                success: res => {
                    if(res.status === 'OK') {
                        this.helper.journalID = res.id
                        let t1 = performance.now()
                        this.getJurnal()
                        let t2 = performance.now()

                        setTimeout(() => {
                            this.alert.header = this.lang.sukses
                            this.alert.class = 'bg-success'
                            this.alert.text = this.lang.absensi_salin_jurnal_sukses
                            this.helper.salinJurnal = false
                        }, (t2-t1) + 100);
                    } else {
                        this.alert.header = 'Error!'
                        this.alert.class = 'bg-danger'
                        this.alert.text = this.lang.absensi_salin_jurnal_gagal
                    }

                    setTimeout(() => {
                        this.alert.show = false
                        this.alert.header = ''
                        this.alert.class = 'bg-primary'
                        this.alert.text = ''
                    }, 3600);
                }
            })
        },
        showPresenceArchive(params) {
            // reset homework and due date if it exists
            this.presenceArchive.homework = ''
            this.presenceArchive.dueDate = ''
            
            date = params.created.substr(0, 10)
            let url = `${this.absensi}get-absen/${params.grade_id}/${params.journal_id}/${date}`
            this.helper.presenceGrid = true
            this.helper.backToArchive = true
            if(actudentSection === 'guru') {
                this.guru.helper.showAbsen = true
            }

            this.presenceArchive.lesson = params.lesson_name
            this.presenceArchive.journal = params.description
            if(params.homework !== '') {
                this.presenceArchive.homework = homework.title
                this.presenceArchive.dueDate = homework.due_date
            }
            this.getAbsensi(url, true)
        },
        showArchive() {
            let grade
            (actudentSection === 'admin') ? grade = this.helper.gradeID : grade = 'null'
            $.ajax({
                url: `${this.absensi}arsip-jurnal/${grade}/${this.helper.activeDate}`,
                dataType: 'json',
                beforeSend: () => {
                    this.spinner = true   
                },
                success: res => {
                    this.journalArchive = res             
                    this.helper.archivePage = false
                    this.helper.archiveButton = false
                    this.helper.jadwalLength = 0
                    this.helper.presenceGrid = false
                    this.helper.presenceButtons = false
                    this.helper.backToArchive = false
                    this.guru.helper.showJadwal = false
                    this.guru.helper.showAbsen = false
                    this.siswa = []
                    setTimeout(() => {
                        this.spinner = false                            
                    }, this.spinnerTimeout);
                }
            })  
        },
        closeArchive() {
            this.helper.archivePage = true
            this.helper.archiveButton = true  
            this.guru.helper.showJadwal = true          
            setTimeout(() => {
                this.helper.gradeID = ''

                if(actudentSection === 'admin') {
                    this.runSelect2()
                    this.getRombel()   
                }

                this.setDatePicker()                 
            }, 100);
        },
        getJurnal() {
            $.ajax({
                url: `${this.absensi}get-jurnal/${this.helper.journalID}`,
                dataType: 'json',
                success: res => {
                    this.jurnal = res.journal
                    if(res.homework !== null) {
                        this.helper.homework = true
                        this.homework = res.homework[0]
                        setTimeout(() => {
                            let dp = this.runDatePicker('.pickadate-add').pickadate('picker')
                            dp.set('select', this.homework.due_date, { format: 'yyyy-mm-dd' })                                
                        }, 500);
                    }
                }
            })
        },
        addHomework() {
            setTimeout(() => {
                this.runDatePicker('.pickadate-add')
            }, 200);
        },
        onMapelChanged() {
            let obj = this
            $('#pilihMapel').on('select2:select', function(e) {
                let data = e.params.data
                obj.helper.scheduleID = data.id
                obj.checkJurnal()
            })
        },
        onRombelChanged() {
            let obj = this
            $('#pilihKelas').on('select2:select', function(e) {
                let data = e.params.data
                obj.helper.gradeID = data.id 
                if(data.id === '' || data.id === 'null') {
                    obj.helper.archiveButton = false
                } else {
                    obj.helper.archiveButton = true
                }
                obj.getJadwal()
            })
        },      
        onModalClose(modal) {
            let obj = this
            $(modal).on('hidden.bs.modal', function() {                
                obj.helper.homework = false
                obj.jurnal = {}
                obj.homework = {}
                obj.helper.salinJurnal = true
                if(modal === '#izinModal') {
                    obj.izinAbsen = ''
                }
            })

        },
        setDatePicker() {
            let obj = this
            let datepicker = $('.pickadate').pickadate({
                selectMonths: true,
                selectYears: true,
                hiddenName: true,
                formatSubmit: 'yyyy-mm-dd',
                format: 'dddd, d mmmm yyyy',
                firstDay: 0,
                clear: '',
                onSet: context => {
                    let date = new Date(context.select)
                    obj.helper.day = date.getDay()
                    obj.helper.activeDate = moment(date).format('YYYY-MM-DD')
                    if(actudentSection === 'admin') {
                        obj.getJadwal()
                    }

                    if(actudentSection === 'guru') {
                        obj.getJadwalGuru()
                    }
                }
            }).pickadate('picker')

            let date = new Date()
            datepicker.set('select', date)
            obj.helper.day = date.getDay()
        },
        selectAll() {
            if(this.checkAll) {
                this.siswa.forEach(item => {
                    this.absenSiswa.push(item.id)
                })
            } else {
                this.absenSiswa = []
            }
        },
        presenceClass(status) {
            let statusClass
            switch (status) {
                case '0': statusClass = 'danger'; break;
                case '1': statusClass = 'success'; break;
                case '2': statusClass = 'info'; break;
                case '3': statusClass = 'secondary'; break;
                default: statusClass = 'primary'; break;
            }

            return `badge-${statusClass}`
        },
        statusNote(text) {
            return (text !== '') ? text : '-'
        }
    },
    computed: {
        journalReportURL() {
            return `${this.absensi}ekspor-jurnal/${this.helper.gradeID}/${this.helper.day}/${this.helper.activeDate}`
        },
        presenceReportURL() {
            return `${this.absensi}ekspor-absen/${this.helper.gradeID}/${this.helper.day}/${this.helper.activeDate}`
        },
        jurnalDisabled() {
            return (this.helper.jadwalLength > 0) ? false : true
        },
        archiveStatus() {
            return (this.helper.gradeID === '' || this.helper.gradeID === 'null') ? false : true
        },
        absensi() {
            if(actudentSection === 'admin') {
                return `${admin}absensi/`
            } else {
                return `${guru}jadwal-kehadiran/`
            }
        }
    },
})