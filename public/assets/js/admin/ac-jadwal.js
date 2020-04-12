/**
 * Actudent Schedules scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2020
 */

const jadwal = new Vue({
    el: '#jadwal-content',
    mixins: [SSPaging, plugin],
    data: {
        jadwal: `${admin}jadwal/`,
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
            showDaftarKelas: true,
            showDaftarMapel: false,
            showJadwalMapel: false,
        },
        scheduleList: {},
        lessonList: [], lessonsGradeID: '',
        spinner: false,
        cardTitle: '', gradeID: null,
        checkAll: false, lessons: [],
        searchParam: '', searchTimeout: false,
        searchResultWrapper: false,
        teachers: [], 
        selectedTeacher: {
            id: '', name: '',
        },
        lessonClass: 'card-title lead text-1rem text-bold',
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getKelas()
        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        let t0 = performance.now()
        this.getLanguageResources('AdminJadwal')
        this.getLanguageResources('AdminKelas')
        this.getLanguageResources('Admin')
        let t1 = performance.now()
        setTimeout(() => {
            this.cardTitle = this.lang.jadwal_title            
        }, (t1-t0) + 500);
        this.onModalClose('#editMapelModal')
        this.onModalClose('#hapusModal')
    },
    methods: {
        getKelas() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'grade_name',
                searchBy: 'grade_name',
                sort: 'ASC',
                search: '',
                url: `${this.kelas}get-kelas/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
                autoReset: { active: true, timeout: 1000 }
            })
        },
        saveMapel(edit = false) {
            let url, form
            let obj = this
            if(edit) {
                url = `${this.jadwal}simpan-mapel/${this.lessonsGradeID}`
                form = $('#formEditMapel')
            } else {
                url = `${this.jadwal}simpan-mapel`
                form = $('#formTambahMapel')
            }
            let data = form.serialize()
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {
                    obj.alert.header = ''
                    obj.alert.text = obj.lang.jadwal_save_progress
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
                        obj.alert.text = obj.lang.jadwal_save_error

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
        getDetailMapel(id) {
            this.error = {}
            $.ajax({
                url: `${this.jadwal}detail-mapel/${id}`,
                type: 'get',
                dataType: 'json',
                success: data => {
                    // save ID
                    this.lessonsGradeID = data.lessons_grade_id

                    // create new option set it to be defaul selected value
                    let lesson = new Option(data.lesson_name, data.lesson_id, true, true)
                    $('#mapel-terpilih').append(lesson).trigger('change')

                    // push response to selectedTeacher 
                    this.selectedTeacher.id = data.teacher_id
                    this.selectedTeacher.name = data.teacher

                    // show the modal
                    $('#editMapelModal').modal('show')
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
            this.showMapel(this.gradeID, false)
                
            if(type === 'insert') {
                this.alert.text = this.lang.jadwal_insert_success 
                $('#tambahMapelModal').modal('hide')
            } else if(type === 'edit') {
                this.alert.text = this.lang.jadwal_edit_success
                $('#editMapelModal').modal('hide')                     
            } else {
                this.alert.text = this.lang.jadwal_delete_success                
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
        showJadwal(grade, useSpinner = true) {
            $.ajax({
                url: `${this.jadwal}get-jadwal/${grade}`,
                type: 'get',
                dataType: 'json',
                beforeSend: () => {
                    this.helper.showDaftarKelas = false
                    if(useSpinner) {
                        this.spinner = true
                    }
                },
                success: data => {
                    this.scheduleList = data.schedule   
                    this.gradeID = grade        
                    setTimeout(() => {
                        if(useSpinner) {
                            this.spinner = false
                        }
                        this.helper.showJadwalMapel = true   
                        this.cardTitle = `${this.lang.jadwal_title} ${data.class_name}`
                    }, 800);
                }
            })
            this.helper.showDaftarKelas = false
            this.spinner = true
            setTimeout(() => {
                this.spinner = false
                this.helper.showJadwalMapel = true                
            }, 500);
        },
        showMapel(grade, useSpinner = true) {
            this.select2Ajax(`${this.jadwal}cari-mapel/${grade}`, '#pilih-mapel')
            this.select2Ajax(`${this.jadwal}cari-mapel/${grade}`, '#mapel-terpilih')
            $.ajax({
                url: `${this.jadwal}daftar-mapel/${grade}`,
                type: 'get',
                dataType: 'json',
                beforeSend: () => {
                    this.helper.showDaftarKelas = false
                    if(useSpinner) {
                        this.spinner = true
                    }
                },
                success: data => {
                    this.lessonList = data.lessons    
                    this.gradeID = data.class_id          
                    setTimeout(() => {
                        if(useSpinner) {
                            this.spinner = false
                        }
                        this.helper.showDaftarMapel = true     
                        this.cardTitle = `${this.lang.jadwal_daftar_mapel} ${data.class_name}`
                    }, 800);
                }
            })
        },
        close(section = 'mapel') {
            this.helper.showJadwalMapel = false
            this.helper.showDaftarMapel = false
            this.lessonList = []
            this.scheduleList = []
            this.spinner = true
            if(section === 'mapel') {
                $('#pilih-mapel').select2('destroy')
                $('#mapel-terpilih').select2('destroy')
            }
            setTimeout(() => {
                this.spinner = false
                this.helper.showDaftarKelas = true  
                this.cardTitle = this.lang.jadwal_title
                setTimeout(() => {
                    this.runSelect2() 
                    this.select2ShowPerPage('#showRows')
                }, 300)         
            }, 500)
        },
        deleteLesson() {
            let idString
            if(this.lessons.length > 1) {
                idString = this.lessons.join('-')
            } else {
                idString = this.lessons[0]
            }

            $.ajax({
                url: `${this.jadwal}hapus-mapel`,
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
        singleDeleteConfirm(id) {
            if(this.lessons.length > 0) {
                this.lessons = []
                this.checkAll = false
            } 

            this.lessons.push(id)
            $('#hapusModal').modal('show')
        },
        multiDeleteConfirm() {
            if(this.lessons.length === 0) {
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
                this.lessonList.forEach(item => {
                    this.lessons.push(item.lessons_grade_id)
                })
            } else {
                this.lessons = []
            }
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
                obj.lessons = []
                obj.checkAll = false
                obj.selectedTeacher = {
                    id: '', name: '',
                }
            })
        },
        isBreak(lessonGrade) {
            return (lessonGrade === null) ? 'success-text' : ''
        }
    },
})      