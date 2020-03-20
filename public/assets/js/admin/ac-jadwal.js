/**
 * Actudent Schedules scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2020
 */

const jadwal = new Vue({
    el: '#jadwal-content',
    mixins: [SSPaging, plugin],
    data: {
        jadwal: `${admin}jadwal/`,
        kelas : `${admin}kelas/`,
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        helper: {
            disableSaveButton: false,
            showSaveButton: true, showDeleteButton: false,
            deleteProgress: false,
            showDaftarKelas: true,
            showDaftarMapel: false,
            showJadwalMapel: false,
        },
        lessonList: [],
        spinner: false,
        cardTitle: '',
        checkAll: false, lessons: [],
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getKelas()
        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        let t0 = performance.now()
        this.getLanguageResources('AdminJadwal')
        this.getLanguageResources('AdminKelas')
        let t1 = performance.now()
        setTimeout(() => {
            this.cardTitle = this.lang.jadwal_title            
        }, (t1-t0));
    },
    methods: {
        getKelas() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'grade_name',
                searchBy: 'grade_name',
                sort: 'ASC',
                search: '',
                url: `${this.kelas}get-kelas/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
                autoReset: { active: true, timeout: 1000 }
            })
        },
        showMapel(grade) {
            $.ajax({
                url: `${this.jadwal}daftar-mapel/${grade}`,
                type: 'get',
                dataType: 'json',
                beforeSend: () => {
                    this.helper.showDaftarKelas = false
                    this.spinner = true
                },
                success: data => {
                    if(data.lessons !== undefined) {
                        this.lessonList = data.lessons
                    }
                    setTimeout(() => {
                        this.spinner = false
                        this.helper.showDaftarMapel = true     
                        this.cardTitle = this.lang.jadwal_daftar_mapel        
                    }, 800);
                }
            })
        },
        closeMapel() {
            this.helper.showDaftarMapel = false
            this.lessonList = []
            this.spinner = true
            setTimeout(() => {
                this.spinner = false
                this.helper.showDaftarKelas = true  
                this.cardTitle = this.lang.jadwal_title
                setTimeout(() => {
                    this.runSelect2() 
                    this.select2ShowPerPage('#showRows')
                }, 300)         
            }, 500)
        },
        selectAll() {

        },
    },
})      