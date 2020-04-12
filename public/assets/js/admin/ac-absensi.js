/**
 * Actudent Data Absensi scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const mapel = new Vue({
    el: '#Absensi-content', 
    mixins: [SSPaging, plugin],
    data: {
        mapel: `${admin}absensi/`,
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
        // lessonDetail: [],
        // lessonCode: '', lessonName: '',
        // lessons:[], checkAll: false,
    },
    mounted() {
        this.reset()
        // setTimeout(() => {
        //     this.getMapel()
        // }, 200);
        // this.runSelect2()
        // this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminAbsensi')
        this.getLanguageResources('Admin')
        // this.onModalClose('#hapusModal')
    },
    methods: {

    },
    // watch: {
    //     data: function() {
    //         this.checkAll = false
    //         this.lessons = []
    //     }
    // }

})