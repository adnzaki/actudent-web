/**
 * Actudent Data Kelas scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

import { SSPaging } from '../ss-paging.js'

const kelas = new Vue({
    el: '#kelas-content',
    mixins: [SSPaging, plugin],
    data: {
        kelas : `${admin}kelas/`,
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
        searchParam: '', searchTimeout: false,
        searchResultWrapper: false,
        teachers: [], 
        selectedTeacher: {
            id: '', name: '',
        },
        gradeWrapper: [],
        gradePagingOptions: {
            limit: 10, offset: 0, orderBy: 'grade_name',
            sort: 'ASC', search: '',
        },
        detailKelas: {},
        studentGroup: [],
        activeGroup: '',
        gradeName: '',
        addMemberProgress: false,
        spinner: false,

        // Class group to be deleted
        classGroup: '',
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getKelas(this.gradePagingOptions)
        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminKelas')
        this.onModalClose('#editKelasModal')
    },
    methods: {
        getKelas(options) {
            this.getData({
                lang: bahasa,
                limit: options.limit,
                offset: options.offset,
                orderBy: options.orderBy,
                searchBy: 'grade_name',
                sort: options.sort,
                search: options.search,
                url: `${this.kelas}get-kelas/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
                autoReset: { active: true, timeout: 1000 }
            })
        },
        getDetailKelas(id) {
            this.error = {}
            $('#editKelasModal').modal('show')
            $.ajax({
                url: `${this.kelas}detail/${id}`,
                type: 'get',
                dataType: 'json',
                success: res => {
                    this.detailKelas = res
                    this.selectedTeacher.id = res.teacher_id
                    this.selectedTeacher.name = res.staff_name
                }
            })
        },
        save(edit = false, id = null) {
            let url, form
            let obj = this
            if(edit) {
                url = `${this.kelas}save/${id}`
                form = $('#formEditKelas')
            } else {
                url = `${this.kelas}save`
                form = $('#formTambahKelas')
            }
            let data = form.serialize()
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {
                    obj.alert.header = ''
                    obj.alert.text = obj.lang.kelas_save_progress
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
                        obj.alert.text = obj.lang.kelas_save_error

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
        deleteConfirm(gradeID) {
            this.classGroup = gradeID
            $('#hapusModal').modal('show')
        },
        deleteGrade() {
            $.ajax({
                url: `${this.kelas}/delete/${this.classGroup}`,
                type: 'POST',
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
        resetForm(type, form = '') {
            this.alert.show = false
            // clear error messages if exists
            this.error = {}

            // reset form
            if(form !== '') {
                form.trigger('reset')
            }

            this.selectedTeacher = {
                id: '', name: ''
            }

            // reload table
            this.runPaging()
                
            if(type === 'insert') {
                this.alert.text = this.lang.kelas_insert_success 
                $('#tambahKelasModal').modal('hide')
            } else if(type === 'edit') {
                this.alert.text = this.lang.kelas_edit_success
                $('#editKelasModal').modal('hide')                     
            } else {
                this.alert.text = this.lang.kelas_delete_success                
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
        addGroupMember(id) {
            $.ajax({
                url: `${this.kelas}add-member/${id}/${this.activeGroup}`,
                type: 'post',
                dataType: 'json',
                beforeSend: () => {
                    this.addMemberProgress = true
                },
                success: () => {
                    this.resetGroupDisplay()
                }
            })
        },
        removeGroupMember(id) {
            $.ajax({
                url: `${this.kelas}remove-member/${id}`,
                type: 'post',
                dataType: 'json',
                beforeSend: () => {
                    this.addMemberProgress = true
                },
                success: () => {
                    this.resetGroupDisplay()
                }
            })
        },
        emptyGroup() {
            $.ajax({
                url: `${this.kelas}empty-group/${this.activeGroup}`,
                type: 'post',
                dataType: 'json',
                beforeSend: () => {
                    this.addMemberProgress = true
                },
                success: () => {                    
                    this.resetGroupDisplay()
                }
            })
        },
        resetGroupDisplay() {
            let t0 = performance.now();

            this.getUnregisteredStudents()
            this.getAnggotaRombel(this.activeGroup) 

            let t1 = performance.now();
                                    
            setTimeout(() => {
                this.addMemberProgress = false
            }, (t1-t0));
        },
        showAnggotaRombel(id, name) {
            $('#anggotaRombel').modal('show')
            this.gradeWrapper = this.data
            this.gradePagingOptions = {
                limit: this.limit, offset: this.offset,
                orderBy: this.orderBy, sort: this.sort,
                search: this.search
            }

            this.activeGroup = id
            this.gradeName = name
            this.getUnregisteredStudents()
            this.getAnggotaRombel(id)
        },
        getUnregisteredStudents() {
            this.reset()
            this.getData({
                lang: bahasa,
                limit: 25,
                offset: 0,
                orderBy: 'student_name',
                searchBy: 'student_name',
                sort: 'ASC',
                search: '',
                url: `${this.kelas}get-siswa/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        },
        getAnggotaRombel(id) {
            $.ajax({
                url: `${this.kelas}get-member/${id}`,
                type: 'get',
                dataType: 'json',
                success: res => {
                    this.studentGroup = res
                }
            })
        },
        closeAnggotaRombel() {
            this.data = []
            this.gradeWrapper = []
            this.getKelas(this.gradePagingOptions) 
            this.spinner = true
            $('#anggotaRombel').modal('hide')                
            setTimeout(() => {
                this.spinner = false
            }, 1200); 
        },
        searchTeacher() {
            // prevent request until searchTimeout is true
            if(!this.searchTimeout) {
                this.searchTimeout = true
                // wait for 300ms before processing request to server
                setTimeout(() => {
                    let keyword
                    if(this.searchParam === '') {
                        keyword = ''
                        this.teachers = []
                    } else {
                        keyword = `/${this.searchParam}`
                    }
                    $.ajax({
                        url: `${this.kelas}cari-guru${keyword}`,
                        type: 'get',
                        dataType: 'json',
                        success: data => {
                            // open the result wrapper
                            if(data === null) {
                                this.searchResultWrapper = false
                                this.teachers = []
                            } else {
                                this.searchResultWrapper = true
                                this.teachers = data
                            }
                        }
                    })
                    // turn back searchTimeout to false
                    this.searchTimeout = false
                }, 300)
            }
        },
        selectTeacher(value) {
            this.selectedTeacher.id = value.staff_id
            this.selectedTeacher.name = value.staff_name
            this.clearResult()
        },
        clearResult() {
            this.searchResultWrapper = false 
            this.searchParam = ''
            this.teachers = []
        },
        onModalClose(target) {
            let obj = this
            $(target).on('hidden.bs.modal', function() {
                obj.selectedTeacher = {
                    id: '', name: '',
                }
            })
        },
    },
})