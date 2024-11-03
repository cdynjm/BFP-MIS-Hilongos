<script setup>

import { Link, useForm } from '@inertiajs/vue3';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';

defineProps({
    auth: Array,

    pending: Array,
    scheduled: Array,
    archive: Array,
    personnel: Array,

    pendingID: String,
    scheduledID: String,
    archiveID: String,
})

const createForm = useForm({



    error: null,
    status: null,
});

const createFormData = () => {
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false
    });
    createForm.post(route('applicant.create-request-inspection'), {
        onFinish: () => {
            createForm.error = createForm.errors.error;
            createForm.status = createForm.errors.status;

            if (createForm.status === 500) {
                SweetAlert.close();
                return false;
            } else {
                setTimeout(() => {
                    SweetAlert.fire({
                        icon: 'success',
                        title: 'Done',
                        text: 'Your inspection request has been submitted successfully for scheduling',
                        confirmButtonColor: "#3a57e8"
                    });
                });
            }
        }
    });
};

</script>

<template>
    <div class="container-scroller">

        <Navbar :page="'Dashboard'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <Link :href="route('applicant.inspections', { id: pendingID })" class="nav-link p-0">
                            <div class="card rounded-md">
                                <div class="card-body shadow-md">
                                    <div class="row">

                                        <div class="col-9 text-end">
                                            <p class="text-muted mb-0 text-truncate">Your Pending Request</p>
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

                        <div class="col-md-4 mb-4">
                            <Link :href="route('applicant.inspections', { id: scheduledID })" class="nav-link p-0">
                            <div class="card rounded-md">
                                <div class="card-body shadow-md">
                                    <div class="row">

                                        <div class="col-9 text-end">
                                            <p class="text-muted mb-0 text-truncate">Your Scheduled Inspections</p>
                                            <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{
                                                scheduled }} <span class="text-muted ml-1"
                                                    style="font-size: 12px; font-weight: normal;"><i
                                                        class="fa-solid fa-circle-info text-warning"></i> More
                                                    Info</span></h3>
                                        </div> <!-- end col -->
                                        <div class="col-3">
                                            <div class="avatar-md bg-gradient">
                                                <iconify-icon icon="uim:schedule" width="50" height="50"
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
                            <Link :href="route('applicant.inspections', { id: archiveID })" class="nav-link p-0">
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

                        <div class="col-md-12 text-center">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <p class="font-weight-bold"><i class="fa-solid fa-people-roof mr-1"></i> BUREAU OF
                                        FIRE PROTECTION PERSONNEL</p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            The <span class="text-danger">BFP (Bureau of Fire Protection)</span>
                                            personnel are dedicated public servants responsible for ensuring fire
                                            safety, conducting fire inspections, and responding to emergencies. They are
                                            well-trained in fire prevention, rescue operations, and disaster
                                            preparedness, playing a crucial role in protecting lives and property. Their
                                            commitment to public safety and adherence to strict protocols make them
                                            essential in maintaining a secure environment within their communities.
                                        </div>
                                        <div class="col-md-3 text-center mb-4" v-for="(ps, index) in personnel">

                                            <center>
                                                <div style="width: 60%; padding-bottom: 60%; position: relative; overflow: hidden; border-radius: 8px; box-shadow: 2px 5px 10px gray; border: 5px solid darkslategrey;" class="mb-4">
                                                    <img :src="'/storage/profile/' + ps.picture"
                                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                                                        class="mb-3">
                                                </div>
                                            </center>


                                            <div class="font-weight-bold"><i
                                                    class="fa-solid fa-circle-check text-success mr-1"></i> {{ ps.name
                                                }}</div>
                                            <div class="text-primary font-weight-bold" style="font-size: 12px;">{{
                                                ps.position }}</div>
                                            
                                        </div>
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

function formatDateTime(dateString) {
    const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    };
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', options);
}

function formatTime12Hour(timeString) {
    const [hours, minutes, seconds] = timeString.split(':');
    let hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    hour = hour % 12;
    hour = hour ? hour : 12; // The hour '0' should be '12'
    return `${hour}:${minutes} ${ampm}`;
}

function formatNumber(value) {
    return new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(value);
}

</script>