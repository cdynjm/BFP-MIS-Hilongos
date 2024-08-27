<script setup>

import { Link, useForm } from '@inertiajs/vue3';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';


import { ref, onMounted } from 'vue';

defineProps({
    auth: Array,
    id: Number,
    inspections: Array,
})

const updateModal = ref(null);

onMounted(() => {

    updateModal.value = new bootstrap.Modal($('#updateModal'), {
        keyboard: false
    });

    $('#inspection-table').DataTable();
});

const uploadForm = useForm({
    id: null,
    name: null,
    file: null
});

const completeInspection = (id) => {
    const completeForm = useForm({ id: id });
    SweetAlert.fire({
        icon: 'question',
        title: 'Done checking?',
        text: "This will complete the applicant's request for inspection.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Confirm!'
    }).then((result) => {
        if (result.value) {
            completeForm.patch(route('personnel.complete-inspection'));
            SweetAlert.fire({
                icon: 'success',
                title: 'Done',
                text: 'Updated successfully',
                confirmButtonColor: "#3a57e8"
            });
        }
    })
};

const handleFileChange = (event) => {
    uploadForm.file = event.target.files[0];
};

const uploadFile = () => {
    SweetAlert.fire({
        icon: 'question',
        title: 'Upload File?',
        text: "This will upload the checklist form for this applicant.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Confirm!'
    }).then((result) => {
        if (result.value) {
            uploadForm.post(route('personnel.upload-form'), {
                forceFormData: true,
                onSuccess: () => {
                    updateModal.value.hide()
                    SweetAlert.fire({
                        icon: 'success',
                        title: 'Done',
                        text: 'Checklist form uploaded successfully',
                        confirmButtonColor: "#3a57e8"
                    });
                }
            });
        }
    });
};

const deleteFile = (id) => {
    const deleteForm = useForm({ id: id });
    SweetAlert.fire({
        icon: 'question',
        title: 'Delete File?',
        text: "This will delete the uploaded checklist form.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Confirm!'
    }).then((result) => {
        if (result.value) {
            deleteForm.delete(route('personnel.delete-form'));
            SweetAlert.fire({
                icon: 'success',
                title: 'Done',
                text: 'File deleted successfully',
                confirmButtonColor: "#3a57e8"
            });
        }
    })
};

const updateStatus = (id, name) => {
    uploadForm.id = id;
    uploadForm.name = name;
    updateModal.value.show()
}

</script>

<template>
    <div class="container-scroller">

        <Navbar v-if="id === 2" :page="'Scheduled'" />
        <Navbar v-if="id === 3" :page="'Archives'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="modal fade" id="updateModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Update Status</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-md-12 mb-4">
                                            <form action="" @submit.prevent="uploadFile()">
                                                <label for="">Upload Checklist Form</label>
                                                <input type="file" class="form-control form-control-sm mb-3"
                                                    @change="handleFileChange" accept=".pdf, .jpg, .png, .jpeg"
                                                    required>
                                                <button class="btn btn-sm btn-info">Upload</button>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PAGE CONTENT -->

                    <div class="row">

                        <div class="col-md-12">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
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
                                                    <th style="font-size: 13px;" v-if="id === 2">Scanned Checklist</th>
                                                    <th style="font-size: 13px;" v-if="id === 2">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ip, index) in inspections">

                                                    <td>
                                                        <div style="display: flex; align-items: flex-start;">
                                                            <img :src="'/storage/profile/' + ip.applicant.picture"
                                                                style="width: 70px; height: auto; border-radius: 5px; box-shadow: 2px 5px 10px gray;"
                                                                class="mb-3" alt="">

                                                            <div style="margin-left: 15px;">
                                                                <div class="p-1"><span class="text-muted">Owner:</span>
                                                                    {{ ip.applicant.name }}</div>
                                                                <div class="p-1"><span class="text-muted">Phone:</span>
                                                                    {{ ip.applicant.contactNumber }}</div>
                                                                <div class="p-1"><span
                                                                        class="text-muted">Address:</span> {{ ip.address
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
                                                        <span class="text-warning" v-if="ip.status === 2">
                                                            <div class="mb-2">
                                                                Scheduled on {{ formatDate(ip.schedule) }}
                                                            </div>

                                                        </span>
                                                        <p class="text-success" v-if="ip.status === 3">
                                                        <div>Done</div>
                                                        <div>Inspected On: {{ formatDate(ip.schedule) }}</div>
                                                        </p>
                                                    </td>
                                                    <td v-if="id === 2" class="">


                                                        <a :href="`/storage/files/${ip.file}`" v-if="ip.file != null"
                                                            target="_blank">
                                                            <i class="fa-solid fa-file-pdf"></i> Checklist Form
                                                        </a>
                                                        <a href="#" class="ml-2 text-danger" v-if="ip.file != null"
                                                            @click.prevent="deleteFile(ip.id)"><i
                                                                class="fa-solid fa-trash-can"></i></a>

                                                        <p v-if="ip.file === null" class="text-danger"
                                                            style="font-size: 12px;">No File Yet</p>
                                                    </td>
                                                    <td v-if="id === 2" class="text-center">
                                                        <button class="btn btn-sm btn-success p-1"
                                                            style="font-size: 12px;"
                                                            @click.prevent="completeInspection(ip.id)"
                                                            :disabled="ip.file === null"><i class="fa-solid fa-check"
                                                                style="font-size: 12px;"></i> Done</button>
                                                        <i class="text-danger d-block mt-3" style="font-size: 12px;"
                                                            v-if="ip.file == null">Please upload the checklist form
                                                            first</i>
                                                        <button class="btn btn-sm btn-info mt-3 p-1"
                                                            @click.prevent="updateStatus(ip.id, ip.applicant.name)"
                                                            v-if="ip.file === null" style="font-size: 12px;">
                                                            <i class="fa-solid fa-pen-fancy"
                                                                style="font-size: 12px;"></i> Edit
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
