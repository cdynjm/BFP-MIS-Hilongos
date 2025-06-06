<script setup>

import { Link, useForm } from '@inertiajs/vue3';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';
import * as XLSX from 'xlsx';
import { ref, onMounted } from 'vue';

const props = defineProps({
    auth: Array,
    fireIncident: Array,
    year: String,
    municipal: Array,
    barangay: Object
})

const searchForm = useForm({
    search: null,
    result: 0,
});

const today = new Date().toISOString().split('T')[0];
const currentYear = new Date().getFullYear();
const startYear = 2020;
const years = Array.from({ length: currentYear - startYear + 1 }, (_, i) => startYear + i);

searchForm.search = '';

const searchYear = () => {
    searchForm.get(route('personnel.search-year'));
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
    createForm.post(route('personnel.create-fire-incident'), {
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
    editForm.patch(route('personnel.update-fire-incident'), {
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
            deleteForm.delete(route('personnel.delete-fire-incident'));
            SweetAlert.close();
        }
    })
};

const downloadExcel = () => {
    if (props.fireIncident.length === 0) {
        SweetAlert.fire({
            icon: 'info',
            title: 'No Data',
            text: 'There is no data to be downloaded.',
            confirmButtonText: 'OK'
        });
        return;
    }

    const data = [
        ["Report Title", "BFP FIRE INCIDENTS ANNUAL REPORT"],
        ["Report Year", props.year],
        [],
        ["No.", "Owner", "Location", "Fire Alarm Level", "Date", "Time", "Casualties", "Inujries", "Cause of Fire", "Structure Type", "Estimated Value Loss"],
    ];

    props.fireIncident.forEach((fireInc, index) => {
        
        let fireAlarm;

        if (fireInc.fireAlarmLevel === 1) {
            fireAlarm = "First Alarm";
        } else if (fireInc.fireAlarmLevel === 2) {
            fireAlarm = "Second Alarm";
        } else if (fireInc.fireAlarmLevel === 3) {
            fireAlarm = "Third Alarm";
        } else if (fireInc.fireAlarmLevel === 4) {
            fireAlarm = "Fourth Alarm";
        } else if (fireInc.fireAlarmLevel === 5) {
            fireAlarm = "Fifth Alarm";
        } else if (fireInc.fireAlarmLevel === 6) {
            fireAlarm = "Task Force Alpha";
        } else if (fireInc.fireAlarmLevel === 7) {
            fireAlarm = "Task Force Bravo";
        } else if (fireInc.fireAlarmLevel === 8) {
            fireAlarm = "Task Force Charlie";
        } else if (fireInc.fireAlarmLevel === 9) {
            fireAlarm = "Task Force Delta";
        } else if (fireInc.fireAlarmLevel === 10) {
            fireAlarm = "General Alarm";
        } else {
            fireAlarm = "";
        }

        data.push([
            index + 1,
            fireInc.owner,
            fireInc.location,
            fireAlarm,
            formatFullDate(fireInc.date),
            formatTime12Hour(fireInc.time),
            fireInc.casualties,
            fireInc.injuries,
            fireInc.fireCause,
            fireInc.structureType,
            fireInc.estimatedValueLoss
        ]);
    });

    const worksheet = XLSX.utils.aoa_to_sheet(data);
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, 'Report');

    const colWidth = [
        { wpx: 120 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 100 },
        { wpx: 100 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        
    ];
    worksheet['!cols'] = colWidth;

    const headerRow = 4;
    for (let col = 0; col < data[headerRow].length; col++) {
        const cellAddress = XLSX.utils.encode_cell({ r: headerRow, c: col });
        if (!worksheet[cellAddress]) {
            worksheet[cellAddress] = {};
        }

        worksheet[cellAddress].s = {
            font: { bold: true },
            fill: {
                fgColor: { rgb: "FFCCFF" }
            }
        };
    }

    const excelBuffer = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
    const blob = new Blob([excelBuffer], { type: 'application/octet-stream' });
    const url = URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = `Fire Incidents - ${props.year} Annual Report.xlsx`;
    document.body.appendChild(a);
    a.click();

    document.body.removeChild(a);
    URL.revokeObjectURL(url);
};

</script>

<template>
    <div class="container-scroller">

        <Navbar :page="'Fire Incident Report'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- MODALS -->

                    <div class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Create Fire Incident Report</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" @submit.prevent="createFireIncidentReportData">
                                    <div class="modal-body">

                                        <div class="alert alert-danger" v-if="createForm.error">
                                            {{ createForm.error }}
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">

                                                <label for="" class="mb-1">Owner/s of the Property Affected <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="" id="" class="form-control mb-3" rows="5"
                                                    v-model="createForm.owner" required></textarea>

                                                <label for="" class="mb-1">Municipal <span class="text-danger text-xs">*</span></label>
                                                <input type="text" class="form-control form-control-sm mb-3" :value="municipal.citymunDesc" readonly>

                                                <label for="" class="mb-1">Barangay <span class="text-danger text-xs">*</span></label>
                                                <select name="" id="" class="form-control mb-3" v-model="createForm.location" required>
                                                    
                                                    <option v-for="(br, index) in barangay" :value="br.brgyCode">
                                                        {{ br.brgyDesc }}
                                                    </option>
                                                </select>

                                                <label for="" class="mb-1">Highest Fire Alarm Level Raised <span
                                                        class="text-danger">*</span></label>
                                                <select name="" id="" class="form-control mb-3"
                                                    v-model="createForm.fireAlarmLevel" required>
                                                    <option :value="'1'">First Alarm</option>
                                                    <option :value="'2'">Second Alarm</option>
                                                    <option :value="'3'">Third Alarm</option>
                                                    <option :value="'4'">Fourth Alarm</option>
                                                    <option :value="'5'">Fifth Alarm</option>
                                                    <option :value="'6'">Task Force Alpha</option>
                                                    <option :value="'7'">Task Force Bravo</option>
                                                    <option :value="'8'">Task Force Charlie</option>
                                                    <option :value="'9'">Task Force Delta</option>
                                                    <option :value="'10'">General Alarm</option>
                                                </select>

                                                <label for="" class="mb-1">Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control form-control-sm mb-3"
                                                    :max="today" v-model="createForm.date" required>

                                                <label for="" class="mb-1">Time <span
                                                        class="text-danger">*</span></label>
                                                <input type="time" class="form-control form-control-sm mb-3"
                                                    v-model="createForm.time" required>

                                            </div>
                                            <div class="col-md-6">

                                                <label for="" class="mb-1">Casualties <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="0" class="form-control form-control-sm mb-3"
                                                    v-model="createForm.casualties" required>

                                                <label for="" class="mb-1">Inujuries <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="0" class="form-control form-control-sm mb-3"
                                                    v-model="createForm.injuries" required>

                                                <label for="" class="mb-1">Cause of Fire <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm mb-3"
                                                    v-model="createForm.fireCause" required>

                                                <label for="" class="mb-1">Type of Structure <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm mb-3"
                                                    v-model="createForm.structureType" required>

                                                <label for="" class="mb-1">Estimated Value Loss <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="0" step="0.01"
                                                    class="form-control form-control-sm mb-3"
                                                    v-model="createForm.estimatedValueLoss" required>

                                            </div>
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
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Edit Fire Incident Report</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" @submit.prevent="updateFireIncidentReportData">
                                    <div class="modal-body">

                                        <div class="alert alert-danger" v-if="editForm.error">
                                            {{ editForm.error }}
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">

                                                <label for="" class="mb-1">Owner/s of the Property Affected <span
                                                        class="text-danger">*</span></label>
                                                <textarea name="" id="" class="form-control mb-3" rows="5"
                                                    v-model="editForm.owner" required></textarea>

                                                <label for="" class="mb-1">Municipal <span class="text-danger text-xs">*</span></label>
                                                <input type="text" class="form-control form-control-sm mb-3" :value="municipal.citymunDesc" readonly>

                                                <label for="" class="mb-1">Barangay <span class="text-danger text-xs">*</span></label>
                                                <select name="" id="" class="form-control mb-3" v-model="editForm.location" required>
                                                    
                                                    <option v-for="(br, index) in barangay" :value="br.brgyCode">
                                                        {{ br.brgyDesc }}
                                                    </option>
                                                </select>


                                                <label for="" class="mb-1">Highest Fire Alarm Level Raised <span
                                                        class="text-danger">*</span></label>
                                                <select name="" id="" class="form-control mb-3"
                                                    v-model="editForm.fireAlarmLevel" required>
                                                    <option :value="'1'">First Alarm</option>
                                                    <option :value="'2'">Second Alarm</option>
                                                    <option :value="'3'">Third Alarm</option>
                                                    <option :value="'4'">Fourth Alarm</option>
                                                    <option :value="'5'">Fifth Alarm</option>
                                                    <option :value="'6'">Task Force Alpha</option>
                                                    <option :value="'7'">Task Force Bravo</option>
                                                    <option :value="'8'">Task Force Charlie</option>
                                                    <option :value="'9'">Task Force Delta</option>
                                                    <option :value="'10'">General Alarm</option>
                                                </select>

                                                <label for="" class="mb-1">Date <span
                                                        class="text-danger">*</span></label>
                                                <input type="date" class="form-control form-control-sm mb-3"
                                                    :max="today" v-model="editForm.date" required>

                                                <label for="" class="mb-1">Time <span
                                                        class="text-danger">*</span></label>
                                                <input type="time" class="form-control form-control-sm mb-3"
                                                    v-model="editForm.time" required>

                                            </div>
                                            <div class="col-md-6">

                                                <label for="" class="mb-1">Casualties <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="0" class="form-control form-control-sm mb-3"
                                                    v-model="editForm.casualties" required>

                                                <label for="" class="mb-1">Inujuries <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="0" class="form-control form-control-sm mb-3"
                                                    v-model="editForm.injuries" required>

                                                <label for="" class="mb-1">Cause of Fire <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm mb-3"
                                                    v-model="editForm.fireCause" required>

                                                <label for="" class="mb-1">Type of Structure <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm mb-3"
                                                    v-model="editForm.structureType" required>

                                                <label for="" class="mb-1">Estimated Value Loss <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" min="0" step="0.01"
                                                    class="form-control form-control-sm mb-3"
                                                    v-model="editForm.estimatedValueLoss" required>

                                            </div>
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

                        <div class="col-md-3">
                            <form action="" @submit.prevent="searchYear">
                                <div class="d-flex justify-content-between aligh-items-center mb-4">
                                    <select v-model="searchForm.search" id="year" class="form-control mr-4"
                                        style="border-radius: 5px;" required>
                                        <option value="">Select Year ...</option>
                                        <option v-for="year in years" :key="year" :value="year">
                                            {{ year }}
                                        </option>
                                    </select>
                                    <button
                                        class="btn btn-dark btn-sm ms-3 d-flex justify-content-center align-items-center shadow-md rounded-md">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-3">
                            <div class="mb-3">
                            <button @click="downloadExcel" style="font-size: 11px; font-weight: normal; padding: 5px 5px 5px;" class="btn btn-success btn-sm d-flex align-items-center">
                                <iconify-icon icon="iwwa:file-csv" width="20"></iconify-icon> <span>Download Report</span>
                            </button></div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold">List of Fire Incidents <b>{{ year }}</b></h6>
                                        <button class="btn btn-primary shadow-lg btn-sm"
                                            @click="createFireIncidentReport"> +
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
                                                        <div class="p-1"><span class="text-muted">Owner:</span> {{
                                                            fi.owner }}</div>
                                                        <div class="p-1"><span class="text-muted">Location:</span>
                                                            <span class="text-capitalize">
                                                                Brgy. {{ fi.brgy.brgyDesc }} {{ municipal.citymunDesc.toLowerCase() }} Leyte
                                                            </span>
                                                        </div>
                                                        <div class="p-1"><span class="text-muted">DateTime:</span> {{
                                                            formatDate(fi.date) }} | {{ formatTime12Hour(fi.time) }}
                                                        </div>
                                                        <div class="p-1"><span class="text-muted">Structure Type:</span>
                                                            {{ fi.structureType }}</div>
                                                    </td>
                                                    <td>
                                                        <div class="text-danger font-weight-bold"
                                                            v-if="fi.fireAlarmLevel === 1">First Alarm</div>
                                                        <div class="text-danger font-weight-bold"
                                                            v-if="fi.fireAlarmLevel === 2">Second Alarm</div>
                                                        <div class="text-danger font-weight-bold"
                                                            v-if="fi.fireAlarmLevel === 3">Third Alarm</div>
                                                        <div class="text-danger font-weight-bold"
                                                            v-if="fi.fireAlarmLevel === 4">Fourth Alarm</div>
                                                        <div class="text-danger font-weight-bold"
                                                            v-if="fi.fireAlarmLevel === 5">Fifth Alarm</div>
                                                        <div class="text-danger font-weight-bold"
                                                            v-if="fi.fireAlarmLevel === 6">Task Force Alpha</div>
                                                        <div class="text-danger font-weight-bold"
                                                            v-if="fi.fireAlarmLevel === 7">Task Force Bravo</div>
                                                        <div class="text-danger font-weight-bold"
                                                            v-if="fi.fireAlarmLevel === 8">Task Force Charlie</div>
                                                        <div class="text-danger font-weight-bold"
                                                            v-if="fi.fireAlarmLevel === 9">Task Force Delta</div>
                                                        <div class="text-danger font-weight-bold"
                                                            v-if="fi.fireAlarmLevel === 10">General Alarm</div>
                                                    </td>
                                                    <td>
                                                        <div class="p-1"><span class="text-muted">Casualties:</span>
                                                            <span class="font-weight-bold" style="font-size: 20px;">{{
                                                                fi.casualties }}</span>
                                                        </div>
                                                        <div class="p-1"><span class="text-muted">Injuries:</span> <span
                                                                class="font-weight-bold" style="font-size: 20px;">{{
                                                                    fi.injuries }}</span></div>
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
                                                        <a href="#" class="p-2"
                                                            @click.prevent="deleteFireIncidentReportData(fi.id)">
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

function formatFullDate(dateString) {
    const options = { month: 'short', day: 'numeric', year: 'numeric' };
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
