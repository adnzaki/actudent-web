/**
 * Actudent Score scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2020
 */

const nilai = new Vue({
    el: '#nilai-content',
    mixins: [SSPaging, plugin],
    data: {
        absensi: `${admin}absensi/`,
        jadwal: `${admin}jadwal/`,
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        helper: {
            disableSaveButton: false,
            showSaveButton: true, showDeleteButton: false,
            deleteProgress: false, mapelLength: 0, 
            gradeID: '', mapelType: '', selectedMapel: '',
        },
        spinner: false,
        scoreList: [],
    },
    mounted() {
        this.runSelect2()
        this.getLanguageResources('AdminNilai')

        if(actudentSection === 'admin') {
            this.getRombel()        
        }

        setTimeout(() => {
            this.helper.mapelType = $('#pilihTipe').val()            
        }, 200);
    },
    methods: {
        getNilai() {
            if(this.helper.gradeID !== '' && this.helper.selectedMapel !== '') {
                let url = `${this.nilai}get-kategori/${this.helper.gradeID}/${this.helper.selectedMapel}/${this.helper.mapelType}`
                $.ajax({
                    url: url,
                    dataType: 'json',
                    success: res => {
                        this.scoreList = res
                    }
                })
            }
        },
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
                        this.onMapelTypeChanged()
                    }, 50);              
                }
            })   
        },
        onRombelChanged() {
            let obj = this
            $('#pilihKelas').on('select2:select', function(e) {
                let data = e.params.data
                obj.helper.gradeID = data.id 
                obj.getMapel()
            })
        },  
        onMapelChanged() {
            let obj = this
            $('#pilihMapel').on('select2:select', function(e) {
                let data = e.params.data
                obj.helper.selectedMapel = data.id 
                obj.getNilai()
            })
        }, 
        onMapelTypeChanged() {
            let obj = this
            $('#pilihTipe').on('select2:select', function(e) {
                let data = e.params.data
                obj.helper.mapelType = data.id 
                obj.getNilai()
            })
        }, 
        getMapel() {
            // get lesson list
            $.ajax({
                url: `${this.jadwal}daftar-mapel-kelas/${this.helper.gradeID}`,
                dataType: 'json',
                success: res => {
                    $('#pilihMapel').html('').select2({
                        data: res
                    })          
                    setTimeout(() => {
                        this.helper.selectedMapel = $('#pilihMapel').val()
                        this.getNilai()
                    }, 200);                  
                }
            })   
        }
    },
    computed: {
        nilai() {
            if(actudentSection === 'admin') {
                return `${admin}nilai/`
            } else {
                return `${guru}nilai/`
            }
        }
    },
})