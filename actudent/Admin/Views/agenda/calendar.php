<div class="card-content collapse show">
    <div class="card-body expand-card-body">
        <div class="row">         
            <div class="col-12">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-info" 
                        @click="showAddAgendaForm">{+ lang Admin.tambah +}
                    </button>
                </div>
            </div>
        </div>
        <transition :enter-active-class="transitionClass.enter" :leave-active-class="transitionClass.leave">
            <div v-if="fullCalendar.show">
                <div id="fc-agenda-views"></div>                    
            </div>
        </transition>
    </div>
</div>