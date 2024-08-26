<script setup>

import { Link, useForm } from '@inertiajs/vue3';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';


import { ref, onMounted } from 'vue';

defineProps({
    auth: Array,
    personnel: Array
})

const createModal = ref(null);
const editModal = ref(null);

onMounted(() => {
    createModal.value = new bootstrap.Modal($('#createModal'), {
        keyboard: false
    });

    editModal.value = new bootstrap.Modal($('#editModal'), {
        keyboard: false
    });

    $('#personnel-table').DataTable();

});

const createForm = useForm({
    name: null,
    position: null,
    email: null,
    contactNumber: null,
    file: null,
    password: null,
    error: null,
    status: null,
});

const editForm = useForm({
    id: null,
    name: null,
    position: null,
    email: null,
    contactNumber: null,
    file: null,
    password: null,
    error: null,
    status: null,
});

const createPicture = (event) => {
    createForm.file = event.target.files[0];
};

const editPicture = (event) => {
    editForm.file = event.target.files[0];
};

const createPersonnel = () => {
    createModal.value.show();
};

const editPersonnel = (id, name, position, contactNumber, email) => {
    editModal.value.show();
    editForm.id = id;
    editForm.name = name;
    editForm.position = position;
    editForm.contactNumber = contactNumber;
    editForm.email = email;
}

const createPersonnelData = () => {
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false
    });

    createForm.post(route('admin.create-personnel'), {
        forceFormData: true,
        onFinish: () => {
            createForm.error = createForm.errors.error;
            createForm.status = createForm.errors.status;

            if (createForm.status === 500) {
                SweetAlert.close();
                return false;
            } else {
                setTimeout(() => {
                    createModal.value.hide();

                    SweetAlert.fire({
                        icon: 'success',
                        title: 'Done',
                        text: 'Created Successfully',
                        confirmButtonColor: "#3a57e8"
                    });
                });
            }
        }
    });
};

const updatePersonnelData = () => {
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false
    });
    editForm.post(route('admin.update-personnel'), {
        forceFormData: true,
        onFinish: () => {
            editForm.error = editForm.errors.error;
            editForm.status = editForm.errors.status;

            if (editForm.status === 500) {
                SweetAlert.close();
                return false;
            } else {
                setTimeout(() => {
                    editModal.value.hide();
                    SweetAlert.fire({
                        icon: 'success',
                        title: 'Done',
                        text: 'Updated Successfully',
                        confirmButtonColor: "#3a57e8"
                    });
                });
            }
        }
    });
};

const deletePersonnelData = (id) => {
    const deleteForm = useForm({ id: id });
    SweetAlert.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "This will remove the personnel permanently.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete it!'
    }).then((result) => {
        if (result.value) {
            deleteForm.delete(route('admin.delete-personnel'));
            SweetAlert.close();
        }
    })
};

</script>

<template>
    <div class="container-scroller">

        <Navbar :page="'Personnel'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- MODALS -->

                    <div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Create Personnel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" @submit.prevent="createPersonnelData">
                                    <div class="modal-body">

                                        <div class="alert alert-danger" v-if="createForm.error">
                                            {{ createForm.error }}
                                        </div>

                                        <label for="" class="mb-1">Full Name</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createForm.name" required>

                                        <label for="" class="mb-1">Position</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createForm.position" required>

                                        <label for="" class="mb-1">Contact Number</label>
                                        <input type="number" class="form-control form-control-sm mb-3"
                                            v-model="createForm.contactNumber" required>

                                        <label for="" class="mb-1">Profile Picture</label>
                                        <input type="file" class="form-control form-control-sm mb-3"
                                            @change="createPicture" accept=".jpg, .png, .jpeg" required>

                                        <label for="" class="mb-1">Email</label>
                                        <input type="email" class="form-control form-control-sm mb-3"
                                            v-model="createForm.email" required>

                                        <label for="" class="mb-1">Password</label>
                                        <input type="password" class="form-control form-control-sm"
                                            v-model="createForm.password" required>
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

                    <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Personnel</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" @submit.prevent="updatePersonnelData">
                                    <div class="modal-body">

                                        <div class="alert alert-danger" v-if="editForm.error">
                                            {{ editForm.error }}
                                        </div>

                                        <label for="" class="mb-1">Full Name</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="editForm.name" required>

                                        <label for="" class="mb-1">Position</label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="editForm.position" required>

                                        <label for="" class="mb-1">Contact Number</label>
                                        <input type="number" class="form-control form-control-sm mb-3"
                                            v-model="editForm.contactNumber" required>

                                        <label for="" class="mb-1">Update Profile Picture</label>
                                        <input type="file" class="form-control form-control-sm mb-3"
                                            @change="editPicture" accept=".jpg, .png, .jpeg">

                                        <label for="" class="mb-1">Email</label>
                                        <input type="email" class="form-control form-control-sm mb-3"
                                            v-model="editForm.email" required>

                                        <label for="" class="mb-1">Password</label>
                                        <input type="password" class="form-control form-control-sm"
                                            v-model="editForm.password">
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

                    <!-- PAGE CONTENT -->

                    <div class="row">

                        <div class="col-md-12">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold">List of Personnels</h6>
                                        <button class="btn btn-primary shadow-lg btn-sm" @click="createPersonnel"> +
                                            Add</button>
                                    </div>
                                </div>

                                <div class="card-body shadow-md">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap" id="personnel-table">
                                            <thead>
                                                <tr>
                                                    <th style="font-size: 13px;">Name</th>
                                                    <th style="font-size: 13px;">Position</th>
                                                    <th style="font-size: 13px;">Contact Number</th>
                                                    <th style="font-size: 13px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ps, index) in personnel">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img :src="'/storage/profile/' + ps.picture"
                                                                style="width: 60px; height: auto; border-radius: 5px"
                                                                class="mr-3" alt="">
                                                            <b>{{ ps.name }}</b>
                                                        </div>
                                                    </td>
                                                    <td>{{ ps.position }}</td>
                                                    <td>{{ ps.contactNumber }}</td>
                                                    <td>
                                                        <a href="#" class="p-2" @click.prevent="editPersonnel(
                                                            ps.id,
                                                            ps.name,
                                                            ps.position,
                                                            ps.contactNumber,
                                                            ps.user.email
                                                        )">
                                                            <i class="fa-solid fa-pen-fancy"></i>
                                                        </a>
                                                        <a href="#" class="p-2"
                                                            @click.prevent="deletePersonnelData(ps.id)">
                                                            <i class="fa-solid fa-trash"></i>
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

</script>

<style>
.margin-end {
    margin-right: 10px;
}
</style>
