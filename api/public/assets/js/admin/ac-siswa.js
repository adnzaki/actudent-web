/**
 * Actudent Data Siswa scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

import { SSPaging } from '../ss-paging.js'

const siswa = new Vue({
    el: '#siswa-content',
    mixins: [SSPaging, plugin],
    data: {
        siswa: `${admin}siswa/`,
        studentLimit: '',
        error: { 
            studentNis: '', studentName: '', 
            gradeName: '',
        },
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        helper: {
            disableSaveButton: false,
            showSaveButton: true, showDeleteButton: false,
            deleteProgress: false,
        },
        daftarKelas: '', family: [],
        selectedParent: {
            id: '', father: '', mother: ''
        },
        detailSiswa: {},
        searchParam: '', searchTimeout: false,
        searchResultWrapper: false,
        checkAll: false, students: [],
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getSiswa()            
            this.getKelas()
        }, 200);
        this.runSelect2()
        this.getSiswaByKelas()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminSiswa')
        this.getLanguageResources('Admin')
        this.onModalClose('#editSiswaModal')
        this.studentLimit = studentLimit
    },
    methods: {
        getSiswa() {
            this.getData({
                lang: bahasa,
                limit: 25,
                offset: 0,
                orderBy: 'student_name',
                searchBy: ['student_nis', 'student_name'],
                sort: 'ASC',
                where: null,
                search: '',
                url: `${this.siswa}get-siswa/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
                autoReset: { active: true, timeout: 1000 }
            })
        },
        getSiswaByKelas() {
            let obj = this
            $('#selectGrade').on('select2:select', function (e) {
                var data = e.params.data
                obj.whereClause = data.id
                obj.runPaging()
            })
        },
        getDetailSiswa(id) {
            this.error = {}
            $('#editSiswaModal').modal('show')
            $.ajax({
                url: `${this.siswa}detail/${id}`,
                type: 'get',
                dataType: 'json',
                success: res => {
                    this.detailSiswa = res
                    this.selectedParent.id = res.parent_id
                    this.selectedParent.father = res.parent_father_name
                    this.selectedParent.mother = res.parent_mother_name
                }
            })
        },
        getKelas() {
            $.ajax({
                url: `${this.siswa}get-kelas`,
                dataType: 'json',
                success: data => {
                    this.daftarKelas = data
                }
            })
        },
        save(edit = false, id = null) {
            let url, form
            let obj = this
            if(edit) {
                url = `${this.siswa}save/${id}`
                form = $('#formEditSiswa')
            } else {
                url = `${this.siswa}save`
                form = $('#formTambahSiswa')
            }
            let data = form.serialize()
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {
                    obj.alert.header = ''
                    obj.alert.text = obj.lang.siswa_save_progress
                    obj.alert.show = true
                    obj.helper.disableSaveButton = true
                },
                success: res => {
                    obj.helper.disableSaveButton = false
                    if(res.code === '307') {
                        // set error alert
                        obj.alert.class = 'bg-danger'
                        obj.alert.header = 'Error!'
                        obj.alert.text = res.msg

                        // hide after 3000 ms and change the class and text to default
                        setTimeout(() => {
                            obj.alert.show = false
                            obj.alert.class = 'bg-primary'
                            obj.alert.header = ''
                            obj.alert.text = ''
                        }, 5000);
                    } else {
                        if(res.code === '500') {
                            obj.error = res.msg
    
                            // set error alert
                            obj.alert.class = 'bg-danger'
                            obj.alert.header = 'Error!'
                            obj.alert.text = obj.lang.siswa_save_error
    
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
                    }
                },
                error: () => console.error('Network error')
            })
        },
        deleteStudent() {
            let idString
            if(this.students.length > 1) {
                idString = this.students.join('-')
            } else {
                idString = this.students[0]
            }

            $.ajax({
                url: `${this.siswa}/delete`,
                type: 'POST',
                data: { id: idString },
                dataType: 'json',
                beforeSend: () => {
                    this.helper.deleteProgress = true
                    this.helper.disableSaveButton = true
                },
                success: () => {
                    $('#hapusModal').modal('hide')
                    this.resetForm('delete')
                    setTimeout(() => {
                        this.helper.disableSaveButton = false
                        this.helper.deleteProgress = false                        
                    }, 1000);
                }
            })
        },
        singleDeleteConfirm(studentID) {
            if(this.students.length > 0) {
                this.students = []
                this.checkAll = false
            } 

            this.students.push(studentID)
            $('#hapusModal').modal('show')
        },
        multiDeleteConfirm() {
            if(this.students.length === 0) {
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
        selectAll() {
            if(this.checkAll) {
                this.data.forEach(item => {
                    this.students.push(item.student_id)
                })
            } else {
                this.students = []
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

            this.selectedParent = {
                id: '', father: '', mother: ''
            }

            // reload table
            this.runPaging()
                
            if(type === 'insert') {
                this.alert.text = this.lang.siswa_save_success 
                $('#tambahSiswaModal').modal('hide')
            } else if(type === 'edit') {
                this.alert.text = this.lang.siswa_update_success
                $('#editSiswaModal').modal('hide')                     
            } else {
                this.alert.text = this.lang.siswa_delete_success                
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
        selectParent(value) {
            this.selectedParent.id = value.parent_id
            this.selectedParent.father = value.parent_father_name
            this.selectedParent.mother = value.parent_mother_name
            this.clearResult()
        },
        searchFamily() {                       
            // prevent request until searchTimeout is true
            if(!this.searchTimeout) {
                this.searchTimeout = true
                // wait for 300ms before processing request to server
                setTimeout(() => {
                    let keyword
                    if(this.searchParam === '') {
                        keyword = ''
                        this.family = []
                    } else {
                        keyword = `/${this.searchParam}`
                    }
                    $.ajax({
                        url: `${this.siswa}cari-ortu${keyword}`,
                        type: 'get',
                        dataType: 'json',
                        success: data => {
                            // open the result wrapper
                            if(data === null) {
                                this.searchResultWrapper = false
                                this.family = []
                            } else {
                                this.searchResultWrapper = true
                                this.family = data
                            }
                        }
                    })
                    // turn back searchTimeout to false
                    this.searchTimeout = false
                }, 300)
            }
        },
        showAddForm() {
            if(this.studentLimit === 'allowed') {
                $('#tambahSiswaModal').modal('show')
            } else {
                $('#limitModal').modal('show')
            }
        },
        clearResult() {
            this.searchResultWrapper = false 
            this.searchParam = ''
            this.family = []
        },
        onModalClose(target) {
            let obj = this
            $(target).on('hidden.bs.modal', function() {
                obj.selectedParent = {
                    id: '', father: '', mother: ''
                }
            })
        },
    },
    watch: {
        searchParam: function() {
            if(this.searchParam === '') {
                this.searchResultWrapper = false 
            }
        }
    }
})