/**
 * Actudent Data Ruang scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

import { SSPaging } from '../ss-paging.js'

const ruang = new Vue({
    el: '#ruang-content', 
    mixins: [SSPaging, plugin],
    data: {
        ruang: `${admin}ruang/`,
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
        roomDetail: [],
        roomCode: '', roomName: '',
        rooms:[], checkAll: false,
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getRuang()
        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminRuang')
        this.getLanguageResources('Admin')
        this.onModalClose('#hapusModal')
    },
    methods: {
        getRuang() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'room_name',
                searchBy: [
                    'room_code', 'room_name'
                ],
                sort: 'ASC',
                search: '',
                url: `${this.ruang}get-ruang/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        },
        getDetailRuang(id) {
            this.error = {}
            $('#editRuangModal').modal('show')
            $.ajax({
                url: `${this.ruang}detail/${id}`,
                type: 'get',
                dataType: 'json',
                success: res => {
                    this.roomDetail = res.room
                }
            })
        },
        save(edit = false, id = null) {
            let url, form
            let obj = this
            if(edit) {
                url = `${this.ruang}save/${id}`
                form = $('#formEditRuang')
            } else {
                url = `${this.ruang}save`
                form = $('#formTambahRuang')
            }

            let data = form.serialize()
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {
                    obj.alert.header = ''
                    obj.alert.text = obj.lang.ruang_save_progress
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
                        obj.alert.text = obj.lang.ruang_error_text

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
        deleteRoom() {
            let idString
            if(this.rooms.length > 1) {
                idString = this.rooms.join('&')
            } else {
                idString = this.rooms[0]
            }

            $.ajax({
                url: `${this.ruang}/delete/${idString}`,
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
        singleDeleteConfirm(roomID) {
            if(this.rooms.length > 0) {
                this.rooms = []
                this.checkAll = false
            } 

            this.rooms.push(`${roomID}`)
            $('#hapusModal').modal('show')
        },
        multiDeleteConfirm() {
            if(this.rooms.length === 0) {
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
                obj.rooms = []
                obj.checkAll = false
            })
        },
        selectAll() {
            if(this.checkAll) {
                this.data.forEach(item => {
                    this.rooms.push(`${item.room_id}`)
                })
            } else {
                this.rooms = []
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
            this.getRuang()
                
            if(type === 'insert') {
                this.alert.text = this.lang.ruang_insert_success 
                $('#tambahRuangModal').modal('hide')
            } else if(type === 'edit') {
                this.alert.text = this.lang.ruang_update_success   
                $('#editRuangModal').modal('hide')                     
            } else {
                this.alert.text = this.lang.ruang_delete_success                
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
            this.rooms = []
        }
    }

})