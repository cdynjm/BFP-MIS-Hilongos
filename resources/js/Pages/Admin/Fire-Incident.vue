<script setup>

import { Link, useForm } from '@inertiajs/vue3';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';


import { ref, onMounted } from 'vue';

const props = defineProps({ 
    auth: Array,
    fireIncident: Array,
    year: String
})

const searchForm = useForm({
    search: null,
    result: 0,
});

const years = Array.from({ length: 2040 - 2023 + 1 }, (_, i) => 2023 + i);
searchForm.search = '';

const searchYear = () => {
    searchForm.get(route('admin.search-year'));
};

const createModal = ref(null);
const editModal = ref(null);

onMounted(() => {
    createModal.value = new bootstrap.Modal($('#createModal'), {
        keyboard: false
    });

    editModal.value = new bootstrap.Modal($('#editModal'), {
        keyboard: false
    });
    $('#fire-incident-table').DataTable();
});

const createForm = useForm({
    owner: null,
    location: null,
    fireAlarmLevel: null,
    date: null,
    time: null,
    casualties: null,
    fireCause: null,
    injuries: null,
    structureType: null,
    estimatedValueLoss: null,
    error: null,
    status: null,
});

const editForm = useForm({
    id: null,
    owner: null,
    location: null,
    fireAlarmLevel: null,
    date: null,
    time: null,
    casualties: null,
    fireCause: null,
    injuries: null,
    structureType: null,
    estimatedValueLoss: null,
    error: null,
    status: null,
});

const createFireIncidentReport = () => {
    createModal.value.show();
};

const editFireIncidentReport = (id, owner, location, fireAlarmLevel, date, time, casualties, fireCause, injuries, structureType, estimatedValueLoss) => {
    editModal.value.show();
    editForm.id = id,
    editForm.owner = owner;
    editForm.location = location;
    editForm.fireAlarmLevel = fireAlarmLevel,
    editForm.date = date;
    editForm.time = time;
    editForm.casualties = casualties;
    editForm.fireCause = fireCause;
    editForm.injuries = injuries;
    editForm.structureType = structureType;
    editForm.estimatedValueLoss = estimatedValueLoss;
}

const createFireIncidentReportData = () => {
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false
    });
    createForm.post(route('admin.create-fire-incident'), {
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

const updateFireIncidentReportData = () => {
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        title: 'Processing...',
        allowOutsideClick: false,
        showConfirmButton: false
    });
    editForm.patch(route('admin.update-fire-incident'), {
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

const deleteFireIncidentReportData = (id) => {
    const deleteForm = useForm({ id: id });
    SweetAlert.fire({
        icon: 'warning',
        title: 'Are you sure?',
        text: "This will remove the report permanently.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Delete it!'
    }).then((result) => {
        if (result.value) {
            deleteForm.delete(route('admin.delete-fire-incident'));
           SweetAlert.close();
        }
    })
};

</script>

<template>
    <div class="container-scroller">

     <Navbar :page="'Fire Incident Report'"/>

     <div class="container-fluid page-body-wrapper">

     <Sidebar />

     <div class="main-panel">
          <div class="content-wrapper">

            <!-- MODALS -->

            <div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Create Fire Incident Report</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" @submit.prevent="createFireIncidentReportData">
                            <div class="modal-body">

                                <div class="alert alert-danger" v-if="createForm.error">
                                    {{ createForm.error }}
                                </div>

                                <div class="row">
                                    <div class="col-md-6">

                                        <label for="" class="mb-1">Owner</label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="createForm.owner" required>

                                        <label for="" class="mb-1">Location</label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="createForm.location" required>

                                        <label for="" class="mb-1">Fire Alarm Level</label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="createForm.fireAlarmLevel" required>

                                        <label for="" class="mb-1">Date</label>
                                        <input type="date" class="form-control form-control-sm mb-3" v-model="createForm.date" required>

                                        <label for="" class="mb-1">Time</label>
                                        <input type="time" class="form-control form-control-sm mb-3" v-model="createForm.time" required>

                                    </div>
                                    <div class="col-md-6">

                                        <label for="" class="mb-1">Casualties</label>
                                        <input type="number" min="0" class="form-control form-control-sm mb-3" v-model="createForm.casualties" required>
                                        
                                        <label for="" class="mb-1">Inujuries</label>
                                        <input type="number" min="0" class="form-control form-control-sm mb-3" v-model="createForm.injuries" required>

                                        <label for="" class="mb-1">Cause of Fire</label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="createForm.fireCause" required>
                                        
                                        <label for="" class="mb-1">Type of Structure</label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="createForm.structureType" required>

                                        <label for="" class="mb-1">Estimated Value Loss</label>
                                        <input type="number" min="0" step="0.01" class="form-control form-control-sm mb-3" v-model="createForm.estimatedValueLoss" required>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Edit Fire Incident Report</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" @submit.prevent="updateFireIncidentReportData">
                            <div class="modal-body">

                                <div class="alert alert-danger" v-if="editForm.error">
                                    {{ editForm.error }}
                                </div>

                                <div class="row">
                                    <div class="col-md-6">

                                        <label for="" class="mb-1">Owner</label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="editForm.owner" required>

                                        <label for="" class="mb-1">Location</label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="editForm.location" required>

                                        <label for="" class="mb-1">Fire Alarm Level</label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="editForm.fireAlarmLevel" required>

                                        <label for="" class="mb-1">Date</label>
                                        <input type="date" class="form-control form-control-sm mb-3" v-model="editForm.date" required>

                                        <label for="" class="mb-1">Time</label>
                                        <input type="time" class="form-control form-control-sm mb-3" v-model="editForm.time" required>

                                    </div>
                                    <div class="col-md-6">

                                        <label for="" class="mb-1">Casualties</label>
                                        <input type="number" min="0" class="form-control form-control-sm mb-3" v-model="editForm.casualties" required>
                                        
                                        <label for="" class="mb-1">Inujuries</label>
                                        <input type="number" min="0" class="form-control form-control-sm mb-3" v-model="editForm.injuries" required>

                                        <label for="" class="mb-1">Cause of Fire</label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="editForm.fireCause" required>
                                        
                                        <label for="" class="mb-1">Type of Structure</label>
                                        <input type="text" class="form-control form-control-sm mb-3" v-model="editForm.structureType" required>

                                        <label for="" class="mb-1">Estimated Value Loss</label>
                                        <input type="number" min="0" step="0.01" class="form-control form-control-sm mb-3" v-model="editForm.estimatedValueLoss" required>

                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="" class="btn btn-sm btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- PAGE CONTENT -->

              <div class="row">

                <div class="col-md-4">
                    <form action="" @submit.prevent="searchYear">
                        <div class="d-flex justify-content-between aligh-items-center mb-4">
                            <select v-model="searchForm.search" id="year" class="form-control mr-4" style="border-radius: 5px;" required>
                                <option value="">Select Year ...</option>
                                <option v-for="year in years" :key="year" :value="year">
                                    {{ year }}
                                </option>
                            </select>
                            <button
                                class="btn btn-success ms-3 d-flex justify-content-center align-items-center shadow-md">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </div>
                    </form>
                </div>

               <div class="col-md-12">
                    <div class="card rounded-md">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="fw-bold">List of Fire Incidents <b>{{ year }}</b></h6>
                                <button class="btn btn-primary shadow-lg btn-sm" @click="createFireIncidentReport"> +
                                    Add</button>
                            </div>
                        </div>

                        <div class="card-body shadow-md">
                            <div class="table-responsive">
                                <table class="table text-nowrap" id="fire-incident-table">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 13px;">Information</th>
                                            <th style="font-size: 13px;">Fire Alarm Level</th>
                                            <th style="font-size: 13px;">Casualties/Injuries</th>
                                            <th style="font-size: 13px;">Cause of Fire</th>
                                            <th style="font-size: 13px;">Estimated Value Loss</th>
                                            <th style="font-size: 13px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(fi, index) in fireIncident" :key="fi.id">
                                            <td>
                                                <div class="p-1"><span class="text-muted">Owner:</span> {{ fi.owner }}</div>
                                                <div class="p-1"><span class="text-muted">Location:</span> {{ fi.location }}</div>
                                                <div class="p-1"><span class="text-muted">DateTime:</span> {{ formatDate(fi.date) }} | {{ formatTime12Hour(fi.time) }}</div>
                                                <div class="p-1"><span class="text-muted">Structure Type:</span> {{ fi.structureType }}</div>
                                            </td>
                                            <td>
                                                <div class="text-danger">{{ fi.fireAlarmLevel }}</div>
                                            </td>
                                            <td>
                                                <div class="p-1"><span class="text-muted">Casualties:</span> <span class="font-weight-bold" style="font-size: 20px;">{{ fi.casualties }}</span></div>
                                                <div class="p-1"><span class="text-muted">Injuries:</span> <span class="font-weight-bold" style="font-size: 20px;">{{ fi.injuries }}</span></div>
                                            </td>
                                            <td>
                                                {{ fi.fireCause }}
                                            </td>
                                            <td>
                                                ₱ {{ formatNumber(fi.estimatedValueLoss) }}
                                            </td>
                                            <td>
                                                <a href="#" class="p-2" @click.prevent="editFireIncidentReport(
                                                   fi.id,
                                                   fi.owner,
                                                   fi.location,
                                                   fi.fireAlarmLevel,
                                                   fi.date,
                                                   fi.time,
                                                   fi.casualties,
                                                   fi.fireCause,
                                                   fi.injuries,
                                                   fi.structureType,
                                                   fi.estimatedValueLoss
                                                )">
                                                    <i class="fa-solid fa-pen-fancy"></i>
                                                </a>
                                                <a href="#" class="p-2" @click.prevent="deleteFireIncidentReportData(fi.id)">
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

<style>
.margin-end {
    margin-right: 10px;
}
</style>
