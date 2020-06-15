/**
 * Actudent "Umpan balik" scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const feedback = new Vue({
    el: '#feedback-content',
    mixins: [SSPaging, plugin],
    data: {
        // feedback: `${admin}umpan-balik/`,
        feedback: {
            app: `${admin}umpan-balik/`,
            user: `${admin}`
        },
    },
    mounted() {        
        this.getLanguageResources('AdminFeedback')
        this.runSelect2()        
        this.runICheck('blue')
    },
    methods: {
        
    },
    computed: {
        
    }
})