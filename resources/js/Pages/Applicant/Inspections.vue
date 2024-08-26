<script setup>

import { Link, useForm } from '@inertiajs/vue3';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';


import { ref, onMounted } from 'vue';

defineProps({
    auth: Array,
    id: Number,
    inspections: Array
})

onMounted(() => {

    $('#inspection-table').DataTable();

});

const cancelInspection = (id) => {
    const deleteForm = useForm({ id: id });
    SweetAlert.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "This will cancel and remove your inspection request permanently.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Cancel it!'
    }).then((result) => {
        if (result.value) {
            deleteForm.delete(route('applicant.delete-inspection'));
            SweetAlert.close();
        }
    })
};

</script>

<template>
    <div class="container-scroller">

        <Navbar v-if="id === 1" :page="'Pending'" />
        <Navbar v-if="id === 2" :page="'Scheduled'" />
        <Navbar v-if="id === 3" :page="'Archives'" />

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
                                        <h6 class="fw-bold" v-if="id === 1">Pending</h6>
                                        <h6 class="fw-bold" v-if="id === 2">Scheduled</h6>
                                        <h6 class="fw-bold" v-if="id === 3">Archives</h6>
                                    </div>
                                </div>

                                <div class="card-body shadow-md">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap" id="inspection-table">
                                            <thead>
                                                <tr>

                                                    <th style="font-size: 13px;">Information</th>
                                                    <th style="font-size: 13px;">Status</th>
                                                    <th style="font-size: 13px;" v-if="id === 3">Scanned Checklist</th>
                                                    <th style="font-size: 13px;" v-if="id === 3">Certificate</th>
                                                    <th style="font-size: 13px;" v-if="id === 1">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ip, index) in inspections">

                                                    <td>
                                                        <div class="p-1"><span class="text-muted">Building Name:</span>
                                                            {{ ip.buildingName }}</div>
                                                        <div class="p-1"><span class="text-muted">Address:</span> {{
                                                            ip.address }}</div>
                                                        <p v-if="ip.certType === 1" class="font-weight-bold">Fire Safety
                                                            Evaluation Clearance</p>
                                                        <p v-if="ip.certType === 2" class="font-weight-bold">Fire Safety
                                                            Inspection Certificate (Occupancy)</p>
                                                        <p v-if="ip.certType === 3" class="font-weight-bold">Fire Safety
                                                            Inspection Certificate (Business)</p>
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
                                                        </p>
                                                    </td>
                                                    <td v-if="id === 3">
                                                        <a :href="`/storage/files/${ip.file}`" v-if="ip.file != null"
                                                            target="_blank" class="nav-link">
                                                            <i class="fa-solid fa-file-pdf"></i> Checklist Form
                                                        </a>
                                                    </td>
                                                    <td v-if="id === 3">
                                                        <a :href="`/applicant/certificate/${ip.id}`"
                                                            v-if="ip.certStatus != null" target="_blank"
                                                            class="nav-link">
                                                            <i class="fa-solid fa-file-pdf"></i>
                                                            <span v-if="ip.certType === 1"> FSEC Certificate</span>
                                                            <span v-if="ip.certType === 2"> FSIC Certificate
                                                                (Occupancy)</span>
                                                            <span v-if="ip.certType === 3"> FSIC Certificate
                                                                (Business)</span>
                                                        </a>
                                                    </td>
                                                    <td v-if="id === 1">
                                                        <button class="btn btn-sm btn-primary shadow-lg"
                                                            @click.prevent="cancelInspection(ip.id)">
                                                            Cancel
                                                        </button>
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
