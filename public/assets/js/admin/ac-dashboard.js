/**
 * Actudent "Pengaturan" scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const dashboard = new Vue({
    el: '#dashboard-content',
    mixins: [plugin],
    data: {
        changelogList: [],
    },
    mounted() {
        let split = changelog.split('- ')
        split.forEach(item => {
            this.changelogList.push(item)
        })
        $('#changelog-modal').modal('show')
    },
    methods: {
    },
})