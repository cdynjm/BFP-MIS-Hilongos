<script setup>

import { Link, useForm } from '@inertiajs/vue3';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';


import { ref, onMounted } from 'vue';

defineProps({
    auth: Array,
    inspections: Array
})

onMounted(() => {
    $('#inspection-table').DataTable();

});

</script>

<template>
    <div class="container-scroller">

        <Navbar :page="'Applicant History'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- PAGE CONTENT -->

                    <div class="row overflowx-auto">

                        <div class="col-md-12">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold">Inspection History</h6>
                                    </div>
                                </div>

                                <div class="card-body shadow-md">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap" id="inspection-table">
                                            <thead>
                                                <tr>
                                                    <th style="font-size: 13px;">Information</th>
                                                    <th style="font-size: 13px;">Status</th>
                                                    <th style="font-size: 13px;">
                                                        Files</th>
                                                    <th style="font-size: 13px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ip, index) in inspections">

                                                    <td>
                                                        <div style="display: flex; align-items: flex-start;">
                                                            <img :src="'/storage/profile/' + ip.applicant.picture"
                                                                style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px; box-shadow: 2px 5px 10px gray;"
                                                                class="mb-3" alt="">


                                                            <div style="margin-left: 15px;">
                                                                <div class="p-1"><span class="text-muted">Owner:</span>
                                                                    {{ ip.applicant.name }}</div>
                                                                <div class="p-1"><span class="text-muted">Phone:</span>
                                                                    {{ ip.applicant.contactNumber }}</div>
                                                                <div class="p-1"><span
                                                                        class="text-muted">Address:</span> {{ ip.purok }}, {{ ip.address
                                                                    }}</div>
                                                            </div>
                                                        </div>

                                                        <div class="p-1"><span class="text-muted">Building Name:</span>
                                                            {{ ip.buildingName }}</div>

                                                        <p v-if="ip.certType === 1" class="font-weight-bold ml-1">Fire
                                                            Safety Evaluation Clearance</p>
                                                        <p v-if="ip.certType === 2" class="font-weight-bold ml-1">Fire
                                                            Safety Inspection Certificate (Occupancy)</p>
                                                        <p v-if="ip.certType === 3" class="font-weight-bold ml-1">Fire
                                                            Safety Inspection Certificate (Business)</p>
                                                    </td>


                                                    <td>
                                                        <span class="text-danger" v-if="ip.status === 1">Pending</span>
                                                        <span class="text-warning" v-if="ip.status === 2">
                                                            <div class="mb-2">
                                                                Scheduled on {{ formatDate(ip.schedule) }}
                                                            </div>
                                                            <div>
                                                                Personnel: {{ ip.personnel.name }}
                                                            </div>

                                                        </span>
                                                        <p class="text-success" v-if="ip.status === 3">
                                                        <div>Done</div>
                                                        <div>Inspected On: {{ formatDate(ip.schedule) }}</div>
                                                        <div class="text-gray">By: {{ ip.personnel.name }}</div>
                                                        </p>
                                                    </td>
                                                    <td class="">
                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex flex-column">
                                                                <a :href="`/storage/files/${ip.file}`" v-if="ip.file != null"  class="text-decoration-none mb-2">
                                                                    <i class="fa-solid fa-file-pdf"></i> Checklist Form
                                                                </a>

                                                                <a :href="`/storage/files/${ip.picture}`" v-if="ip.file != null"  class="text-decoration-none">
                                                                    <i class="fa-solid fa-images"></i> Picture/Image
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <p v-if="ip.file === null" class="text-danger"
                                                            style="font-size: 12px;">No File Yet</p>
                                                    </td>
                                                    <td class="">
                                                        <a :href="`/admin/certificate/${ip.id}`"
                                                            v-if="ip.certStatus != null" 
                                                            class="nav-link">
                                                            <i class="fa-solid fa-file-pdf"></i>
                                                            <span v-if="ip.certType === 1"> FSEC Certificate</span>
                                                            <span v-if="ip.certType === 2"> FSIC Certificate
                                                                (Occupancy)</span>
                                                            <span v-if="ip.certType === 3"> FSIC Certificate
                                                                (Business)</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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

<script>

var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-sm btn-danger margin-end',
        cancelButton: 'btn btn-sm btn-secondary'
    },
    buttonsStyling: false
});

function formatDate(dateString) {
    const options = { year: 'numeric', month: 'short', day: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', options);
}

</script>

<style>
.margin-end {
    margin-right: 10px;
}
</style>
