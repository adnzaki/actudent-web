/**
 * Actudent Data Absensi scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const absensi = new Vue({
    el: '#absensi-content', 
    mixins: [SSPaging, plugin],
    data: {
        absensi: `${admin}absensi/`,
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
            homework: false, scheduleID: '',
            activeDate: '', presenceButtons: false,
        },
        // The URL to get presence data
        urlAbsen: '',

        checkAll: false,
        siswa: [],
    },
    mounted() {
        this.reset()
        // setTimeout(() => {
        //     this.getMapel()
        // }, 200);
        this.runSelect2()
        this.getRombel()        
        this.getLanguageResources('AdminAbsensi')
        this.getLanguageResources('Admin')
        this.setDatePicker()        
        // this.onModalClose('#hapusModal')
    },
    methods: {
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
        checkJurnal() {
            if(this.helper.scheduleID !== '' && this.helper.scheduleID !== null) {
                $.ajax({
                    url: `${this.absensi}cek-jurnal/${this.helper.scheduleID}/${this.helper.activeDate}`,
                    dataType: 'json',
                    success: res => {
                        let baseURL = `${this.absensi}get-absen/${this.helper.gradeID}/`
                        if(res.status === 'true') {
                            this.helper.presenceButtons = true
                            this.urlAbsen = `${baseURL}${res.id}/${this.helper.activeDate}`
                        } else {
                            this.helper.presenceButtons = false
                            this.urlAbsen = `${baseURL}null/null`
                        }
    
                        // get presence data
                        this.getAbsensi(this.urlAbsen)
                    }
                })  
            }
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
                obj.getJadwal()
            })
        },  
        getAbsensi(url) {
            $.ajax({
                url: url,
                dataType: 'json',
                success: res => {
                    this.siswa = res
                }
            })  
        },   
        getJadwal() {
            if(this.helper.day !== '' && this.helper.gradeID !== '') {
                $.ajax({
                    url: `${this.absensi}get-jadwal/${this.helper.day}/${this.helper.gradeID}`,
                    dataType: 'json',
                    beforeSend: () => {
                         
                    },
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
                    obj.getJadwal()
                    obj.checkJurnal()
                }
            }).pickadate('picker')

            let date = new Date()
            datepicker.set('select', date)
            obj.helper.day = date.getDay()
        },
        selectAll() {

        },
    },
    computed: {
        jurnalDisabled() {
            if(this.helper.jadwalLength > 0) {
                return false
            } else {
                return true
            }
        }
    }

})