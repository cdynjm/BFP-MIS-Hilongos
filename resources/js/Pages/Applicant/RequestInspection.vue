<script setup>

import { Link, useForm } from '@inertiajs/vue3';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';

import { ref, onMounted } from 'vue';

defineProps({
    auth: Array,
})

const createFSECModal = ref(null);
const createFSICOccupancyModal = ref(null);
const createFSICBusinessModal = ref(null);

onMounted(() => {
    createFSECModal.value = new bootstrap.Modal($('#createFSECModal'), {
        keyboard: false
    });

    createFSICOccupancyModal.value = new bootstrap.Modal($('#createFSICOccupancyModal'), {
        keyboard: false
    });

    createFSICBusinessModal.value = new bootstrap.Modal($('#createFSICBusinessModal'), {
        keyboard: false
    });
});

const createFSECForm = useForm({
    building: null,
    address: null,
    error: null,
    status: null,
});

const createFSICOccupancyForm = useForm({
    building: null,
    address: null,
    error: null,
    status: null,
});

const createFSICBusinessForm = useForm({
    building: null,
    address: null,
    error: null,
    status: null,
});

const createFSEC = () => {
    createFSECModal.value.show();
};

const createFSICOccupancy = () => {
    createFSICOccupancyModal.value.show();
};

const createFSICBusiness = () => {
    createFSICBusinessModal.value.show();
};

const createFSECFormData = () => {
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false
    });
    createFSECForm.post(route('applicant.create-fsec'), {
        onFinish: () => {
            createFSECForm.error = createFSECForm.errors.error;
            createFSECForm.status = createFSECForm.errors.status;

            if (createFSECForm.status === 500) {
                SweetAlert.close();
                return false;
            } else {
                setTimeout(() => {
                    createFSECModal.value.hide();
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

const createFSICOccupancyFormData = () => {
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false
    });
    createFSICOccupancyForm.post(route('applicant.create-fsic-occupancy'), {
        onFinish: () => {
            createFSICOccupancyForm.error = createFSICOccupancyForm.errors.error;
            createFSICOccupancyForm.status = createFSICOccupancyForm.errors.status;

            if (createFSICOccupancyForm.status === 500) {
                SweetAlert.close();
                return false;
            } else {
                setTimeout(() => {
                    createFSICOccupancyModal.value.hide();
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

const createFSICBusinessFormData = () => {
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false
    });
    createFSICBusinessForm.post(route('applicant.create-fsic-business'), {
        onFinish: () => {
            createFSICBusinessForm.error = createFSICBusinessForm.errors.error;
            createFSICBusinessForm.status = createFSICBusinessForm.errors.status;

            if (createFSICBusinessForm.status === 500) {
                SweetAlert.close();
                return false;
            } else {
                setTimeout(() => {
                    createFSICBusinessModal.value.hide();
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

        <Navbar :page="'Request Inspection'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- MODALS -->

                    <div class="modal fade" id="createFSECModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Request FSEC</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" @submit.prevent="createFSECFormData">
                                    <div class="modal-body">

                                        <div class="alert alert-danger" v-if="createFSECForm.error">
                                            {{ createFSECForm.error }}
                                        </div>

                                        <label for="" class="mb-1">Name of Building/Structure/Facility</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createFSECForm.building" required>

                                        <label for="" class="mb-1">Address</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createFSECForm.address" required>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="" class="btn btn-sm btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="createFSICOccupancyModal" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Request FSIC for Occupancy</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" @submit.prevent="createFSICOccupancyFormData">
                                    <div class="modal-body">

                                        <div class="alert alert-danger" v-if="createFSICOccupancyForm.error">
                                            {{ createFSICOccupancyForm.error }}
                                        </div>

                                        <label for="" class="mb-1">Name of Establishment</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createFSICOccupancyForm.building" required>

                                        <label for="" class="mb-1">Address</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createFSICOccupancyForm.address" required>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="" class="btn btn-sm btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="createFSICBusinessModal" data-bs-backdrop="static"
                        data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Request FSIC for Business</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" @submit.prevent="createFSICBusinessFormData">
                                    <div class="modal-body">

                                        <div class="alert alert-danger" v-if="createFSICBusinessForm.error">
                                            {{ createFSICBusinessForm.error }}
                                        </div>

                                        <label for="" class="mb-1">Name of Establishment</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createFSICBusinessForm.building" required>

                                        <label for="" class="mb-1">Address</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createFSICBusinessForm.address" required>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="" class="btn btn-sm btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12" style="margin-bottom: 30px">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <b>Request for a Fire Safety Inspection</b>
                                </div>
                                <div class="card-body shadow-md">



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

                                    <hr style="margin-bottom: 30px;">

                                    <div class="row">

                                        <div class="col-md-4 text-center mb-4">
                                            <p class="font-weight-bold" style="font-size: 16px;">Fire Safety Evaluation
                                                Clearance</p>
                                            <center>
                                                <a href="#" @click.prevent="createFSEC"><img src="/images/checklist.gif"
                                                        style="width: 50%; height: auto;" alt=""></a>
                                            </center>
                                            <button class="btn btn-primary btn-sm" @click.prevent="createFSEC">Request
                                                Inspection</button>
                                        </div>

                                        <div class="col-md-4 text-center mb-4">
                                            <p class="font-weight-bold" style="font-size: 16px;">Fire Safety Inspection
                                                for Occupancy</p>
                                            <center>
                                                <a href="#" @click.prevent="createFSICOccupancy"><img
                                                        src="/images/prescription.gif" style="width: 50%; height: auto;"
                                                        alt=""></a>
                                            </center>
                                            <button class="btn btn-primary btn-sm"
                                                @click.prevent="createFSICOccupancy">Request Inspection</button>
                                        </div>

                                        <div class="col-md-4 text-center mb-4">
                                            <p class="font-weight-bold" style="font-size: 16px;">Fire Safety Inspection
                                                for Business</p>
                                            <center>
                                                <a href="#" @click.prevent="createFSICBusiness"><img
                                                        src="/images/task.gif" style="width: 50%; height: auto;"
                                                        alt=""></a>
                                            </center>
                                            <button class="btn btn-primary btn-sm"
                                                @click.prevent="createFSICBusiness">Request Inspection</button>
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