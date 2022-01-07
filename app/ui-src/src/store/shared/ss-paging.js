/**
 * Smartscore Pagination for Vuex
 * 
 * Modul ini merupakan bagian dari SSPaging v2.2.1
 * yang dikembangkan khusus untuk memenuhi kebutuhan
 * penggunaan bersama Vuex.
 *
 * @package     Pagination
 * @author      Adnan Zaki
 * @type        Libraries
 * @version     2.2.2
 * @url         https://wolestech.com
 */

 export const SSPaging = {
  state() {
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
      pagingLang: 'indonesia',
    }
  },
  actions: {
    /**
     * Method for excetuing getData() to avoid incorrect
     * offset calculation after insert or update data
     * 
     * @return void
     */
     execGetData({ state, dispatch }) {
      let start = state.offset / state.limit
      var exec = num => {
        state.offset = num
        dispatch('runPaging')
      }
      exec(start)
      setTimeout(() => {
        if (state.data.length === 0) {
          start -= 1
          exec(start)
        }
      }, 500)
    },
    onSearchChanged({ state, dispatch }) {
      if (state.search === '' && state.autoReset.active) {
        setTimeout(() => {
          state.offset = 0
          dispatch('runPaging')
        }, state.autoReset.timeout)
      }
    },
    /**
     * Method for navigating the page
     * 
     * @param {int} page 
     * 
     * @return void
     */
     nav({ state, dispatch }, page) {
      state.offset = page
      dispatch('runPaging')
    },
    /**
     * Search data based on parameters in the search box
     * 
     * @return void
     */
    filter({ state, dispatch }) {
      let timeout
      (state.delay.active) ? timeout = state.delay.timeout : timeout = 0
      setTimeout(() => {
        state.offset = 0
        dispatch('runPaging')
      }, timeout);
    },
    /**
     * Refresh data
     * 
     * @return void
     */
    reloadData({ state, dispatch, getters }) {
      state.offset = (getters.activePage - 1)
      dispatch('runPaging')
    },
    /**
     * Method for sorting data based on table's field
     * 
     * @param {string} orderBy 
     * 
     * @return void
     */
    sortData({ state, dispatch }, orderBy) {
      (state.sort === 'ASC') ? state.ascendingSort = true : state.ascendingSort = false
      if (state.ascendingSort) {
        state.ascendingSort = false
        state.sort = 'DESC'
      } else {
        state.ascendingSort = true
        state.sort = 'ASC'
      }
      state.orderBy = orderBy
      dispatch('runPaging')
    },
    /**
     * Option to show number of data per page
     * 
     * @return void
     */
    showPerPage({ state, dispatch }) {
      state.limit = parseInt(state.rows)
      state.offset = 0
      dispatch('runPaging')
    },
    /**
     * Method for excecuting getData() based on current state
     * like limit, offset and filter
     * 
     * @return void
     */
    runPaging({ state, dispatch }) {
      dispatch('getData', {
        token: state.token,
        lang: state.pagingLang,
        limit: state.limit,
        offset: state.offset,
        orderBy: state.orderBy,
        searchBy: state.searchBy,
        sort: state.sort,
        where: state.whereClause,
        search: state.search,
        url: state.url,
        linkNum: state.linkNum,
        activeClass: state.activeClass,
        linkClass: state.linkClass,
        autoReset: {
          active: state.autoReset.active,
          timeout: state.autoReset.timeout
        },
        delay: {
          active: state.delay.active,
          timeout: state.delay.timeout
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
    getData({ state, dispatch }, options) {
      state.token = options.token
      state.pagingLang = options.lang
      state.url = options.url
      state.limit = options.limit
      state.offset = options.offset * options.limit
      state.orderBy = options.orderBy

      // options.searchBy could be a string or array
      typeof options.searchBy === 'string' ?
        state.searchBy = options.searchBy :
        state.searchBy = options.searchBy.join('-')

      state.sort = options.sort
      state.search = options.search
      let searchParam
      state.search === '' ? searchParam = '' : searchParam = '/' + state.search
      options.where === undefined ? state.whereClause = '' : state.whereClause = options.where

      let baseURL = `${options.url}${state.limit}/${state.offset}/${state.orderBy}/${state.searchBy}/${state.sort}`,
        requestURL

      state.whereClause === '' ?
        requestURL = `${baseURL}${searchParam}` :
        requestURL = `${baseURL}/${state.whereClause}${searchParam}`

      if (options.autoReset !== undefined) {
        state.autoReset.active = options.autoReset.active
        if (options.autoReset.timeout !== undefined) {
          state.autoReset.timeout = options.autoReset.timeout
        }
      }

      if (options.delay !== undefined) {
        state.delay.active = options.delay.active
        if (options.delay.timeout !== undefined) {
          state.delay.timeout = options.delay.timeout
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
          state.data = data.container
          dispatch('create', {
            rows: data.totalRows,
            start: options.offset,
            linkNum: options.linkNum ?? state.linkNum,
            activeClass: options.activeClass ?? state.activeClass,
            linkClass: options.linkClass ?? state.linkClass
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
     create({ state, getters }, settings) {
      state.totalRows = settings.rows
      state.activeClass = settings.activeClass
      state.linkClass = settings.linkClass
      state.linkNum = settings.linkNum

      // reset links
      state.pageLinks = []

      // hitung jumlah halaman yang dibutuhkan untuk link pagination
      let countLink = settings.rows / state.limit
      countLink = Math.ceil(countLink)

      // deklarasi nomor awal link
      let startLink

      // cek apakah akan menampilkan nomor link (1, 2, 3 dst.) atau tidak
      if (settings.linkNum === false) {
        state.numLinks = false
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
        startLink = getters.activePage - (startLink / 2)
        if (startLink < 1) {
          startLink = 1
        }
      }

      // generate link pagination....
      for (let i = startLink; i <= countLink; i++) {
        state.pageLinks.push(i)
        if (state.pageLinks.length === settings.linkNum) {
          break;
        }
      }

      // halaman terakhir sama dengan jumlah link
      state.last = countLink

      // generate link halaman sebelumnya dan selanjutnya
      settings.start === (state.last -= 1) ? state.next = settings.start : state.next = settings.start + 1
      settings.start === state.first ? state.prev = settings.start : state.prev = settings.start - 1
    },
    /**
     * Method for marking active link
     * 
     * @param {number} link 
     * 
     * @return string
     */
    activeLink({ state, getters }, link) {
      if (link === getters.activePage) {
        return state.activeClass
      } else {
        return ''
      }
    },
  },
  mutations: {
    /**
     * Reset pagination into default value 
     * 
     * @return void
     */
    reset(state) {
      state.data = []
      state.pageLinks = []
      state.limit = 10
      state.offset = 0
      state.prev = 0
      state.next = 0
      state.first = 0
      state.last = 0
      state.setStart = 0
      state.totalRows = 0
    }
  },
  getters: {
    /**
     * Create item number based on its position 
     * in whole data
     * 
     * @param {number} index
     * 
     * @return int
     */
    itemNumber: (state, getters) => index => {
      return getters.dataFrom + index
    },
    /**
     * Get active page
     * 
     * @return int
     */
     activePage(state) {
      return ((state.offset / state.limit) + 1)
    },
    /**
     * Get the last data range
     * 
     * @return int
     */
    dataTo(state) {
      let currentPage = state.offset / state.limit,
        range
      if (state.pageLinks.length === 0) {
        range = 0
      } else {
        if (currentPage === state.last) {
          range = state.totalRows
        } else {
          range = state.offset + state.limit
        }
      }

      return range
    },
    /**
     * Get the first data range 
     * 
     * @return void
     */
    dataFrom(state) {
      let from
      if (state.pageLinks.length === 0) {
        from = 0
      } else {
        if (state.offset === 0) {
          from = 1
        } else {
          from = state.offset + 1
        }
      }

      return from
    },
    /**
     * Generate data range
     * 
     * @return string
     */
    rowRange(state, getters) {
      if (state.pageLinks.length === 0) {
        state.showPaging = false

        // handle error on undefined
        return (state.sentences[state.pagingLang] === undefined) ? '' : state.sentences[state.pagingLang].noData
      } else {
        state.showPaging = true
        let returnedText = 'Unable to load rows range.'
        if(state.sentences[state.pagingLang] !== undefined) {
          returnedText = `${state.sentences[state.pagingLang].showRows} ${getters.dataFrom} - 
                          ${getters.dataTo} ${state.sentences[state.pagingLang].from} ${state.totalRows} 
                          ${state.sentences[state.pagingLang].rows}`
        }

        return returnedText
      }
    }
  },
}
