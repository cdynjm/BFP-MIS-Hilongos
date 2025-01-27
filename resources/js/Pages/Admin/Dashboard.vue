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
    year: Number,
    municipal: Array,
    barangay: Object
});

const searchForm = useForm({
    search: null,
    result: 0,
});

const currentYear = new Date().getFullYear();
const startYear = 2020;
const years = Array.from({ length: currentYear - startYear + 1 }, (_, i) => startYear + i);

searchForm.search = '';

const searchYear = () => {
    searchForm.get(route('admin.search-year-dashboard'));
};

const countIncidentsPerMonthWithBarangays = (analytics) => {
    const incidentsPerMonth = {};
    const barangaysPerMonth = {};
    const allMonths = [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];

    // Initialize months
    allMonths.forEach(month => {
        incidentsPerMonth[month] = 0;
        barangaysPerMonth[month] = [];
    });

    analytics.forEach((incident) => {
        const date = new Date(incident.date);
        const month = date.toLocaleString('default', { month: 'short' });
        
        // Count incidents per month
        incidentsPerMonth[month]++;
        
        // Collect barangays for each month, avoiding duplicates
        if (!barangaysPerMonth[month].includes(incident.brgy.brgyDesc)) {
            barangaysPerMonth[month].push(incident.brgy.brgyDesc);
        }
    });

    return { incidentsPerMonth, barangaysPerMonth };
};

const { incidentsPerMonth, barangaysPerMonth } = countIncidentsPerMonthWithBarangays(props.fireIncidentAnalytics);

const chartOptions = ref({
    chart: {
        title: {
            text: 'Fire Incidents Per Month',
            align: 'center',
        },
    },
    stroke: {
        curve: 'smooth',
    },
    colors: ['#FF0000'],
    xaxis: {
        categories: Object.keys(incidentsPerMonth),
    },
    tooltip: {
        custom: function ({ dataPointIndex }) {
            const month = Object.keys(incidentsPerMonth)[dataPointIndex];
            const incidents = Object.values(incidentsPerMonth)[dataPointIndex];
            const barangays = barangaysPerMonth[month];
            
            return `
                <div style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                    <strong style="color: #FF0000;">Fire Incidents: ${incidents}</strong>
                    <div style="margin-top: 5px; font-size: 12px; color: #333;">
                        <strong>Barangays/Location:</strong>
                        <ul style="padding-left: 20px; margin: 5px 0 0;">
                            ${barangays.length > 0 ? barangays.map(brgy => `<li>${brgy}</li>`).join('') : '<li>No Data Record</li>'}
                        </ul>
                    </div>
                </div>
            `;
        },
    },
});

const chartSeries = ref([
    {
        name: 'Fire Incidents',
        data: Object.values(incidentsPerMonth).map(Math.floor),
    },
]);


const countIncidentsPerBarangay = (analytics, barangays) => {
    const incidentsPerBarangay = {};

    // Initialize barangay counts
    Object.values(barangays).forEach((brgy) => {
        incidentsPerBarangay[brgy.brgyDesc] = 0;
    });

    // Count incidents per barangay
    analytics.forEach((incident) => {
        const barangay = Object.values(barangays).find(
            (brgy) => brgy.brgyCode === incident.location
        );
        if (barangay) {
            incidentsPerBarangay[barangay.brgyDesc]++;
        }
    });

    return incidentsPerBarangay;
};

const incidentsPerBarangay = countIncidentsPerBarangay(
    props.fireIncidentAnalytics,
    props.barangay
);

// Split the data into two groups: first 25 and the remaining 26 barangays
const first25Barangays = Object.keys(incidentsPerBarangay).slice(0, 25);
const remainingBarangays = Object.keys(incidentsPerBarangay).slice(25);

const first25Incidents = first25Barangays.map((brgy) => incidentsPerBarangay[brgy]);
const remainingIncidents = remainingBarangays.map((brgy) => incidentsPerBarangay[brgy]);

// Chart Options for the first group (first 25 barangays)
const barangayChartOptionsFirst = ref({
    chart: {
        type: 'bar', // Bar chart
        height: 350,
        toolbar: {
            show: false,
        },
    },
    plotOptions: {
        bar: {
            horizontal: true, // Horizontal bars
            barHeight: '60%', // Adjust bar height
        },
    },
    xaxis: {
        title: {
            text: 'No. of Incidents',
        },
        categories: first25Barangays, // First 25 barangay names
        labels: {
            rotate: -90, // Rotate labels for better readability
        },
    },
   
    dataLabels: {
        enabled: true, // Show data labels
    },
    stroke: {
        width: 2, // Bar border width
    },
    colors: ['#FF0000'], // Red bars
    tooltip: {
        custom: function ({ dataPointIndex }) {
            const barangay = first25Barangays[dataPointIndex];
            const incidents = first25Incidents[dataPointIndex];
            return `
                <div style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                    <strong style="color: #FF0000;">${barangay}</strong>
                    <div style="margin-top: 5px; font-size: 12px; color: #333;">
                        Fire Incidents: <strong>${incidents}</strong>
                    </div>
                </div>
            `;
        },
    },
});

// Chart Options for the second group (remaining 26 barangays)
const barangayChartOptionsSecond = ref({
    chart: {
        type: 'bar', // Bar chart
        height: 350,
        toolbar: {
            show: false,
        },
    },
    plotOptions: {
        bar: {
            horizontal: true, // Horizontal bars
            barHeight: '60%', // Adjust bar height
        },
    },
    xaxis: {
        title: {
            text: 'No. of Incidents',
        },
        categories: remainingBarangays, // Remaining 26 barangay names
        labels: {
            rotate: -90, // Rotate labels for better readability
        },
    },
   
    dataLabels: {
        enabled: true, // Show data labels
    },
    stroke: {
        width: 2, // Bar border width
    },
    colors: ['#FF0000'], // Red bars
    tooltip: {
        custom: function ({ dataPointIndex }) {
            const barangay = remainingBarangays[dataPointIndex];
            const incidents = remainingIncidents[dataPointIndex];
            return `
                <div style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; background: white;">
                    <strong style="color: #FF0000;">${barangay}</strong>
                    <div style="margin-top: 5px; font-size: 12px; color: #333;">
                        Fire Incidents: <strong>${incidents}</strong>
                    </div>
                </div>
            `;
        },
    },
});

// Chart Series for the first group (first 25 barangays)
const barangayChartSeriesFirst = ref([
    {
        name: 'Fire Incidents (First 25)',
        data: first25Incidents,
    },
]);

// Chart Series for the second group (remaining 26 barangays)
const barangayChartSeriesSecond = ref([
    {
        name: 'Fire Incidents (Remaining 26)',
        data: remainingIncidents,
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
                        <div class="col-md-3">
                            <form action="" @submit.prevent="searchYear">
                                <div class="d-flex justify-content-between aligh-items-center mb-4">
                                    <select v-model="searchForm.search" id="year" class="form-control mr-4 "
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
                        <div class="col-md-3 mb-4">
                            <Link :href="route('admin.fire-incident')" class="nav-link p-0">
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

                        <div class="col-md-3 mb-4">
                            <Link :href="route('admin.inspections', { id: pendingID })" class="nav-link p-0">
                            <div class="card rounded-md">
                                <div class="card-body shadow-md">
                                    <div class="row">

                                        <div class="col-9 text-end">
                                            <p class="text-muted mb-0 text-truncate">Pending Inspections</p>
                                            <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{
                                                pending }} <span class="text-muted ml-1"
                                                    style="font-size: 12px; font-weight: normal;"><i
                                                        class="fa-solid fa-circle-info text-danger"></i> More
                                                    Info</span></h3>
                                        </div> <!-- end col -->
                                        <div class="col-3">
                                            <div class="avatar-md bg-gradient">
                                                <iconify-icon icon="ic:twotone-pending" width="50" height="50"
                                                    class="text-danger"></iconify-icon>
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

                        <div class="col-md-3 mb-4">
                            <Link :href="route('admin.inspections', { id: scheduledID })" class="nav-link p-0">
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
                        <div class="col-md-3 mb-4">
                            <Link :href="route('admin.inspections', { id: archiveID })" class="nav-link p-0">
                            <div class="card rounded-md">
                                <div class="card-body shadow-md">
                                    <div class="row">

                                        <div class="col-9 text-end">
                                            <p class="text-muted mb-0 text-truncate">Inspection History</p>
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

                            <div class="card rounded-md mb-4">
                            <div class="card-header">
                                <b>Fire Incidents by Barangay <span class="text-primary">{{ year }}</span></b>
                            </div>
                            <div class="card-body shadow-md">
                                <!-- Two-column layout -->
                                
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="w-1/2 pr-2">
                                            <apexchart
                                                type="bar"
                                                :options="barangayChartOptionsFirst"
                                                    :series="barangayChartSeriesFirst"
                                                    height="800"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="w-1/2 pl-2">
                                            <apexchart
                                                type="bar"
                                                :options="barangayChartOptionsSecond"
                                                :series="barangayChartSeriesSecond"
                                                height="800"
                                            />
                                        </div>
                                        </div>
                                    </div>
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
