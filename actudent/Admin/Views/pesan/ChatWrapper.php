<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading" id="chat-title">
              <h4 v-if="helper.showChatList">{+ lang AdminPesan.page_title +}</h4>
              <h4 v-else class="cursor-pointer" @click="showChatList">{+ lang Admin.kembali +}</h4>
            </div>
            <fieldset v-if="helper.showChatList">
                <div class="input-group">
                    <input type="text" class="form-control" v-model="cariPengguna" 
                    aria-describedby="button-addon2" @keyup="searchParticipant" 
                    placeholder="{+ lang AdminPesan.pesan_cari_pengguna +}" />
                </div>
            </fieldset>  
          </div>
          <div class="inbox_chat" v-if="helper.showChatList">
            <div :class="['chat_list', activeChat(item.id)]" v-for="(item, index) in chatList" 
              :key="index" @click="getMessages(item.id, limit, 0)" v-if="helper.existParticipant"
              :id="'chat-list-' + item.id">
              <div class="chat_people">
                <div class="chat_ib">
                  <h5>{{ item.recipient }} 
                    <span class="chat_date ac-chat-date"> {{ item.datetime }} </span>
                    <span class="chat_date ac-chat-action">
                      <button type="button" class="btn btn-icon btn-outline-danger"
                          data-toggle="tooltip" data-placement="top" title="{+ lang Admin.hapus +}"
                          @click="deleteConfirm(item.id, item.recipient)">
                          <i class="la la-trash"></i>
                      </button>
                    </span>
                    
                  </h5>
                  <p>{{ item.latest_chat }}</p>
                </div>
              </div>
            </div>
            {+ include Actudent\Admin\Views\pesan\SearchParticipant +}
          </div>
        </div>
        <div class="mesgs" v-if="helper.showChat">
          <div :class="['msg_history', chatWrapper]" id="ac-chat-container">
            <button type="button" class="btn btn-info load-more" 
              @click="loadMoreChat" v-if="helper.loadMore">{+ lang AdminPesan.pesan_muat_lebih +}
            </button>
            <div v-for="(item, index) in chats" :key="index" :id="'chat-' + index">
              <div class="incoming_msg" v-if="item.sender !== userID">
                <div class="received_msg">
                  <div class="received_withd_msg">
                    <p> {{ item.content }} </p>
                    <span class="time_date"> {{ item.time }} | {{ item.date }}</span></div>
                </div>
              </div>
              <div class="outgoing_msg" v-else>
                <div class="sent_msg">
                  <p> {{ item.content }} </p>
                  <span class="time_date"> {{ item.time }} | {{ item.date }}</span> </div>
              </div>
            </div>
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" id="chat-box" v-model="messageText" v-if="!helper.sendingProgress"
              placeholder="{+ lang AdminPesan.ketik_pesan +}" @keyup.enter="sendMessage" />
              <!-- If message is being sent, display this element! -->
              <input type="text" class="write_msg" v-else
              placeholder="{+ lang AdminPesan.pesan_progress_kirim +}" disabled />
              <button class="msg_send_btn" type="button" @click="sendMessage">
                <i class="la la-send" aria-hidden="true"></i>
              </button>
            </div>
          </div>
        </div>
        {+ include Actudent\Admin\Views\pesan\BlankWrapper +}
      </div>
      
      
      <!-- <p class="text-center top_spac"> Design by <a target="_blank" href="#">Sunil Rajput</a></p> -->
      
    </div>