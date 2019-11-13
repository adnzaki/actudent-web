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
    },
    mounted() {
        this.getLanguageResources('AdminAgenda')
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
    }
 })