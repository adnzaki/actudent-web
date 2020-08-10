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
            deleteProgress: false, mapelLength: 0, gradeID: '',
        },
        spinner: false,
    },
    mounted() {
        this.runSelect2()
        this.getLanguageResources('AdminNilai')

        if(actudentSection === 'admin') {
            this.getRombel()        
        }
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
                        // this.onMapelChanged()
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
        getMapel() {
            // get lesson list
            $.ajax({
                url: `${this.jadwal}daftar-mapel-kelas/${this.helper.gradeID}`,
                dataType: 'json',
                success: res => {
                    $('#pilihMapel').html('').select2({
                        data: res
                    })                            
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