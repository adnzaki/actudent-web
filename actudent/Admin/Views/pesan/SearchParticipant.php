            <div :class="['chat_list', activeChat(item.user_id, 'search')]" v-for="(item, index) in participant" 
              :key="index" v-if="helper.searchParticipant" @click="selectParticipant(item.user_id)">
              <div class="chat_people">
                <div class="chat_ib">
                  <h5>{{ item.user_name }}</h5>
                </div>
              </div>
            </div>