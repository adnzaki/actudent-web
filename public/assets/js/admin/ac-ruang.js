/**
 * Actudent Data Ruang scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const ruang = new Vue({
    el: '#ruang-content', 
    mixins: [SSPaging, plugin],
    data: {
        mapel: `${admin}ruang/`,
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
        this.getLanguageResources('AdminRuang')
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