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
        save(edit = false, id = null) {
            let url = `${this.nilai}save/${this.helper.selectedMapel}/${this.helper.mapelType}`, 
                form,
                obj = this

            if(edit) {
                url = `${url}/${id}`
                form = $('#formEditNilai')
            } else {
                form = $('#formTambahNilai')
            }
            let data = form.serialize()
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {
                    obj.alert.header = ''
                    obj.alert.text = obj.lang.nilai_save_progress
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
                        obj.alert.text = obj.lang.nilai_save_error

                        // hide after 3000 ms and change the class and text to default
                        setTimeout(() => {
                            obj.alert.show = false
                            obj.alert.class = 'bg-primary'
                            obj.alert.header = ''
                            obj.alert.text = ''
                        }, 3000);
                    } else {
                        if(edit) {
                            obj.resetForm('edit', form)
                        } else {
                            obj.resetForm('insert', form)
                        }
                    }
                },
                error: () => console.error('Network error')
            })
        },
        resetForm(type, form = '') {
            this.alert.show = false
            // clear error messages if exists
            this.error = {}

            // reset form
            if(form !== '') {
                form.trigger('reset')
            }

            // reload table 
            this.getNilai()
                
            if(type === 'insert') {
                this.alert.text = this.lang.nilai_insert_success 
                $('#tambahNilaiModal').modal('hide')
            } else if(type === 'edit') {
                this.alert.text = this.lang.nilai_edit_success
                $('#editNilaiModal').modal('hide')                     
            } else {
                this.alert.text = this.lang.nilai_delete_success                
            }

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
        showFormTambahNilai() {
            if(this.helper.gradeID !== '' || this.helper.selectedMapel !== '') {
                $('#tambahNilaiModal').modal('show')
            }
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
        },
        disableAddBtn() {
            if(this.helper.gradeID === '' || this.helper.selectedMapel === '') {
                return true
            } else {
                return false
            }
        }
    },
})