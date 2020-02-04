/**
 * Actudent Data Siswa scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const ortu = new Vue({
    el: '#ortu-content',
    mixins: [SSPaging, plugin],
    data: {
        ortu: `${admin}orang-tua/`,
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        helper: {
            disableSaveButton: false,
            showSaveButton: true, showDeleteButton: false,
        },
        searchParam: '', searchTimeout: false,
        searchResultWrapper: false,
        selectedUser: { text: '', data: '' }, 
        users: [], userCheck: true, showSelectedUser: false,
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getOrtu() 
            setTimeout(() => {
                this.runICheck('blue')            
            }, 1000);           
        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminOrtu')
    },
    methods: {
        getOrtu() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'parent_father_name',
                searchBy: 'parent_family_card-parent_father_name-parent_mother_name-parent_phone_number',
                sort: 'ASC',
                search: '',
                url: `${this.ortu}get-ortu/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        },
        save(edit = false, id = null) {
            let url, form
            let obj = this
            if(edit) {
                url = `${this.ortu}save/${id}`
                form = $('#formEditOrtu')
            } else {
                url = `${this.ortu}save`
                form = $('#formTambahOrtu')
            }

            let data = form.serialize()
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {
                    obj.alert.text = obj.lang.ortu_save_progress
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
                        obj.alert.text = obj.lang.ortu_error_text

                        // hide after 3000 ms and change the class and text to default
                        setTimeout(() => {
                            obj.alert.show = false
                            obj.alert.class = 'bg-primary'
                            obj.alert.header = ''
                            obj.alert.text = obj.lang.ortu_save_progress
                        }, 3000);
                    } else {
                        if(edit) {
                            obj.resetForm(form, 'edit')
                        } else {
                            obj.resetForm(form, 'insert')
                        }
                    }
                },
                error: () => console.error('Network error')
            })
        },
        resetForm(form, type) {
            this.alert.show = false
            // clear error messages if exists
            this.error = {}

            // hide selected user text
            this.showSelectedUser = false

            // reset form
            form.trigger('reset')

            this.getOrtu()
                
            if(type === 'insert') {
                this.alert.text = this.lang.ortu_insert_success 
                $('#tambahOrtuModal').modal('hide')
            } else if(type === 'edit') {
                this.alert.text = this.lang.ortu_update_success   
                $('#editOrtuModal').modal('hide')                     
            } else {
                this.alert.text = this.lang.ortu_delete_success
            }
            this.alert.show = true
            
            setTimeout(() => {
                this.runICheck('blue')            
            }, 500);  

            setTimeout(() => {
                this.alert.show = false
            }, 3500);
        },
        selectUser(userID) {
            $.ajax({
                url: `${this.ortu}set-user/${userID}`,
                type: 'get',
                dataType: 'json',
                beforeSend: () => {
                    this.showSelectedUser = false
                },
                success: res => {
                    this.showSelectedUser = true
                    this.searchResultWrapper = false
                    this.clearResult()
                    if(res.msg === 'OK') {
                        this.userCheck = true
                        this.selectedUser.data = res.data
                        this.selectedUser.text = `${res.data.user_name} (${res.data.user_email})`
                    } else {
                        this.userCheck = false
                        this.selectedUser.text = res.msg
                    }
                }
            })
        },
        searchUser() {
            // open the result wrapper
            this.searchResultWrapper = true
            
            // prevent request until searchTimeout is true
            if(!this.searchTimeout) {
                this.searchTimeout = true
                // wait for 300ms before processing request to server
                setTimeout(() => {
                    let keyword
                    if(this.searchParam === '') {
                        keyword = ''
                        this.users = []
                    } else {
                        keyword = `/${this.searchParam}`
                    }
                    $.ajax({
                        url: `${this.ortu}search-user${keyword}`,
                        type: 'get',
                        dataType: 'json',
                        success: data => {
                            this.users = data
                        }
                    })
                    // turn back searchTimeout to false
                    this.searchTimeout = false
                }, 300)
            }
        },
        clearResult() {
            this.searchResultWrapper = false 
            this.searchParam = ''
            this.users = []
        },
    }
})