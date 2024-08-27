<script setup>

import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';

const props = defineProps({
    auth: Array,
    scheduled: Number,
    archive: Number,
    fireIncident: Number,
    scheduledID: String,
    archiveID: String,
    fireIncidentAnalytics: Array,
    year: Number
})

const searchForm = useForm({
    search: null,
    result: 0,
});

const years = Array.from({ length: 2040 - 2023 + 1 }, (_, i) => 2023 + i);
searchForm.search = '';

const searchYear = () => {
    searchForm.get(route('personnel.search-year-dashboard'));
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

const countFireAlarmLevels = (analytics) => {
    const alarmLevelsCount = {
        1: 0, // First Alarm
        2: 0, // Second Alarm
        3: 0, // Third Alarm
        4: 0, // Fourth Alarm
        5: 0, // Fifth Alarm
        6: 0, // Task Force Alpha
        7: 0, // Task Force Bravo
        8: 0, // Task Force Charlie
        9: 0, // Task Force Delta
        10: 0 // General Alarm
    };

    analytics.forEach((incident) => {
        const level = incident.fireAlarmLevel;
        if (level >= 1 && level <= 10) {
            alarmLevelsCount[level]++;
        }
    });

    return alarmLevelsCount;
};

const fireAlarmLevelCounts = countFireAlarmLevels(props.fireIncidentAnalytics);

const fireAlarmChartOptions = ref({
    chart: {
        title: {
            text: 'Fire Alarm Levels Count',
            align: 'center',
        },
    },
    xaxis: {
        categories: [
            'First Alarm', 'Second Alarm', 'Third Alarm', 'Fourth Alarm',
            'Fifth Alarm', 'Task Force Alpha', 'Task Force Bravo',
            'Task Force Charlie', 'Task Force Delta', 'General Alarm'
        ],
    },
    colors: ['#FF0000'],
    tooltip: {
        y: {
            formatter: function (value) {
                return Math.floor(value);
            }
        }
    },
});

const fireAlarmChartSeries = ref([
    {
        name: 'Total Count ',
        data: Object.values(fireAlarmLevelCounts).map(Math.floor),
    },
]);

</script>

<template>
    <div class="container-scroller">

        <Navbar :page="'Dashboard'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">

                        <div class="col-md-4">
                            <form action="" @submit.prevent="searchYear">
                                <div class="d-flex justify-content-between aligh-items-center mb-4">
                                    <select v-model="searchForm.search" id="year" class="form-control mr-4"
                                        style="border-radius: 5px;" required>
                                        <option value="">Select Year ...</option>
                                        <option v-for="year in years" :key="year" :value="year">
                                            {{ year }}
                                        </option>
                                    </select>
                                    <button
                                        class="btn btn-dark btn-sm ms-3 d-flex justify-content-center align-items-center shadow-md rounded-md">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-8"></div>

                        <div class="col-md-4 mb-4">
                            <Link :href="route('personnel.fire-incident')" class="nav-link p-0">
                            <div class="card rounded-md">
                                <div class="card-body shadow-md">
                                    <div class="row">

                                        <div class="col-9 text-end">
                                            <p class="text-muted mb-0 text-truncate">Fire Incident <b
                                                    class="text-primary">{{ year }}</b></p>
                                            <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{
                                                fireIncident }} <span class="text-muted ml-1"
                                                    style="font-size: 12px; font-weight: normal;"><i
                                                        class="fa-solid fa-circle-info text-warning"></i> More Info
                                                </span> <i class="fa-solid fa-chart-simple text-primary ml-1"></i></h3>
                                        </div> <!-- end col -->
                                        <div class="col-3">
                                            <div class="avatar-md bg-gradient">
                                                <iconify-icon icon="solar:fire-bold-duotone" width="50" height="50"
                                                    class="text-warning"></iconify-icon>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-md-12">
                                            <hr class="mt-3">
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end card body -->
                            </div> <!-- end card -->
                            </Link>
                        </div>

                        <div class="col-md-4 mb-4">
                            <Link :href="route('personnel.inspections', { id: scheduledID })" class="nav-link p-0">
                            <div class="card rounded-md">
                                <div class="card-body shadow-md">
                                    <div class="row">

                                        <div class="col-9 text-end">
                                            <p class="text-muted mb-0 text-truncate">Scheduled Inspections</p>
                                            <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{
                                                scheduled }} <span class="text-muted ml-1"
                                                    style="font-size: 12px; font-weight: normal;"><i
                                                        class="fa-solid fa-circle-info text-info"></i> More Info</span>
                                            </h3>
                                        </div> <!-- end col -->
                                        <div class="col-3">
                                            <div class="avatar-md bg-gradient">
                                                <iconify-icon icon="uim:schedule" width="50" height="50"
                                                    class="text-info"></iconify-icon>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-md-12">
                                            <hr class="mt-3">
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end card body -->
                            </div> <!-- end card -->
                            </Link>
                        </div>
                        <div class="col-md-4 mb-4">
                            <Link :href="route('personnel.inspections', { id: archiveID })" class="nav-link p-0">
                            <div class="card rounded-md">
                                <div class="card-body shadow-md">
                                    <div class="row">

                                        <div class="col-9 text-end">
                                            <p class="text-muted mb-0 text-truncate">Archives</p>
                                            <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{
                                                archive }} <span class="text-muted ml-1"
                                                    style="font-size: 12px; font-weight: normal;"><i
                                                        class="fa-solid fa-circle-info text-success"></i> More
                                                    Info</span></h3>
                                        </div> <!-- end col -->
                                        <div class="col-3">
                                            <div class="avatar-md bg-gradient">
                                                <iconify-icon icon="solar:inbox-archive-bold" width="50" height="50"
                                                    class="text-success"></iconify-icon>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-md-12">
                                            <hr class="mt-3">
                                        </div>
                                    </div> <!-- end row-->
                                </div> <!-- end card body -->
                            </div> <!-- end card -->
                            </Link>
                        </div>

                        <div class="col-md-12 mt-2">
                            <div class="card rounded-md mb-4">
                                <div class="card-header">
                                    <b>Data Analytics for Fire Incidents <span class="text-primary">{{ year
                                            }}</span></b>
                                </div>
                                <div class="card-body shadow-md">
                                    <apexchart type="area" :options="chartOptions" :series="chartSeries" height="350" />
                                </div>
                            </div>

                            <div class="card rounded-md">
                                <div class="card-header">
                                    <b>Data Analytics for Fire Alarm Levels <span class="text-primary">{{ year
                                            }}</span></b>
                                </div>
                                <div class="card-body shadow-md">
                                    <apexchart type="area" :options="fireAlarmChartOptions"
                                        :series="fireAlarmChartSeries" height="350" />
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
