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
        posts: [],
        summernoteLang: { 'indonesia': 'id-ID', 'english': 'en-US' }
    },
    mounted() {
        this.runSummerNote()            
        this.getLanguageResources('AdminTimeline')
        this.getPosts(10, 0)
    },
    methods: {
        evenOrOdd(index) {
            if(index === 1) {
                return 'mt-3'
            }
        },
        getPosts(limit, offset) {
            $.ajax({
                url: `${this.timeline}get-posts/${limit}/${offset}`,
                type: 'get',
                dataType: 'json',
                success: data => {
                    this.posts = data
                }
            })
        },
        runSummerNote() {
            $('#summernote').summernote({
                height: 250,
                focus: true,
                lang: this.summernoteLang[bahasa],
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['paragraph']],
                    ['insert', ['link']],
                    ['height', ['height']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                codeviewFilter: true,
                codeviewIframeFilter: true
            })

            $('.summernote .modal-header').addClass(`${modalHeaderColor}`)
            $('.summernote .modal-title').addClass('white')
            $('.summernote .note-image-input').removeClass('form-control-file')
            $('.summernote .note-image-input').addClass('form-control')
            $('.summernote .close').removeAttr('data-dismiss')
            $('.summernote .close').on('click', function() { 
                $('.summernote .modal').modal('hide') 
            })
		},
        showAddPostForm() {
            $('#addPostForm').modal('show')
        },
    }
 })