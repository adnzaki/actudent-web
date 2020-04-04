/**
 * Actudent Data Mapel scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const mapel = new Vue({
    el: '#mapel-content', 
    mixins: [SSPaging, plugin],
    data: {
        mapel: `${admin}mapel/`,
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
        lessonDetail: [],
        lessonCode: '', lessonName: '',
        lessons:[], checkAll: false,
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getMapel()
        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminMapel')
        this.getLanguageResources('Admin')
        this.onModalClose('#hapusModal')
    },
    methods: {
        getMapel() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'lesson_name',
                searchBy: [
                    'lesson_code', 'lesson_name'
                ],
                sort: 'ASC',
                search: '',
                url: `${this.mapel}get-mapel/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        },
        getDetailMapel(id) {
            this.error = {}
            $('#editMapelModal').modal('show')
            $.ajax({
                url: `${this.mapel}detail/${id}`,
                type: 'get',
                dataType: 'json',
                success: res => {
                    this.lessonDetail = res.lesson
                }
            })
        },
        save(edit = false, id = null) {
            let url, form
            let obj = this
            if(edit) {
                url = `${this.mapel}save/${id}`
                form = $('#formEditMapel')
            } else {
                url = `${this.mapel}save`
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
                    obj.alert.text = obj.lang.mapel_save_progress
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
                        obj.alert.text = obj.lang.mapel_error_text

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
        deleteLesson() {
            let idString
            if(this.lessons.length > 1) {
                idString = this.lessons.join('&')
            } else {
                idString = this.lessons[0]
            }

            $.ajax({
                url: `${this.mapel}/delete/${idString}`,
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
        singleDeleteConfirm(lessonID) {
            if(this.lessons.length > 0) {
                this.lessons = []
                this.checkAll = false
            } 

            this.lessons.push(`${lessonID}`)
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
        onModalClose(target) {
            let obj = this
            $(target).on('hidden.bs.modal', function() {
                obj.lessons = []
                obj.checkAll = false
            })
        },
        selectAll() {
            if(this.checkAll) {
                this.data.forEach(item => {
                    this.lessons.push(`${item.lesson_id}`)
                })
            } else {
                this.lessons = []
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

            // reload table
            this.getMapel()
                
            if(type === 'insert') {
                this.alert.text = this.lang.mapel_insert_success 
                $('#tambahMapelModal').modal('hide')
            } else if(type === 'edit') {
                this.alert.text = this.lang.mapel_update_success   
                $('#editMapelModal').modal('hide')                     
            } else {
                this.alert.text = this.lang.mapel_delete_success                
            }

            this.alert.header = this.lang.sukses
            this.alert.class = 'bg-success'
            this.alert.show = true
            
            // setTimeout(() => {
            //     this.runICheck('blue')            
            // }, 500);  

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
            this.lessons = []
        }
    }
})