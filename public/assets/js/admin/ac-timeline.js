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
        summernoteLang: { 'indonesia': 'id-ID', 'english': 'en-US' },
        postLimit: 10, loadMoreButton: true
    },
    mounted() {
        this.runSummerNote()            
        this.getLanguageResources('AdminTimeline')
        this.getPosts(this.postLimit, 0)
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
                    if(data.timeline.length > 0) {
                        data.timeline.forEach(item => {
                            this.posts.push(item)
                        })
                        
                        if(data.rows === this.posts.length) {
                            this.loadMoreButton = false
                        }
                    } 
                }
            })
        },
        loadMorePosts() {
            this.getPosts(this.postLimit, this.posts.length)
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