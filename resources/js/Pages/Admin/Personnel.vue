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

const showPassword = ref(false);

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

const createValidateForm = () => {
    const createPhoneRegex = /^\d{11}$/;
    const createPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if (!createPhoneRegex.test(createForm.contactNumber)) {
        createForm.error = 'Contact number must be exactly 11 digits.';
        return false;
    }

    if (!createPasswordRegex.test(createForm.password)) {
        createForm.error = 'Password must be at least 8 characters, contain an uppercase letter, a lowercase letter, a number, and a symbol.';
        return false;
    }

    return true;
};

const editValidateForm = () => {
    const editPhoneRegex = /^\d{11}$/;
    const editPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if (!editPhoneRegex.test(editForm.contactNumber)) {
        editForm.error = 'Contact number must be exactly 11 digits.';
        return false;
    }

    if (!editPasswordRegex.test(editForm.password) && editForm.password != '') {
        editForm.error = 'Password must be at least 8 characters, contain an uppercase letter, a lowercase letter, a number, and a symbol.';
        return false;
    }

    return true;
};

// Compression function for image
const compressImage = async (file, { quality = 0.3, type = 'image/jpeg' }) => {
  const imageBitmap = await createImageBitmap(file);
  const canvas = document.createElement('canvas');
  canvas.width = imageBitmap.width;
  canvas.height = imageBitmap.height;
  
  const ctx = canvas.getContext('2d');
  ctx.drawImage(imageBitmap, 0, 0);

  const blob = await new Promise(resolve => canvas.toBlob(resolve, type, quality));
  return new File([blob], file.name, { type: blob.type });
};

const createPicture = async (event) => {
    const file = event.target.files[0];
  if (file && file.type.startsWith('image')) {
    const compressedFile = await compressImage(file, { quality: 0.3, type: file.type });
    createForm.file = compressedFile;
  } else {
    createForm.file = file; // Assign if it's not an image
  }
};

const editPicture = async (event) => {
    const file = event.target.files[0];
  if (file && file.type.startsWith('image')) {
    const compressedFile = await compressImage(file, { quality: 0.3, type: file.type });
    editForm.file = compressedFile;
  } else {
    editForm.file = file; // Assign if it's not an image
  }
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
    if (!createValidateForm()) return;
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
                        text: 'The personnel account has been successfully created. Please remind the personnel to check their email to verify their account.',
                        confirmButtonColor: "#3a57e8"
                    });
                });
            }
        }
    });
};


const updatePersonnelData = () => {
    if (!editValidateForm()) return;
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

                                        <label for="" class="mb-1">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createForm.name" required>

                                        <label for="" class="mb-1">Position <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createForm.position" required>

                                        <label for="" class="mb-1">Contact Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="createForm.contactNumber" required>

                                        <label for="" class="mb-1">Profile Picture <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control form-control-sm mb-3"
                                            @change="createPicture" accept=".jpg" required>

                                        <label for="" class="mb-1">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-control-sm mb-3"
                                            v-model="createForm.email" required>

                                        <div class="form-group position-relative">
                                            <label for="" class="mb-1">Password <span
                                                    class="text-danger">*</span></label>
                                            <input :type="showPassword ? 'text' : 'password'"
                                                class="form-control form-control-sm" v-model="createForm.password"
                                                required>

                                            <iconify-icon icon="ion:eye" v-if="!showPassword"
                                                @click="showPassword = !showPassword" class="eye-icon position-absolute"
                                                style="right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer;">
                                            </iconify-icon>

                                            <iconify-icon icon="ion:eye-off-sharp" v-else
                                                @click="showPassword = !showPassword" class="eye-icon position-absolute"
                                                style="right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer;">
                                            </iconify-icon>
                                        </div>
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

                                        <label for="" class="mb-1">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="editForm.name" required>

                                        <label for="" class="mb-1">Position <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="editForm.position" required>

                                        <label for="" class="mb-1">Contact Number <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-sm mb-3"
                                            v-model="editForm.contactNumber" required>

                                        <label for="" class="mb-1">Update Profile Picture <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control form-control-sm mb-3"
                                            @change="editPicture" accept=".jpg">

                                        <label for="" class="mb-1">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-control-sm mb-3"
                                            v-model="editForm.email" required>

                                        <div class="form-group position-relative">
                                            <label for="" class="mb-1">Change Password <span
                                                    class="text-danger">*</span></label>
                                            <input :type="showPassword ? 'text' : 'password'"
                                                class="form-control form-control-sm" v-model="editForm.password">

                                            <iconify-icon icon="ion:eye" v-if="!showPassword"
                                                @click="showPassword = !showPassword" class="eye-icon position-absolute"
                                                style="right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer;">
                                            </iconify-icon>

                                            <iconify-icon icon="ion:eye-off-sharp" v-else
                                                @click="showPassword = !showPassword" class="eye-icon position-absolute"
                                                style="right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer;">
                                            </iconify-icon>
                                        </div>
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
                                                    <th style="font-size: 12px;">
                                                        <p>Name</p>
                                                    </th>
                                                    <th style="font-size: 12px;">
                                                        <p class="ml-4">Position</p>
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
                                                <tr v-for="(ps, index) in personnel">
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div
                                                                style="width: 50px; height: 50px; position: relative; overflow: hidden;">
                                                                <img :src="'/storage/profile/' + ps.picture"
                                                                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                                                                    alt="">
                                                            </div>
                                                            <b class="ml-3">{{ ps.name }}</b>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <p class="ml-4">
                                                            {{ ps.position }}
                                                        </p>
                                                    </td>
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

<style scoped>
.eye-icon {
    font-size: 1.25rem;
    color: #6c757d;
}
</style>