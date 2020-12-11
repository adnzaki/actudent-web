<div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>{+ lang AdminPesan.page_title +}</h4>
            </div>
            <fieldset>
                <div class="input-group">
                    <input type="text" class="form-control" aria-describedby="button-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button">Go</button>
                    </div>
                </div>
            </fieldset>  
          </div>
          <div class="inbox_chat">
            <div class="chat_list" v-for="(item, index) in chatList" :key="index">
              <div class="chat_people">
                <div class="chat_ib">
                  <h5>{{ item.recipient }} 
                    <span class="chat_date"> {{ item.datetime }} </span>
                  </h5>
                  <p>{{ item.latest_chat }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="mesgs">
          <div class="msg_history">
            <div class="incoming_msg">
              <div class="received_msg">
                <div class="received_withd_msg">
                  <p>Test which is a new approach to have all
                    solutions</p>
                  <span class="time_date"> 11:01 AM    |    June 9</span></div>
              </div>
            </div>
            <div class="outgoing_msg">
              <div class="sent_msg">
                <p>Test which is a new approach to have all
                  solutions</p>
                <span class="time_date"> 11:01 AM    |    June 9</span> </div>
            </div>
          </div>
          <div class="type_msg">
            <div class="input_msg_write">
              <input type="text" class="write_msg" placeholder="Type a message" />
              <button class="msg_send_btn" type="button"><i class="la la-send" aria-hidden="true"></i></button>
            </div>
          </div>
        </div>
      </div>
      
      
      <!-- <p class="text-center top_spac"> Design by <a target="_blank" href="#">Sunil Rajput</a></p> -->
      
    </div>