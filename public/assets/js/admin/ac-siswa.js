/**
 * Actudent Data Siswa scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const siswa = new Vue({
    el: '#siswa-content',
    mixins: [SSPaging],
    data: {
        siswa: `${admin}SiswaController/`,
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getSiswa(0, '')            
        }, 200);
    },
    methods: {
        getSiswa(offset, search) {
            this.getData({
                limit: 1,
                offset: offset,
                orderBy: 'studentName',
                searchBy: 'studentNis-studentName-gradeName',
                sort: 'DESC',
                search: search,
                url: `${this.siswa}getDataSiswa/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        }
    }
})