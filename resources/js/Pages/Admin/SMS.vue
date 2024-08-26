<script setup>

import { Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';

const props = defineProps({
    auth: Array,
    sms: Object,
})

const editForm = useForm({
    id: null,
    accessToken: null,
    mobileIdentity: null,
    error: null,
    status: null
});

onMounted(() => {
    editForm.id = props.sms.id,
        editForm.accessToken = props.sms.access_token;
    editForm.mobileIdentity = props.sms.mobile_identity;
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

</script>

<template>
    <div class="container-scroller">

        <Navbar :page="'SMS Configuration'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">

                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <b>SMS Token</b>
                                </div>
                                <div class="card-body shadow-md">
                                    <p class="text-wrap text-justify text-sm mb-4">Pushbullet's API enables developers
                                        to build on the
                                        Pushbullet infrastructure. Our goal is to provide a full API that enables
                                        anything to tap
                                        into the Pushbullet network.
                                        The Pushbullet API lets you send/receive pushes and do everything else the
                                        official
                                        Pushbullet clients can do. To access the API you'll need an access token so the
                                        server knows
                                        who you are. You can get one from your <a href="https://www.pushbullet.com/"
                                            target="_blank" class="text-success text-decoration-underline">Account
                                            Settings</a> page.
                                    </p>

                                    <form action="" @submit.prevent="updateSMSToken">
                                        <label for="">URL</label>
                                        <input type="text" class="form-control form-control-sm mb-3" :value="sms.url"
                                            readonly>

                                        <label for="">Access Token</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="editForm.accessToken">

                                        <label for="">Mobile Identity</label>
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
                        <div class="col-md-3"></div>

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