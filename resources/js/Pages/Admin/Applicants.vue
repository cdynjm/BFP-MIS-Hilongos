<script setup>

import { Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';

const props = defineProps({
    auth: Array,
    applicant: Array,
    total: Number
})

onMounted(() => {
    $('#applicant-table').DataTable();
});

</script>

<template>
    <div class="container-scroller">

        <Navbar :page="'Applicants/Users'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <b>List of Applicants</b>
                                        <div><small>Total: </small><b style="font-size: 25px;">{{ total }}</b></div>
                                    </div>
                                </div>
                                <div class="card-body shadow-md">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap" id="applicant-table">
                                            <thead>
                                                <tr>
                                                    <th style="font-size: 12px;">
                                                        <p>No.</p>
                                                    </th>
                                                    <th style="font-size: 12px;">
                                                        <p>Name</p>
                                                    </th>
                                                    <th style="font-size: 12px;">
                                                        <p>Contact Number</p>
                                                    </th>
                                                    <th style="font-size: 12px;">
                                                        <p>Action</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ap, index) in applicant">
                                                    <td class="text-center" width="8%">
                                                        {{ index + 1 }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                style="width: 50px; height: 50px; position: relative; overflow: hidden;">
                                                                <img :src="'/storage/profile/' + ap.picture"
                                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                                                                    alt="">
                                                            </div>
                                                            <b class="ml-3">{{ ap.name }}</b>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p>{{ ap.contactNumber }}</p>
                                                    </td>
                                                    <td>
                                                        <Link :href="route('admin.applicants-records', { id: ap.id })" title="View Records" class="d-flex align-items-center nav-link">
                                                            <iconify-icon icon="lets-icons:eye-duotone" width="22" class="mr-1"></iconify-icon>
                                                            <div>View</div>
                                                        </Link>
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

</script>