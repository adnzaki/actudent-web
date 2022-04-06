<div class="row">
	<div class="col-xl-8 col-12">
		<div class="card normal-card {cardColor}">
			<div class="card-header {cardColor}">
				<h4 class="card-title {cardTitleColor}">{+ lang AdminHome.dashboard_agenda_title +}</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
			</div>
			<div class="card-content collapse show">
				<div class="table-responsive">
					<table class="table table-hover mb-0 cursor-pointer">
            <thead v-if="recentAgenda.length === 0">
              <tr>
                  <th colspan="4">{+ lang AdminHome.dashboard_agenda_empty +}</th>
              </tr>            
            </thead>
						<thead v-else>
							<tr>
								<th class="decrease-col-size">
									#
								</th>
								<th>{+ lang AdminHome.dashboard_agenda_name +}</th>
								<th>{+ lang AdminHome.dashboard_agenda_start +}</th>
								<th>{+ lang AdminHome.dashboard_agenda_end +}</th>
							</tr>
						</thead>
						<tbody v-if="recentAgenda.length > 0">              
							<tr v-for="(item, index) in recentAgenda" :key="index" class="soft-dark" @click="goToAgenda">               
								<td scope="row" class="decrease-col-size">
									{{ index + 1 }}
								</td>
								<td>{{ item.title }}</td>
								<td>{{ item.eventStart | formatDate('DD/MM/YYYY') }} - {{ item.timeStart }} </td>
								<td>{{ item.eventEnd | formatDate('DD/MM/YYYY') }} - {{ item.timeEnd }} </td>
							</tr>              
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
  <div class="col-xl-4 col-12">
		<div class="card normal-card {cardColor}">
			<div class="card-header {cardColor}">
				<h4 class="card-title {cardTitleColor}">{+ lang AdminHome.dashboard_timeline_title +}</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
			</div>
			<div class="card-content collapse show">
				<div class="table-responsive">
					<table class="table table-hover mb-0 cursor-pointer">
						<tbody>
              <tr v-if="recentTimeline.length === 0" >
                <td>{+ lang AdminHome.dashboard_timeline_empty +}</td>
              </tr>
							<tr v-else v-for="(item, index) in recentTimeline" :key="index" class="soft-dark" @click="goToTimeline">
								<td v-if="!isSmallScreen">{{ item.timeline_title | substr(35) }}</td>
                <td v-else>{{ item.timeline_title | substr(50) }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
