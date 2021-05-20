/**
 * Actudent Data Pegawai scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

import { SSPaging } from '../ss-paging.js'

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
            disableSaveButton: false, fileUploaded: '',
            filename: '', uploadProgress: false, imageURL: `${baseURL}/images/pegawai/`,
            imageBase64: 'data:image/png;base64,',
            currentImage: '', userID: null, validImage: false,
            showSaveButton: true, showDeleteButton: false,
            deleteProgress: false, 
        },
        staffDetail: [], userEmail: '', domain: '',
        staffType:'',     
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
                    'staff_phone', 'staff_title'
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
            this.validateFile('upload-file')
            $('#tambahPegawaiModal').modal('show')            
            
            setTimeout(() => {
                this.runICheck('blue')            
            }, 500);                
        },
        getDetailPegawai(id) {
            this.error = {}
            let obj = this
            obj.validateFile('update-file')
            $('#editPegawaiModal').modal('show')
            $.ajax({
                url: `${this.pegawai}detail/${id}`,
                type: 'get',
                dataType: 'json',
                success: res => {
                    obj.staffDetail = res
                    this.staffDetail = res.staff
                    // filename to be validated
                    this.helper.updateImage = res.staff.staff_photo
                    // only store current featured image
                    this.helper.currentImage = res.staff.staff_photo

                    $(`input#${res.staff.staff_type}`).iCheck('check')

                }
            })            
        },
        save(edit = false, id = null) {
            let url, form, uploadSelector
            let obj = this
            if(edit) {
                url = `${this.pegawai}save/${id}`
                form = $('#formEditPegawai')
                uploadSelector = 'update-file'
            } else {
                url = `${this.pegawai}save`
                form = $('#formTambahPegawai')
                uploadSelector = 'upload-file'
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
                        if(this.helper.filename === '') {
                            this.error.staff_photo = res.msg.image_feature //allow add new data whithout photo
                        }

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
                        // if the form has attachment, upload it
                        // if(hasAttachment) {
                        //     obj.uploadRequest(`${obj.pegawai}upload/${res.id}`, uploadSelector)
                        // }
                        
                        let obj = this
                        let uploadImage = new Promise((resolve, reject) => {
                            // only do upload if filename and currentImage do not have the same value
                            // for insert event, currentImage will always empty
                            // for update event, both might have the same value and we will ignore file uploading
                            if(edit){
                                obj.uploadRequest(`${obj.pegawai}upload/${id}`, uploadSelector)
                            } else {
                                obj.uploadRequest(`${obj.pegawai}upload/${res.id}`, uploadSelector)
                            }
                                
                            // wait 3 seconds
                            setTimeout(resolve, 3000)
                        })

                        function resetForm() {
                            if(edit) {
                                obj.resetForm('edit', form)
                            } else {
                                obj.resetForm('insert', form)
                            }                          
                        }

                        uploadImage.then(resetForm)
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
                url: `${this.pegawai}/delete`,
                type: 'POST',
                data: { id: idString },
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
        validateFile(formName) {
            let obj = this
            $('input[name=staff_photo]').on('change', function() {
                if(this.error !== undefined) {
                    this.error.staff_photo = ''
                }
                obj.helper.filename = $(this).val()
                obj.uploadRequest(`${obj.pegawai}validate-file`, formName, true)
                
                // req.responseType = 'json'
                // this.base64img = response.img
                // var data = data
                // obj.helper.updateImage = data.img
    
            })
            
        },
        uploadRequest(url, formName, validate = false) {
            let form = document.forms.namedItem(formName),
                data = new FormData(form),
                req = new XMLHttpRequest
            
                // disable save button while attachment is being validated
            req.upload.addEventListener("progress", () => {
                this.error = {}
                this.helper.disableSaveButton = true
                this.helper.uploadProgress = true
            })

            req.open('POST', url, true)
            req.responseType = 'json'
            req.onload = obj => {
                this.helper.uploadProgress = false
                if(req.response.msg === 'OK') {
                    this.error = {}
                    this.helper.disableSaveButton = false
                    this.helper.validImage = true
                    this.helper.updateImage = req.response.img
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