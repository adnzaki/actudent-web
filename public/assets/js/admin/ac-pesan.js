/**
 * Actudent message scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2020
 */

const pesan = new Vue({
    el: '#pesan-content',
    mixins: [SSPaging, plugin],
    data: {
        error: {},
        alert: {
            class: 'bg-primary', show: false,
            header: '', text: '',
        },
        helper: {
            disableSaveButton: false,
            showSaveButton: true, showDeleteButton: false,
            deleteProgress: false, showChat: false,
            showChatList: true, chatUserID: '',
            sendingProgress: false, disableAutoScroll: false,
            loadMore: false, showChatDate: true,
            searchParticipant: false, existParticipant: true,
            userID: '',
        },
        spinner: false,
        chatList: [], chats: [], messageText: '',
        limit: 25, cariPengguna: '',
        participant: [],
    },
    mounted() {
        this.runSelect2()
        this.getLanguageResources('AdminPesan')
        this.getLanguageResources('Admin')
        this.getChatList()
        this.chatReloader()
    },
    methods: {
        chatReloader() {
            // 5 minutes interval for production
            let interval = 1000 * 60 * 5
            setInterval(() => {
                this.getChatList()
                if(this.helper.chatUserID !== '' && this.helper.chatUserID !== 0) {
                    this.getMessages(this.helper.chatUserID, this.limit, 0, 'loadNew')
                    //this.helper.disableAutoScroll = true
                    setTimeout(() => {
                        $.ajax({
                            url: `${this.pesan}baca-pesan/${this.helper.chatUserID}`,
                            dataType: 'json',
                            success: () => {}
                        })
                    }, 500);
                }
            }, 5000); // for development, we use 5000ms (5 seconds) of interval
        },
        selectParticipant(userID) {
            $.ajax({
                url: `${this.pesan}/pilih-pengguna/${userID}`,
                dataType: 'json',
                success: res => {
                    this.helper.userID = userID
                    this.getMessages(res, this.limit, 0, 'loadAll')

                    // hide load more button if there is no chat
                    if(res === 0) {
                        this.helper.loadMore = false
                    }
                }
            })
        },
        searchParticipant() {
            if(this.cariPengguna !== '') {
                this.helper.existParticipant = false
                this.helper.searchParticipant = true
                setTimeout(() => {
                    $.ajax({
                        url: `${this.pesan}cari-pengguna/${this.cariPengguna}`,
                        dataType: 'json',
                        success: data => {
                            this.participant = data
                        }
                    })
                }, 500);
            } else {
                this.helper.searchParticipant = false
                this.helper.existParticipant = true
                setTimeout(() => {
                    this.getChatList()
                    if(this.helper.chatUserID === '' || this.helper.chatUserID === 0) {
                        this.helper.showChat = false
                    }
                }, 1000);
            }
        },
        getChatList() {
            $.ajax({
                url: `${this.pesan}chat-list`,
                type: 'get',
                success: data => {
                    this.chatList = data
                }
            })
        },
        getMessages(chatUserID, limit, offset, event = 'loadAll', afterSent = false) {
            $.ajax({
                url: `${this.pesan}get-chat/${chatUserID}/${limit}/${offset}/${event}`,
                type: 'get',
                beforeSend: () => {
                    if(this.isSmallScreen) {
                        this.helper.showChatList = false
                    }
                    this.helper.showChat = true                    
                },
                success: data => {
                    let msg = data.chats
                    if(event === 'loadAll' && !afterSent) {
                        this.chats = msg.reverse()
                        this.helper.disableAutoScroll = false                        
                    } else if(event === 'loadNew' && !afterSent) {
                        if(msg.length > 0) {
                            // activate auto scroll if there is new message
                            this.helper.disableAutoScroll = false
                            msg.forEach(item => {
                                this.chats.push(item)
                            })
                        } else {
                            // if there is no new message, do not activate auto scroll
                            this.helper.disableAutoScroll = true
                        }
                    } else if(event === 'loadMore' && !afterSent) {
                        if(msg.length > 0) {
                            msg.forEach(item => {
                                this.chats.unshift(item)
                            })
                        }
                    } else if(event === 'loadAll' && afterSent) {
                        this.chats.push(msg[0])
                        $('#chat-list-' + this.helper.chatUserID).click()
                    }

                    this.helper.chatUserID = chatUserID

                    if(event !== 'loadMore' && !this.helper.disableAutoScroll) {
                        setTimeout(() => {
                            let el = document.getElementById('ac-chat-container')   
                            el.scroll({ top: 1000 * this.chats.length, behavior: "smooth" })                        
                        }, 500);
                    }

                    this.chatboxFocus()

                    // show/hide load more button
                    if(this.chats.length < data.rows) {
                        this.helper.loadMore = true
                    } else {
                        this.helper.loadMore = false
                    }                    
                }
            })  
        },
        loadMoreChat() {
            this.getMessages(this.helper.chatUserID, 10, this.chats.length, 'loadMore')
            this.helper.disableAutoScroll = true
        },
        sendMessage() {
            // only send message if it is not an empty string              
            if(this.messageText !== '') {
                let request = { 
                    text: this.messageText ,
                    recipient: this.helper.userID
                }

                $.ajax({
                    url: `${this.pesan}kirim-pesan/${this.helper.chatUserID}`,
                    type: 'POST',
                    dataType: 'json',
                    data: request,
                    beforeSend: () => {
                        this.helper.sendingProgress = true
                        this.helper.disableAutoScroll = false
                    },
                    success: res => {
                        this.helper.chatUserID = res.chatUser
                        this.getMessages(this.helper.chatUserID, 1, 0, 'loadAll', true)
                        this.messageText = ''
                        this.helper.userID = ''
                        this.getChatList()
                        this.helper.sendingProgress = false
                        this.chatboxFocus()
                        this.cariPengguna = ''
                        this.helper.searchParticipant = false
                        this.helper.existParticipant = true                        
                    }
                })
            }
        },
        activeChat(id, type = 'exist') {
            if(type === 'exist') {
                return (id === this.helper.chatUserID) ? 'active_chat' : ''
            } else {
                return (id === this.helper.userID) ? 'active_chat' : ''
            }
        },
        chatboxFocus() {
            if(!this.isSmallScreen) {
                let chatbox = document.getElementById('chat-box')
                chatbox.focus()
            }
        },
        showChatList() {
            this.chats = []
            this.helper.showChat = false
            this.helper.showChatList = true
            this.helper.chatUserID = ''
            let el = document.getElementById('chat-title')
            el.scrollIntoView()
        }
    },
    computed: {    
        pesan() {
            if(actudentSection === 'admin') {
                return `${admin}pesan/`
            } else {
                return `${guru}pesan/`
            }
        },
        userID() {
            return userID
        },
        chatWrapper() {
            let chatClass = 'chat-override'
            if(navigator.userAgent.indexOf('Chrome') !== -1) {
                chatClass = `webkit-${chatClass}`
            }

            return chatClass
        },
        blankWrapper() {
            let blankClass = 'blank-wrapper'
            if(navigator.userAgent.indexOf('Chrome') !== -1) {
                blankClass = `webkit-${blankClass}`
            }

            return blankClass
        }
    },
})