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
            deleteProgress: false,
        },
        parentDetail: [], userEmail: '', domain: '',
        children: [],
        motherName: '', fatherName: '',
        parents: [], checkAll: false,
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getOrtu()                    
        }, 200);
        this.domain = domainSekolah
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminOrtu')
        this.getLanguageResources('Admin')
        this.onModalClose('#hapusModal')
    },
    methods: {
        getOrtu() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'parent_father_name',
                searchBy: [
                    'parent_family_card', 'parent_father_name', 
                    'parent_mother_name', 'parent_phone_number'
                ],
                sort: 'ASC',
                search: '',
                url: `${this.ortu}get-ortu/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        },
        showAddParentForm() {
            setTimeout(() => {
                this.runICheck('blue')            
            }, 500);    
        },
        getDetailOrtu(id) {
            this.error = {}
            $('#editOrtuModal').modal('show')
            $.ajax({
                url: `${this.ortu}detail/${id}`,
                type: 'get',
                dataType: 'json',
                success: res => {
                    this.parentDetail = res.parent
                    this.children = res.children
                }
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
                    obj.alert.header = ''
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
        deleteParent() {
            let idString
            if(this.parents.length > 1) {
                idString = this.parents.join('&')
            } else {
                idString = this.parents[0]
            }

            $.ajax({
                url: `${this.ortu}/delete`,
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
        singleDeleteConfirm(parentID, userID) {
            if(this.parents.length > 0) {
                this.parents = []
                this.checkAll = false
            } 

            this.parents.push(`${parentID}-${userID}`)
            $('#hapusModal').modal('show')
        },
        multiDeleteConfirm() {
            if(this.parents.length === 0) {
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
                obj.parents = []
                obj.checkAll = false
            })
        },
        selectAll() {
            if(this.checkAll) {
                this.data.forEach(item => {
                    this.parents.push(`${item.parent_id}-${item.user_id}`)
                })
            } else {
                this.parents = []
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

            this.fatherName = ''
            this.motherName = ''

            // reload table
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

            this.alert.header = this.lang.sukses
            this.alert.class = 'bg-success'
            this.alert.show = true
            
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
            this.parents = []
        }
    }
})