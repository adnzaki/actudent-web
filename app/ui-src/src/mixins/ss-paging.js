/**
 * Smartscore Pagination
 * Sebuah paket library untuk mengolah data pagination
 *
 * @package     Pagination
 * @author      Adnan Zaki
 * @type        Libraries
 * @version     2.2.1
 * @url         https://wolestech.com
 */

const SSPaging = {
  data() {
    return {
      pageLinks: [], limit: 10, offset: 0, prev: 0,
      next: 0, first: 0, last: 0, setStart: 0, totalRows: 0,
      numLinks: true, activeClass: 'active', linkClass: 'item',
      showPaging: true, search: '', data: [],
      orderBy: '', searchBy: '', sort: 'ASC', whereClause: '',
      url: '', ascendingSort: false, linkNum: false, rows: 10, // custom limit
      token: '',

      // Delay runPaging() on search filter
      // Useful when you use v-on:keyup directive,
      // if set to true, it won't send any request to server
      // directly when user is typing keywords
      delay: {
        active: false,
        timeout: 500
      },

      // auto reset data to its default 
      // if search input is empty string
      autoReset: {
        active: false,
        timeout: 3000
      },

      sentences: {
        indonesia: {
          noData: 'Tidak ada data yang ditampilkan',
          showRows: 'Menampilkan baris',
          from: 'dari',
          rows: 'baris',
        },
        english: {
          noData: 'No data to display',
          showRows: 'Showing row',
          from: 'from',
          rows: 'rows',
        }
      },
      pagingLang: '',
    }

  },
  methods: {
    /**
     * Method for excetuing getData() to avoid incorrect
     * offset calculation after insert or update data
     * 
     * @return void
     */
    execGetData() {
      let start = this.offset / this.limit
      var exec = num => {
        this.offset = num
        this.runPaging()
      }
      exec(start)
      setTimeout(() => {
        if (this.data.length === 0) {
          start -= 1
          exec(start)
        }
      }, 500)
    },
    /**
     * Method for navigating the page
     * 
     * @param {int} page 
     * 
     * @return void
     */
    nav(page) {
      this.offset = page
      this.runPaging()
    },
    /**
     * Search data based on parameters in the search box
     * 
     * @return void
     */
    filter() {
      let timeout
      (this.delay.active) ? timeout = this.delay.timeout : timeout = 0
      setTimeout(() => {
        this.offset = 0
        this.runPaging()
      }, timeout);
    },
    /**
     * Refresh data
     * 
     * @return void
     */
    reloadData() {
      this.offset = (this.activePage - 1)
      this.runPaging()
    },
    /**
     * Method for sorting data based on table's field
     * 
     * @param {string} orderBy 
     * 
     * @return void
     */
    sortData(orderBy) {
      (this.sort === 'ASC') ? this.ascendingSort = true : this.ascendingSort = false
      if (this.ascendingSort) {
        this.ascendingSort = false
        this.sort = 'DESC'
      } else {
        this.ascendingSort = true
        this.sort = 'ASC'
      }
      this.orderBy = orderBy
      this.runPaging()
    },
    /**
     * Option to show number of data per page
     * 
     * @return void
     */
    showPerPage() {
      this.limit = parseInt(this.rows)
      this.offset = 0
      this.runPaging()
    },
    /**
     * Method for excecuting getData() based on current state
     * like limit, offset and filter
     * 
     * @return void
     */
    runPaging() {
      this.getData({
        token: this.token,
        lang: this.pagingLang,
        limit: this.limit,
        offset: this.offset,
        orderBy: this.orderBy,
        searchBy: this.searchBy,
        sort: this.sort,
        where: this.whereClause,
        search: this.search,
        url: this.url,
        linkNum: this.linkNum,
        activeClass: this.activeClass,
        linkClass: this.linkClass,
        autoReset: {
          active: this.autoReset.active,
          timeout: this.autoReset.timeout
        },
        delay: {
          active: this.delay.active,
          timeout: this.delay.timeout
        }
      })
    },
    /**
     * Get data for pagination
     * Options: limit, offset, url, orderBy, searchBy, sort, 
     *          search, linkNum, activeClass, linkClass
     * 
     * @param {object} options 
     * 
     * @return void
     */
    getData(options) {
      this.token = options.token
      this.pagingLang = options.lang
      this.url = options.url
      this.limit = options.limit
      this.offset = options.offset * options.limit
      this.orderBy = options.orderBy

      // options.searchBy could be a string or array
      typeof options.searchBy === 'string' ?
        this.searchBy = options.searchBy :
        this.searchBy = options.searchBy.join('-')

      this.sort = options.sort
      this.search = options.search
      let searchParam
      this.search === '' ? searchParam = '' : searchParam = '/' + this.search
      options.where === undefined ? this.whereClause = '' : this.whereClause = options.where

      let baseURL = `${options.url}${this.limit}/${this.offset}/${this.orderBy}/${this.searchBy}/${this.sort}`,
        requestURL

      this.whereClause === '' ?
        requestURL = `${baseURL}${searchParam}` :
        requestURL = `${baseURL}/${this.whereClause}${searchParam}`

      if (options.autoReset !== undefined) {
        this.autoReset.active = options.autoReset.active
        if (options.autoReset.timeout !== undefined) {
          this.autoReset.timeout = options.autoReset.timeout
        }
      }

      if (options.delay !== undefined) {
        this.delay.active = options.delay.active
        if (options.delay.timeout !== undefined) {
          this.delay.timeout = options.delay.timeout
        }
      }

      fetch(requestURL, {
        method: 'GET',
        mode: 'cors',
        headers: {
          Authorization: options.token ?? ''
        }
      })
        .then(response => response.json())
        .then(data => {
          this.data = data.container
          this.create({
            rows: data.totalRows,
            start: options.offset,
            linkNum: options.linkNum ?? this.linkNum,
            activeClass: options.activeClass ?? this.activeClass,
            linkClass: options.linkClass ?? this.linkClass
          })
        })
        .catch((error) => {
          console.error('Error:', error)
        })
    },
    /**
     * Generate Pagination
     * 
     * @param {object} settings 
     * @param #settings.rows, setting.start, settings.activeClass, settings.linkClass, settings.linkNum
     * 
     * @return void
     */
    create(settings) {
      this.totalRows = settings.rows
      this.activeClass = settings.activeClass
      this.linkClass = settings.linkClass
      this.linkNum = settings.linkNum
      // reset links
      this.pageLinks = []

      // hitung jumlah halaman yang dibutuhkan untuk link pagination
      let countLink = settings.rows / this.limit
      countLink = Math.ceil(countLink)

      // deklarasi nomor awal link
      let startLink

      // cek apakah akan menampilkan nomor link (1, 2, 3 dst.) atau tidak
      if (settings.linkNum === false) {
        this.numLinks = false
      }

      // generate startLink...
      if (settings.linkNum > countLink || settings.linkNum < 1) {
        startLink = 1
      } else {
        if (settings.linkNum % 2 !== 0) {
          startLink = settings.linkNum - 1
        } else {
          startLink = settings.linkNum
        }
        startLink = this.activePage - (startLink / 2)
        if (startLink < 1) {
          startLink = 1
        }
      }

      // generate link pagination....
      for (let i = startLink; i <= countLink; i++) {
        this.pageLinks.push(i)
        if (this.pageLinks.length === settings.linkNum) {
          break;
        }
      }

      // halaman terakhir sama dengan jumlah link
      this.last = countLink

      // generate link halaman sebelumnya dan selanjutnya
      settings.start === (this.last -= 1) ? this.next = settings.start : this.next = settings.start + 1
      settings.start === this.first ? this.prev = settings.start : this.prev = settings.start - 1
    },
    /**
     * Method for marking active link
     * 
     * @param {number} link 
     * 
     * @return string
     */
    activeLink(link) {
      if (link === this.activePage) {
        return this.activeClass
      } else {
        return ''
      }
    },
    /**
     * Reset pagination into default value 
     * 
     * @return void
     */
    reset() {
      this.data = []
      this.pageLinks = []
      this.limit = 10
      this.offset = 0
      this.prev = 0
      this.next = 0
      this.first = 0
      this.last = 0
      this.setStart = 0
      this.totalRows = 0
    }
  },
  computed: {
    /**
     * Get active page
     * 
     * @return int
     */
    activePage() {
      return ((this.offset / this.limit) + 1)
    },
    /**
     * Get the last data range
     * 
     * @return int
     */
    dataTo() {
      let currentPage = this.offset / this.limit,
        range
      if (this.pageLinks.length === 0) {
        range = 0
      } else {
        if (currentPage === this.last) {
          range = this.totalRows
        } else {
          range = this.offset + this.limit
        }
      }

      return range
    },
    /**
     * Get the first data range 
     * 
     * @return void
     */
    dataFrom() {
      let from
      if (this.pageLinks.length === 0) {
        from = 0
      } else {
        if (this.offset === 0) {
          from = 1
        } else {
          from = this.offset + 1
        }
      }

      return from
    },
    /**
     * Generate data range
     * 
     * @return string
     */
    rowRange() {
      if (this.pageLinks.length === 0) {
        this.showPaging = false

        // handle error on undefined
        return (this.sentences[this.pagingLang] === undefined) ? '' : this.sentences[this.pagingLang].noData
      } else {
        this.showPaging = true
        return `${this.sentences[this.pagingLang].showRows} ${this.dataFrom} - 
                ${this.dataTo} ${this.sentences[this.pagingLang].from} ${this.totalRows} 
                ${this.sentences[this.pagingLang].rows}`
      }
    }
  },
  watch: {
    search: function () {
      if (this.search === '' && this.autoReset.active) {
        setTimeout(() => {
          this.offset = 0
          this.runPaging()
        }, this.autoReset.timeout)
      }
    }
  }
}

export default SSPaging
