/**
 * Actudent Data Pengguna scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

import { SSPaging } from '../ss-paging.js'

const pengguna= new Vue({
    el: '#pengguna-content',
    mixins: [SSPaging, plugin],
    data: {
        pengguna : `${admin}pengguna/`,
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
        userDetail: [], 
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getPengguna()            
        }, 200);
        this.runSelect2()
        this.getPenggunaByLevel()
        this.select2ShowPerPage('#showRows')
        // this.getLanguageResources('AdminPengguna')        
        this.getLanguageResources('Admin')
        this.getLanguageResources('AdminUser')
    },
    methods: {
        getPengguna() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'user_name',
                searchBy: [ 
                    'user_name', 'user_email'
                ],
                sort: 'ASC',
                where: null,
                search: '',
                url: `${this.pengguna}get-pengguna/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        },
        getPenggunaByLevel() {
            let obj = this
            $('#selectUser').on('select2:select', function (e) {
                var data = e.params.data
                obj.whereClause = data.id
                obj.runPaging()
            })
        },
        getDetailPengguna(id) {
            this.error = {}
            let obj = this
            $('#editPenggunaModal').modal('show')
            $.ajax({
                url: `${this.pengguna}detail/${id}`,
                type: 'get',
                dataType: 'json',
                success: res => {
                    obj.userDetail = res
                    this.userDetail = res.user
                }
            })
        },
        save(id) {
            let url, form
            let obj = this
            url = `${this.pengguna}save/${id}`
            form = $('#formEditPengguna')

            let data = form.serialize()
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {
                    obj.alert.header = ''
                    obj.alert.text = obj.lang.user_save_progress
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
                        obj.alert.text = obj.lang.user_error_text

                        // hide after 3000 ms and change the class and text to default
                        setTimeout(() => {
                            obj.alert.show = false
                            obj.alert.class = 'bg-primary'
                            obj.alert.header = ''
                            obj.alert.text = ''
                        }, 3000);
                    } else {
                        // reset everything
                        obj.resetForm(form)
                    }
                },
                error: () => console.error('Network error')
            })
        },
        resetForm(form = '') {
            this.alert.show = false
            // clear error messages if exists
            this.error = {}

            // reset form
            if(form !== '') {
                form.trigger('reset')
            }

            // reload table
            this.getPengguna()

            this.alert.text = this.lang.user_update_success   
            $('#editPenggunaModal').modal('hide')
            
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

    },
})