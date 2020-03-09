/**
 * Actudent Data Pegawai scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const pegawai = new Vue({
    el: '#pegawai-content',
    mixins: [SSPaging, plugin],
    data: {
        pegawai : `${admin}pegawai/`,
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },        
        helper: {
            disableSaveButton: false,
            showSaveButton: true, showDeleteButton: false,
            deleteProgress: false,
        },
        staffDetail: [], userEmail: '', domain: '',
        staffType:'',
        // children: [],
       // staffName: '',       
        staff: [], checkAll: false,

    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getPegawai()            
        }, 200);
        this.domain = domainSekolah
        this.runSelect2()
        this.getPegawaiByType()
        this.select2ShowPerPage('#showRows')
        this.runICheck('blue')     
        this.getLanguageResources('AdminPegawai')
        this.getLanguageResources('AdminOrtu')
        this.getLanguageResources('Admin')
        this.onModalClose('#hapusModal')
    },
    methods: {
        getPegawai() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'staff_name',
                searchBy: [ 
                    'staff_nik', 'staff_name', 
                    'staff_phone', 'staff_type', 'staff_title'
                ],
                sort: 'ASC',
                where: null,
                search: '',
                url: `${this.pegawai}get-pegawai/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        },
        getPegawaiByType() {
            let obj = this
            $('#selectStaff').on('select2:select', function (e) {
                var data = e.params.data
                obj.whereClause = data.id
                obj.runPaging()
            })
        },
        showAddPegawaiForm() {
            setTimeout(() => {
                this.runICheck('blue')            
            }, 500);    
        },
        getDetailPegawai(id) {
            this.error = {}
            let obj = this
            $('#editPegawaiModal').modal('show')
            $.ajax({
                url: `${this.pegawai}detail/${id}`,
                type: 'get',
                dataType: 'json',
                success: res => {
                    obj.staffDetail = res
                    this.staffDetail = res.staff

                    $(`input#${res.staff.staff_type}`).iCheck('check')


                }
            })
        },
        save(edit = false, id = null) {
            let url, form
            let obj = this
            if(edit) {
                url = `${this.pegawai}save/${id}`
                form = $('#formEditPegawai')
            } else {
                url = `${this.pegawai}save`
                form = $('#formTambahPegawai')
            }

            let data = form.serialize()
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {
                    obj.alert.header = ''
                    obj.alert.text = obj.lang.staff_save_progress
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
                        obj.alert.text = obj.lang.staff_error_text

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
        deleteStaff() {
            let idString
            if(this.staff.length > 1) {
                idString = this.staff.join('&')
            } else {
                idString = this.staff[0]
            }

            $.ajax({
                url: `${this.pegawai}/delete/${idString}`,
                type: 'POST',
                dataType: 'json',
                beforeSend: () => {
                    this.helper.deleteProgress = true
                    this.helper.disableSaveButton = true
                },
                success: msg => {
                    $('#hapusModal').modal('hide')
                    this.resetForm('delete')
                    setTimeout(() => {
                        this.helper.disableSaveButton = false
                        this.helper.deleteProgress = false                        
                    }, 1000);
                }
            })
        },
        singleDeleteConfirm(staffID, userID) {
            if(this.staff.length > 0) {
                this.staff = []
                this.checkAll = false
            } 

            this.staff.push(`${staffID}-${userID}`)
            $('#hapusModal').modal('show')
        },
        multiDeleteConfirm() {
            if(this.staff.length === 0) {
                this.alert.header = 'Error!'
                this.alert.class = 'bg-danger'
                this.alert.text = this.lang.pilih_data_dulu
                this.alert.show = true
                setTimeout(() => {
                    this.alert.show = false
                }, 3500);
            } else {
                $('#hapusModal').modal('show')
            }
        },
        onModalClose(target) {
            let obj = this
            $(target).on('hidden.bs.modal', function() {
                obj.staff = []
                obj.checkAll = false
                $('input#normal').iCheck('check')
            })
        },
        selectAll() {
            if(this.checkAll) {
                this.data.forEach(item => {
                    this.staff.push(`${item.staff_id}-${item.user_id}`)
                })
            } else {
                this.staff = []
            }
        },
        resetForm(type, form = '') {
            this.alert.show = false
            // clear error messages if exists
            this.error = {}

            // reset form
            if(form !== '') {
                form.trigger('reset')
            }

            this.StaffName = ''
            
            // reload table
            this.getPegawai()
                
            if(type === 'insert') {
                this.alert.text = this.lang.staff_insert_success 
                $('#tambahPegawaiModal').modal('hide')
            } else if(type === 'edit') {
                this.alert.text = this.lang.staff_update_success   
                $('#editPegawaiModal').modal('hide')                     
            } else {
                this.alert.text = this.lang.staff_delete_success                
            }

            this.alert.header = this.lang.sukses
            this.alert.class = 'bg-success'
            this.alert.show = true

            // set priority to normal by re-running iCheck
            //obj.runICheck()
            
            setTimeout(() => {
                this.runICheck('blue')            
            }, 500);  

            setTimeout(() => {
                this.alert.show = false
                this.alert.header = ''
                this.alert.class = 'bg-primary'
                this.alert.text = ''
            }, 3500);
        },


    },

    watch: {
        data: function() {
            this.checkAll = false
            this.staff = []
        }
    }
})