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
                <form class="form" id="formTambahAgenda">
                    <div class="form-body">                        
                        <div class="form-group">
                            <label for="userinput5">{{ lang.agenda_label_nama }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.agenda_input_nama" name="student_nis">
                            <form-error :msg="error.studentNis" />
                        </div>
                        <div class="form-group">
                            <label>{{ lang.agenda_label_start }}</label>
                            <div class="input-group">
                                <input type='text' class="form-control border-primary pickadate-selectors" :placeholder="lang.agenda_input_start"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text border-primary">
                                        <span class="la la-calendar-o"></span>
                                    </span>
                                </div>
                            </div>                            
                            <form-error :msg="error.studentName" />                            
                        </div>
                        <div class="form-group">
                            <label>{{ lang.agenda_label_end }}</label>
                            <div class="input-group">
                                <input type='text' class="form-control border-primary pickadate-selectors" :placeholder="lang.agenda_input_end"
                                />
                                <div class="input-group-append">
                                    <span class="input-group-text border-primary">
                                        <span class="la la-calendar-o"></span>
                                    </span>
                                </div>
                            </div> 
                            <form-error :msg="error.familyCard" />
                        </div>
                        <div class="form-group mt-1">
                            <input type="checkbox" id="switcherySize2" class="switchery"/>
                            <label for="switcherySize2">{{ lang.agenda_label_allday }}</label>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-primary">
                                                <span class="ft-clock"></span>
                                            </span>
                                        </div>
                                        <input type='text' class="form-control border-primary pickatime" :placeholder="lang.agenda_label_timestart" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-primary">
                                                <span class="ft-clock"></span>
                                            </span>
                                        </div>
                                        <input type='text' class="form-control border-primary pickatime" :placeholder="lang.agenda_label_timeend" />
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label for="userinput6">{{ lang.agenda_label_desc }}</label>
                            <textarea class="form-control border-primary" type="text" :placeholder="lang.agenda_input_desc" name="parent_mother_name"></textarea>
                            <form-error :msg="error.motherName" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.agenda_label_loc }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.agenda_input_loc" name="parent_phone_number">
                            <form-error :msg="error.phone" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.agenda_label_guest }} </label>
                            <div class="row add-margin-bottom-5px">
                                <div class="col-12">
                                    <div class="badge badge-primary add-margin-right-5px add-margin-top-5px
                                    cursor-pointer" 
                                    v-for="tamu in guestToDisplay">
                                        {{ tamu.name }} <strong @click="removeGuest(tamu)"><i class="la la-close font-medium-2"></i></strong>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <input class="form-control border-primary" type="text" v-model="searchParam" 
                                @focus="searchResultWrapper = true"
                                :placeholder="lang.agenda_input_guest" name="parent_phone_number" @keyup="searchGuest">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" 
                                    @click="clearResult">{{ lang.agenda_close_result }}</button>
                                </div>
                                
                            </div>                            
                            <div class="list-group list-group-custom add-margin-top-5px" v-if="searchResultWrapper">
                            	<a href="#" class="list-group-item active list-group-item-custom">
                            		Semua
                            	</a>
                                <a href="#" class="list-group-item list-group-item-action
                                list-group-item-custom" @click="pushAll('wali_kelas')">
                                    Semua Wali Kelas "{{ searchParam }}"
                                </a>
                                <a href="#" class="list-group-item list-group-item-action 
                                list-group-item-custom" @click="pushAll('wali_murid')">
                                    Semua Wali Murid "{{ searchParam }}"
                                </a>
                                <a href="#" class="list-group-item active">
                            		Daftar Wali Kelas "{{ searchParam }}"
                                </a>
                                <a href="#" class="list-group-item list-group-item-action 
                                list-group-item-custom"
                                v-for="guru in guests.wali_kelas" @click="pushGuest(guru)">
                                    {{ guru.text }}
                                </a>
                                <a href="#" class="list-group-item active 
                                list-group-item-custom">
                            		Daftar Wali Murid "{{ searchParam }}"
                            	</a>
                                <a href="#" class="list-group-item list-group-item-action 
                                list-group-item-custom"
                                v-for="ortu in guests.wali_murid" @click="pushGuest(ortu)">
                                    {{ ortu.text }}
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
                <button type="button" class="btn btn-outline-primary" @click="filterGuest"> {+ lang Admin.simpan +}</button>
                <button type="button" class="btn btn-outline-success"> {+ lang Admin.simpan_tutup +}</button>
            </div>
        </div>
    </div>
</div>
