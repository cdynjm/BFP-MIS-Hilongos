<script setup>

import { Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';

const props = defineProps({
    auth: Array,
    sms: Object,
    cert: Object
})

const editForm = useForm({
    id: null,
    accessToken: null,
    mobileIdentity: null,
    error: null,
    status: null
});

const certInfoForm = useForm({
    id: null,
    contactNumber: null,
    code: null,
    error: null,
    status: null
});

onMounted(() => {
    editForm.id = props.sms.id,
    editForm.accessToken = props.sms.access_token;
    editForm.mobileIdentity = props.sms.mobile_identity;

    certInfoForm.id = props.cert.id;
    certInfoForm.contactNumber = props.cert.contactNumber;
    certInfoForm.code = props.cert.code;
});

const updateSMSToken = () => {
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false
    });
    editForm.patch(route('admin.update-sms-token'), {
        onFinish: () => {
            editForm.error = editForm.errors.error;
            editForm.status = editForm.errors.status;

            if (editForm.status === 500) {
                SweetAlert.close();
                return false;
            } else {
                setTimeout(() => {
                    SweetAlert.fire({
                        icon: 'success',
                        title: 'Done',
                        text: 'SMS API Updated Successfully',
                        confirmButtonColor: "#3a57e8"
                    });
                });
            }
        }
    });
};

const updateCertInfo = () => {
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false
    });
    certInfoForm.patch(route('admin.update-cert-info'), {
        onFinish: () => {
            certInfoForm.error = certInfoForm.errors.error;
            certInfoForm.status = certInfoForm.errors.status;

            if (certInfoForm.status === 500) {
                SweetAlert.close();
                return false;
            } else {
                setTimeout(() => {
                    SweetAlert.fire({
                        icon: 'success',
                        title: 'Done',
                        text: 'Information Updated Successfully',
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

        <Navbar :page="'Settings'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <b>SMS Token with Pushbullet API</b>
                                </div>
                                <div class="card-body shadow-md">
                                    <p class="text-wrap text-justify text-sm mb-4">To access the API you'll need an access token so the
                                        server knows
                                        who you are. You can get one from your <a href="https://www.pushbullet.com/"
                                            target="_blank" class="text-success text-decoration-underline">Account
                                            Settings</a> page.
                                    </p>

                                    <form action="" @submit.prevent="updateSMSToken">
                                        <label for="">Access Token <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="editForm.accessToken">

                                        <label for="">Mobile Identity <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="editForm.mobileIdentity">

                                        <div class="text-center">
                                            <button class="btn btn-sm btn-danger">
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <b>Certificate Information</b>
                                </div>
                                <div class="card-body shadow-md">
                                    

                                    <form action="" @submit.prevent="updateCertInfo">
                                        <label for="">BFP Contact Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="certInfoForm.contactNumber" required>

                                        <label for="">BFP Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="certInfoForm.code" required>

                                        <div class="text-center">
                                            <button class="btn btn-sm btn-danger">
                                                Update
                                            </button>
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

</script>