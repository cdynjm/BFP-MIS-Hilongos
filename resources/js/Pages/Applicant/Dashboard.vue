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

    pendingID: String,
    scheduledID: String,
    archiveID: String,
})

const createForm = useForm({

    buildingName: null,
    address: null,
    businessName: null,
    businessNature: null,
    FSECNumber: null,
    dateFSEC: null,
    buildingPermit: null,
    dateBuildingPermit: null,
    FSICNumber: null,
    dateFSIC: null,
    permitNumber: null,
    datePermitNumber: null,
    fireInsurance: null,
    dateFireInsurance: null,

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
                                        <div class="col-2">
                                            <div class="avatar-md bg-gradient">
                                                <i class="fa-solid fa-hourglass-half text-danger"
                                                    style="font-size: 40px;"></i>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-10 text-end">
                                            <p class="text-muted mb-0 text-truncate">Your Pending Request</p>
                                            <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{
                                                pending }}</h3>
                                        </div> <!-- end col -->
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
                                        <div class="col-2">
                                            <div class="avatar-md bg-gradient">
                                                <i class="fa-solid fa-calendar-check text-warning"
                                                    style="font-size: 40px;"></i>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-10 text-end">
                                            <p class="text-muted mb-0 text-truncate">Your Scheduled Inspections</p>
                                            <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{
                                                scheduled }}</h3>
                                        </div> <!-- end col -->
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
                                        <div class="col-2">
                                            <div class="avatar-md bg-gradient">
                                                <i class="fa-solid fa-box-open text-success"
                                                    style="font-size: 40px;"></i>
                                            </div>
                                        </div> <!-- end col -->
                                        <div class="col-10 text-end">
                                            <p class="text-muted mb-0 text-truncate">Archives</p>
                                            <h3 class="text-dark mt-2 mb-0 font-weight-bold" style="font-size: 25px;">{{
                                                archive }}</h3>
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </div> <!-- end card body -->
                            </div> <!-- end card -->
                            </Link>
                        </div>

                        <div class="col-md-12" style="margin-bottom: 30px">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    Request for a Fire Safety Inspection
                                </div>
                                <div class="card-body shadow-md">

                                    <form action="" @submit.prevent="createFormData">

                                        <div class="alert alert-danger" v-if="createForm.error">
                                            {{ createForm.error }}
                                        </div>

                                        <div class="row" style="margin-bottom: 20px;">
                                            <div class="col-md-2">
                                                <img src="/images/fire-safety.webp"
                                                    style="width: 100px; height: auto; margin: auto;" alt="">
                                            </div>

                                            <div class="col-md-10">
                                                <div style="margin-top: 15px; text-align: justify;">A fire safety
                                                    inspection is a systematic evaluation of a building or facility to
                                                    identify potential fire hazards, ensure compliance with fire safety
                                                    regulations, and verify that fire prevention, detection, and
                                                    suppression systems are properly installed and maintained. The
                                                    inspection typically includes checking fire alarms, extinguishers,
                                                    emergency exits, and evacuation plans, aiming to protect occupants
                                                    and minimize the risk of fire-related incidents.</div>
                                            </div>
                                        </div>

                                        <div style="margin-bottom: 20px;">
                                            <b> Data Privacy Act of 2012 (Republic Act No. 10173)</b> is a law in the
                                            Philippines designed to protect the personal information of individuals. It
                                            mandates that all personal data collected by government and private entities
                                            must be safeguarded to ensure privacy and security
                                        </div>

                                        <div style="margin-bottom: 20px;" class="text-primary">
                                            <i>We are committed to safeguarding your personal information in compliance
                                                with the <b>Data Privacy Act of 2012</b>. Your data will be collected,
                                                processed, and stored securely, ensuring confidentiality and protection
                                                against unauthorized access. We take your privacy seriously and will use
                                                your information solely for its intended purpose.</i>
                                        </div>

                                        <hr style="margin-bottom: 20px;">

                                        <p style="margin-bottom: 10px;" class="font-weight-bold">GENERAL INFORMATION</p>

                                        <div class="row">
                                            <div class="col-md-6">

                                                <label for="">Building Name</label>
                                                <input type="text" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.buildingName" required>

                                                <label for="">Address</label>
                                                <input type="text" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.address" required>

                                                <label for="">Business Name</label>
                                                <input type="text" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.businessName" required>

                                                <label for="">Nature of Business</label>
                                                <input type="text" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.businessNature" required>

                                                <label for="">FSEC No.</label>
                                                <input type="text" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.FSECNumber" required>

                                                <label for="">Date Issued (FSEC)</label>
                                                <input type="date" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.dateFSEC" required>

                                                <label for="">Building/Renovation Permit</label>
                                                <input type="text" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.buildingPermit" required>

                                            </div>

                                            <div class="col-md-6">

                                                <label for="">Date Issued (Building Permit)</label>
                                                <input type="date" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.dateBuildingPermit" required>

                                                <label for="">FSIC No. (Latest)</label>
                                                <input type="text" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.FSICNumber" required>

                                                <label for="">Date Issued (FSIC No.)</label>
                                                <input type="date" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.dateFSIC" required>

                                                <label for="">Business Permit No.</label>
                                                <input type="text" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.permitNumber" required>

                                                <label for="">Date Issued (Business Permit No.)</label>
                                                <input type="date" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.datePermitNumber" required>

                                                <label for="">Fire Insurance Policy No.</label>
                                                <input type="text" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.fireInsurance" required>

                                                <label for="">Date Issued (Fire Insurance)</label>
                                                <input type="date" class="form-control form-control-sm mb-2"
                                                    v-model="createForm.dateFireInsurance" required>

                                            </div>

                                        </div>

                                        <div class="p-3 text-center">
                                            <button class="btn btn-sm btn-primary">Submit Request</button>
                                        </div>

                                    </form>
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