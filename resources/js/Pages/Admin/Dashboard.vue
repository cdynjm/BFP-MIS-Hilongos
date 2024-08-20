<script setup>

import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';

const props = defineProps({ 
    auth: Array,
    pending: Number,
    scheduled: Number,
    archive: Number,
    fireIncident: Number,
    pendingID: String,
    scheduledID: String,
    archiveID: String,
    fireIncidentAnalytics: Array,
    year: Number
});

const searchForm = useForm({
    search: null,
    result: 0,
});

const years = Array.from({ length: 2040 - 2023 + 1 }, (_, i) => 2023 + i);
searchForm.search = '';

const searchYear = () => {
    searchForm.get(route('admin.search-year-dashboard'));
};

const countIncidentsPerMonth = (analytics) => {
    const incidentsPerMonth = {};
    const allMonths = [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];

    allMonths.forEach(month => {
        incidentsPerMonth[month] = 0;
    });

    analytics.forEach((incident) => {
        const date = new Date(incident.date);
        const month = date.toLocaleString('default', { month: 'short' });
        incidentsPerMonth[month]++;
    });

    return incidentsPerMonth;
};

const incidentsCount = countIncidentsPerMonth(props.fireIncidentAnalytics);

const chartOptions = ref({
    chart: {
        title: {
            text: 'Fire Incidents Per Month',
            align: 'center',
        },
    },
    stroke: {
        curve: 'smooth'
    },
    colors: ['#FF0000'],
    xaxis: {
        categories: Object.keys(incidentsCount),
    },
    tooltip: {
        y: {
            formatter: function (value) {
                return Math.floor(value);
            }
        }
    },
});

const chartSeries = ref([
    {
        name: 'Fire Incidents',
        data: Object.values(incidentsCount).map(Math.floor),
    },
]);

</script>

<template>
    <div class="container-scroller">

     <Navbar :page="'Dashboard'"/>

     <div class="container-fluid page-body-wrapper">

     <Sidebar />

     <div class="main-panel">
          <div class="content-wrapper">
              <div class="row">
                <div class="col-md-4">
                    <form action="" @submit.prevent="searchYear">
                        <div class="d-flex justify-content-between aligh-items-center mb-4">
                            <select v-model="searchForm.search" id="year" class="form-control mr-4 " style="border-radius: 5px;" required>
                                <option value="">Select Year ...</option>
                                <option v-for="year in years" :key="year" :value="year">
                                    {{ year }}
                                </option>
                            </select>
                            <button
                                class="btn btn-success ms-3 d-flex justify-content-center align-items-center shadow-md">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-8"></div>
                  <div class="col-md-3 mb-4">
                    <div class="card rounded-md">
                          <div class="card-body shadow-md">
                              <div class="row">
                                  <div class="col-3">
                                      <div class="avatar-md bg-gradient">
                                        <i class="fa-solid fa-fire text-warning" style="font-size: 45px;"></i>
                                      </div>
                                  </div> <!-- end col -->
                                  <div class="col-9 text-end">
                                      <p class="text-muted mb-0 text-truncate">Fire Incident <b class="text-primary">{{ year }}</b></p>
                                      <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{ fireIncident }}</h3>
                                  </div> <!-- end col -->
                              </div> <!-- end row-->
                          </div> <!-- end card body -->
                      </div> <!-- end card -->
                  </div>

                  <div class="col-md-3 mb-4">
                    <Link :href="route('admin.inspections', { id: pendingID })" class="nav-link p-0">
                    <div class="card rounded-md">
                          <div class="card-body shadow-md">
                              <div class="row">
                                  <div class="col-3">
                                      <div class="avatar-md bg-gradient">
                                        <i class="fa-solid fa-hourglass-half text-danger" style="font-size: 40px;"></i>
                                      </div>
                                  </div> <!-- end col -->
                                  <div class="col-9 text-end">
                                      <p class="text-muted mb-0 text-truncate">Pending Inspections</p>
                                      <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{ pending }}</h3>
                                  </div> <!-- end col -->
                              </div> <!-- end row-->
                          </div> <!-- end card body -->
                      </div> <!-- end card -->
                    </Link>
                  </div>

                  <div class="col-md-3 mb-4">
                    <Link :href="route('admin.inspections', { id: scheduledID })" class="nav-link p-0">
                    <div class="card rounded-md">
                          <div class="card-body shadow-md">
                              <div class="row">
                                  <div class="col-3">
                                      <div class="avatar-md bg-gradient">
                                        <i class="fa-solid fa-calendar-check text-info" style="font-size: 45px;"></i>
                                      </div>
                                  </div> <!-- end col -->
                                  <div class="col-9 text-end">
                                      <p class="text-muted mb-0 text-truncate">Scheduled Inspections</p>
                                      <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{ scheduled }}</h3>
                                  </div> <!-- end col -->
                              </div> <!-- end row-->
                          </div> <!-- end card body -->
                      </div> <!-- end card -->
                    </Link>
                  </div>
                  <div class="col-md-3 mb-4">
                    <Link :href="route('admin.inspections', { id: archiveID })" class="nav-link p-0">
                    <div class="card rounded-md">
                        <div class="card-body shadow-md">
                            <div class="row">
                                <div class="col-3">
                                    <div class="avatar-md bg-gradient">
                                        <i class="fa-solid fa-box-open text-success"
                                            style="font-size: 40px;"></i>
                                    </div>
                                </div> <!-- end col -->
                                <div class="col-9 text-end">
                                    <p class="text-muted mb-0 text-truncate">Archives</p>
                                    <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{
                                        archive }}</h3>
                                </div> <!-- end col -->
                            </div> <!-- end row-->
                        </div> <!-- end card body -->
                    </div> <!-- end card -->
                    </Link>
                </div>

                <div class="col-md-12 mt-2">
                    <div class="card rounded-md">
                        <div class="card-header">
                            <b>Data Analytics for Fire Incidents <span class="text-primary">{{ year }}</span></b>
                        </div>
                        <div class="card-body shadow-md">
                            <apexchart
                                type="line"
                                :options="chartOptions"
                                :series="chartSeries"
                                height="350"
                                />
                        </div>
                    </div>
                 </div>
              </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <Footer></Footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
    </div>
      <!-- page-body-wrapper ends -->
</div>
</template>
