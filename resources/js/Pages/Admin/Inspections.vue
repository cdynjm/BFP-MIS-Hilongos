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
    personnel: Array,
    today: Date
})

onMounted(() => {

    $('#inspection-table').DataTable();
    
});

const createForm = useForm({
    id: null,
    schedule: null,
    personnel: null,
    error: null,
    status: null,
});

const setSchedule = (id) => {
    createForm.id = id;
    SweetAlert.fire({
        icon: 'question',
        title: 'Are you sure?',
        text: "This will set the applicant's schedule for inspection.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Confirm!'
    }).then((result) => {
        if (result.value) {
            createForm.patch(route('admin.schedule-inspection'));
            SweetAlert.fire({
                icon: 'success',
                title: 'Done',
                text: 'Schedule has been set successfully',
                confirmButtonColor: "#3a57e8"
            });
        }
    })
};

</script>

<template>
    <div class="container-scroller">

     <Navbar v-if="id === 1" :page="'Pending'"/>
     <Navbar v-if="id === 2" :page="'Scheduled'"/>
     <Navbar v-if="id === 3" :page="'Archives'"/>

     <div class="container-fluid page-body-wrapper">

     <Sidebar />

     <div class="main-panel">
          <div class="content-wrapper">

            <!-- PAGE CONTENT -->

              <div class="row overflowx-auto">
                  
                <div class="col-md-12">
                        <div class="card rounded-md">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="fw-bold" v-if="id === 1">Pending</h6>
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
                                                <th style="font-size: 13px;">Permit & Numbers</th>
                                                <th style="font-size: 13px;">Status</th>
                                                <th style="font-size: 13px;" v-if="id === 1 || id === 3">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(ip, index) in inspections">
                                                
                                                <td>
                                                    <div class="p-1"><span class="text-muted">Building Name:</span> {{ ip.buildingName }}</div>
                                                    <div class="p-1"><span class="text-muted">Owner:</span> {{ ip.applicant.name }}</div>
                                                    <div class="p-1"><span class="text-muted">Phone:</span> {{ ip.applicant.contactNumber }}</div>
                                                    <div class="p-1"><span class="text-muted">Address:</span> {{ ip.address }}</div>
                                                    <div class="p-1"><span class="text-muted">Business Name:</span> {{ ip.businessName }}</div>
                                                    <div class="p-1"><span class="text-muted">Nature:</span> {{ ip.businessNature }}</div>
                                                </td>
                                                <td>
                                                    <div class="p-1"><span class="text-muted">FSEC No.:</span> {{ ip.FSECNumber }} - {{ formatDate(ip.dateFSEC) }}</div>
                                                    <div class="p-1"><span class="text-muted">Building Permit:</span> {{ ip.buildingPermit }} - {{ formatDate(ip.dateBuildingPermit) }}</div>
                                                    <div class="p-1"><span class="text-muted">FSIC No.:</span> {{ ip.FSICNumber }} - {{ formatDate(ip.dateFSIC) }}</div>
                                                    <div class="p-1"><span class="text-muted">Business Permit No.:</span> {{ ip.permitNumber }} - {{ formatDate(ip.datePermitNumber) }}</div>
                                                    <div class="p-1"><span class="text-muted">Fire Insurance Policy No.:</span> {{ ip.fireInsurance }} - {{ formatDate(ip.dateFireInsurance) }}</div>
                                                </td>
                                                <td>
                                                    <span class="text-danger" v-if="ip.status === 1">Pending</span>
                                                    <span class="text-warning" v-if="ip.status === 2">
                                                        <div class="mb-2">
                                                            Scheduled on {{ formatDate(ip.schedule) }}
                                                        </div>
                                                        <div>
                                                            Personnel: {{ ip.personnel.name }}
                                                        </div>
                                                    </span>
                                                    <p class="text-success text-center" v-if="ip.status === 3">
                                                        <div>Done</div>
                                                        <div>Inspected On: {{ formatDate(ip.schedule) }}</div>
                                                    </p>
                                                </td>
                                                <td v-if="id === 1">
                                                    <form action="" class="text-center" @submit.prevent="setSchedule(ip.id)">
                                                        <label for=""><small>Schedule</small></label>
                                                        <input type="date" v-model="createForm.schedule" class="form-control form-control-sm mr-2 mb-2" :min="today" required>
                                                        
                                                        <label for=""><small>Personnel</small></label>
                                                        <select name="" id="" v-model="createForm.personnel" class="form-control form-control-sm mb-4" required>
                                                            <option value="">Select...</option>
                                                            <option v-for="(ps, index) in personnel" :value="ps.id">{{ ps.name }}</option>
                                                        </select>

                                                        <button class="btn btn-sm btn-success"><i class="fa-solid fa-check"></i></button>
                                                       
                                                    </form>
                                                </td>
                                                <td v-if="id === 3" class="text-center">
                                                    <button class="btn btn-sm btn-info">
                                                        <small>
                                                            <i class="fa-solid fa-file-import mr-2"></i> Generate Certificate
                                                        </small>
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
