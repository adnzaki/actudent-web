/**
 * Actudent Timeline scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2019
 */

 const timeline = new Vue({
    el: '#timeline-content',
    mixins: [plugin],
    data: {
        timeline: `${admin}timeline/`,
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        posts: [],
        summernoteLang: { 'indonesia': 'id-ID', 'english': 'en-US' },
        postLimit: 10, loadMoreButton: false, spinner: false,
        helper: {
            disableSaveButton: false, fileUploaded: '',
            filename: '', uploadProgress: false, imageURL: `${baseURL}/attachments/timeline/`,
            currentImage: '', timelineID: null, validImage: false,
        },
        timelineDetail: {},
    },
    mounted() {
        this.getLanguageResources('AdminTimeline')
        this.getPosts(this.postLimit, 0)
    },
    methods: {
        evenOrOdd(index) {
            if(index === 1) {
                return 'mt-3'
            }
        },
        getPosts(limit, offset, useSpinner = false, reloadAfterSave = false) {
            $.ajax({
                url: `${this.timeline}get-posts/${limit}/${offset}`,
                type: 'get',
                dataType: 'json',
                success: data => {                    
                    if(data.timeline.length > 0) {
                        if(!reloadAfterSave) {
                            data.timeline.forEach(item => {
                                this.posts.push(item)
                            })
                        } else {
                            this.posts.unshift(data.timeline[0])
                        }
                        
                        if(data.rows === this.posts.length) {
                            this.loadMoreButton = false
                        }
                    } 

                    // hide spinner
                    if(useSpinner) this.spinner = false
                }
            })
            
        },
        getPostDetail(timelineID, forReload = false) {
            this.validateFile('update-file')
            $.ajax({
                url: `${this.timeline}get-detail/${timelineID}`,
                type: 'get',
                dataType: 'json',
                success: data => {                    
                    this.timelineDetail = data                    
                    if(! forReload) {
                        this.helper.validImage = false
                        // filename to be validated
                        this.helper.filename = data.timeline_image

                        // only store current featured image
                        this.helper.currentImage = data.timeline_image

                        // save timelineID
                        this.helper.timelineID = data.timeline_id

                        // show the modal
                        $('#editPostModal').modal('show')
                    }
                }
            })
        },  
        save(status = 'public', id = null) {
            let url, form, uploadSelector
            if(id === null) {
                url = `${this.timeline}simpan/${status}`
                form = $('#formTambahPost')
                uploadSelector = 'upload-file'
            } else {
                url = `${this.timeline}simpan/${status}/${id}`
                form = $('#formEditPost')
                uploadSelector = 'update-file'
            }

            let data = form.serialize()

            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                beforeSend: () => {
                    this.alert.header = ''
                    this.alert.text = this.lang.timeline_save_progress
                    this.alert.show = true
                    this.helper.disableSaveButton = true
                },
                success: res => {
                    this.helper.disableSaveButton = false
                    if(res.code === '500') {
                        this.error = res.msg
                        if(this.helper.filename === '') {
                            this.error.timeline_image = res.msg.image_feature
                        }

                        // set error alert
                        this.alert.class = 'bg-danger'
                        this.alert.header = 'Error!'
                        this.alert.text = this.lang.timeline_error_save

                        // hide after 3000 ms and change the class and text to default
                        setTimeout(() => {
                            this.alert.show = false
                            this.alert.class = 'bg-primary'
                            this.alert.header = ''
                            this.alert.text = ''
                        }, 3000);
                    } else {
                        let obj = this
                        let uploadImage = new Promise((resolve, reject) => {
                            // only do upload if filename and currentImage do not have the same value
                            // for insert event, currentImage will always empty
                            // for update event, both might have the same value and we will ignore file uploading
                            if(obj.helper.filename !== obj.helper.currentImage) {
                                obj.uploadRequest(`${obj.timeline}upload-gambar/${res.id}`, uploadSelector)
                            }
                            // wait 3 seconds
                            setTimeout(resolve, 3000)
                        })

                        function resetForm() {
                            if(id === null) {
                                obj.resetForm('insert', status, form)
                            } else {
                                obj.resetForm('edit', status, form)
                            }                            
                        }

                        uploadImage.then(resetForm)
                    }
                },
                error: () => console.error('Network error')
            })
        },
        resetForm(type, status, form = '') {
            this.alert.show = false
            // clear error messages if exists
            this.error = {}

            // clear filename 
            this.helper.filename = ''

            // reset form
            if(form !== '') {
                form.trigger('reset')
            }

            // reload timeline
            if(type === 'insert') {
                this.getPosts(1, 0, false, true)
            } else if(type === 'edit') {
                // prepare timelineID
                let id = this.helper.timelineID

                // get post detail again
                this.getPostDetail(id, true)

                setTimeout(() => {
                    // find index and replace existing post with the new one
                    // with splice() method
                    index = this.posts.findIndex(el => {
                        return el.timeline_id === id
                    })                
                    this.posts.splice(index, 1, this.timelineDetail)                    
                }, 500);
            }

            if(status === 'public') {
                this.alert.text = this.lang.timeline_save_public
            } else {
                this.alert.text = this.lang.timeline_save_draft
            }

            if(type === 'insert') {
                $('#addPostModal').modal('hide')
            } else if(type === 'edit') {
                $('#editPostModal').modal('hide')                     
            } else {
                this.alert.text = this.lang.timeline_delete_success                
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
        validateFile(formName) {
            let obj = this
            $('input[name=timeline_image]').on('change', function() {
                if(this.error !== undefined) {
                    this.error.timeline_image = ''
                }
                obj.helper.filename = $(this).val()
                obj.uploadRequest(`${obj.timeline}validasi-gambar`, formName, true)
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
        loadMorePosts() {
            this.getPosts(this.postLimit, this.posts.length, true)
        },
        showAddPostModal() {
            this.validateFile('upload-file')
            $('#addPostModal').modal('show')
        },
    }
 })