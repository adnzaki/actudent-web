<!-- Modal -->
<div class="modal fade text-left" id="agendaModal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.agenda_form_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formTambahAgenda" enctype="multipart/form-data">
                    <div class="form-body">                        
                        <div class="form-group">
                            <label>{{ lang.agenda_label_nama }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.agenda_input_nama" name="agenda_name">
                            <form-error :msg="error.agenda_name" />
                        </div>
                        <div class="row">
                            <div class="col-12"><label>{{ lang.agenda_label_start }}</label></div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 col-sm-7 col-12">
                                <div class="form-group">
                                    <input type="hidden" name="agenda_start" v-model="agendaStart">
                                    <div class="input-group">
                                        <input type='text' name="agendaDateStart"
                                        class="form-control border-primary pickadate-selectors" :placeholder="lang.agenda_input_start" />
                                        <div class="input-group-append">
                                            <span class="input-group-text border-primary">
                                                <span class="la la-calendar-o"></span>
                                            </span>
                                        </div>
                                    </div>                            
                                    <form-error :msg="error.agenda_start" />
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5 col-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-primary">
                                                <span class="ft-clock"></span>
                                            </span>
                                        </div>
                                        <input type='text' name="timestart" :disabled="helper.fullDayEvent"
                                        :class="['form-control border-primary pickatime', timepickerStatus]" :placeholder="fullDayTimeStart" />
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-12"><label>{{ lang.agenda_label_end }}</label></div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 col-sm-7 col-12">
                                <div class="form-group">
                                    <input type="hidden" name="agenda_end" v-model="agendaEnd">
                                    <div class="input-group">
                                        <input type='text' name="agendaDateEnd"
                                        class="form-control border-primary pickadate-selectors" :placeholder="lang.agenda_input_end" />
                                        <div class="input-group-append">
                                            <span class="input-group-text border-primary">
                                                <span class="la la-calendar-o"></span>
                                            </span>
                                        </div>
                                    </div> 
                                    <form-error :msg="error.agenda_end" />
                                </div>
                            </div>
                            <div class="col-md-5 col-sm-5 col-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-primary">
                                                <span class="ft-clock"></span>
                                            </span>
                                        </div>
                                        <input type='text' name="timeend" :disabled="helper.fullDayEvent"
                                        :class="['form-control border-primary pickatime', timepickerStatus]" :placeholder="fullDayTimeEnd" />
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="form-group mt-1">
                            <input type="checkbox" id="allDayEvent" class="switchery"/>
                            <label for="allDayEvent">{{ lang.agenda_label_allday }}</label>
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.agenda_label_desc }}</label>
                            <textarea class="form-control border-primary" type="text" :placeholder="lang.agenda_input_desc" name="agenda_description"></textarea>
                            <form-error :msg="error.agenda_description" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.agenda_label_prior }}</label>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 skin skin-square" id="prioritas">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <fieldset>
                                                <input type="radio" name="agenda_priority" id="high" value="high">
                                                <label>{{ lang.agenda_input_highprior }}</label>
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-4">
                                            <fieldset>
                                                <input type="radio" name="agenda_priority" id="normal" value="normal" checked>
                                                <label>{{ lang.agenda_input_normalprior }}</label>
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-4">
                                            <fieldset>
                                                <input type="radio" name="agenda_priority" id="low" value="low">
                                                <label>{{ lang.agenda_input_lowprior }}</label>
                                            </fieldset>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <form-error :msg="error.agenda_priority" />
                        </div>
                        <div class="form-group">
                            <label>{{ lang.agenda_label_loc }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.agenda_input_loc" name="agenda_location">
                            <form-error :msg="error.agenda_location" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.agenda_label_guest }} </label>
                            <input type="hidden" name="agenda_guest" v-model="guestWrapper">
                            <div class="row add-margin-bottom-5px">
                                <div class="col-12">
                                    <div class="badge badge-primary add-margin-right-5px add-margin-top-5px
                                    cursor-pointer" 
                                    v-for="tamu in guestToDisplay" :key="tamu.id">
                                        {{ tamu.name }} <strong @click="removeGuest(tamu)"><i class="la la-close font-medium-2"></i></strong>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <input class="form-control border-primary" type="text" v-model="searchParam" 
                                @focus="searchResultWrapper = true"
                                :placeholder="lang.agenda_input_guest" @keyup="searchGuest">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" 
                                    @click="clearResult">{{ lang.agenda_close_result }}</button>
                                </div>
                                
                            </div>                            
                            <div class="list-group list-group-custom add-margin-top-5px" v-if="searchResultWrapper">
                            	<a href="javascript:void()" class="list-group-item active list-group-item-custom">
                            		Semua
                            	</a>
                                <a href="javascript:void()" class="list-group-item list-group-item-action
                                list-group-item-custom" @click="pushAll('wali_kelas')">
                                    Semua Wali Kelas "{{ searchParam }}"
                                </a>
                                <a href="javascript:void()" class="list-group-item list-group-item-action 
                                list-group-item-custom" @click="pushAll('wali_murid')">
                                    Semua Wali Murid "{{ searchParam }}"
                                </a>
                                <a href="javascript:void()" class="list-group-item active">
                            		Daftar Wali Kelas "{{ searchParam }}"
                                </a>
                                <a href="javascript:void()" class="list-group-item list-group-item-action 
                                list-group-item-custom"
                                v-for="guru in guests.wali_kelas" @click="pushGuest(guru)">
                                    {{ guru.text }}
                                </a>
                                <a href="javascript:void()" class="list-group-item active 
                                list-group-item-custom">
                            		Daftar Wali Murid "{{ searchParam }}"
                            	</a>
                                <a href="javascript:void()" class="list-group-item list-group-item-action 
                                list-group-item-custom"
                                v-for="ortu in guests.wali_murid" @click="pushGuest(ortu)">
                                    {{ ortu.text }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="form-group">
                    <label>{{ lang.agenda_label_att }}</label>
                    <form action="" name="upload-file" method="post" enctype="multipart/form-data">
                        <input class="form-control border-primary" type="file" name="agenda_attachment">
                    </form>
                    <form-error :msg="error.agenda_attachment" />
                </div>
                <alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
                <button type="button" class="btn btn-outline-primary" @click="save"> {+ lang Admin.simpan +}</button>
                <button type="button" class="btn btn-outline-success"> {+ lang Admin.simpan_tutup +}</button>
            </div>
        </div>
    </div>
</div>
