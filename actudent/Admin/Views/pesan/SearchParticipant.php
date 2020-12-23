            <div :class="['chat_list soft-dark', activeChat(item.user_id, 'search')]" v-for="(item, index) in participant" 
              :key="index" v-if="helper.searchParticipant" @click="selectParticipant(item.user_id)">
              <div class="chat_people">
                <div class="chat_ib">
                  <h5 class="{cardTitleColor}">{{ item.user_name }} ({{ item.user_level }}) </h5>
                </div>
              </div>
            </div>