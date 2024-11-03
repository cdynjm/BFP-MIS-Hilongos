<script setup>

import { Link, useForm } from '@inertiajs/vue3';

import Navbar from '@/Layouts/Navbar.vue';
import Sidebar from '@/Layouts/Sidebar.vue';
import Footer from '@/Layouts/Footer.vue';
import * as XLSX from 'xlsx';
import { ref, onMounted } from 'vue';

const props = defineProps({
    auth: Array,
    id: Number,
    encryptedID: String,
    inspections: Array,
    personnel: Array,
    today: Date,
    municipal: String,
    barangay: Array
})

const certificateModal = ref(null);
const updateModal = ref(null);

onMounted(() => {

    certificateModal.value = new bootstrap.Modal($('#certificateModal'), {
        keyboard: false
    });

    updateModal.value = new bootstrap.Modal($('#updateModal'), {
        keyboard: false
    });

    $('#inspection-table').DataTable();

});

const searchForm = useForm({
    searchYear: null,
    searchMonth: null,
    result: 0,
});

const currentYear = new Date().getFullYear();
const startYear = 2020;
const years = Array.from({ length: currentYear - startYear + 1 }, (_, i) => startYear + i);

// Array of month names
const months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

// Initialize selected year and month to empty values
searchForm.searchYear = '';
searchForm.searchMonth = '';

const searchYearMonth = () => {
    searchForm.get(route('admin.search-year-month', {id: props.encryptedID}));
};

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

const uploadForm = useForm({
    id: null,
    name: null,
    file: null,
    picture: null,
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
            completeForm.patch(route('admin.complete-inspection'));
            SweetAlert.fire({
                icon: 'success',
                title: 'Done',
                text: 'Updated successfully',
                confirmButtonColor: "#3a57e8"
            });
        }
    })
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

const handleFileChange = async (event) => {
  const file = event.target.files[0];
  
  if (!file) return; // Exit if no file is selected

  const maxSizeInMB = 2;
  const maxSizeInBytes = maxSizeInMB * 1024 * 1024;

  // Check if the file is an image
  if (file.type.startsWith('image')) {
    const compressedFile = await compressImage(file, { quality: 0.3, type: file.type });
    uploadForm.file = compressedFile;
  } else {
    // For non-image files, check file size
    if (file.size > maxSizeInBytes) {
      event.target.value = ''; // Clear the file input
      
      // Show SweetAlert notification
      SweetAlert.fire({
        icon: 'error',
        title: 'File too large',
        text: `Please select a file smaller than ${maxSizeInMB}MB.`,
        confirmButtonText: 'OK',
      });
    } else {
      uploadForm.file = file; // Assign if it's within size limits
    }
  }
};

const handlePictureChange = async (event) => {
    const file = event.target.files[0];
  if (file && file.type.startsWith('image')) {
    const compressedFile = await compressImage(file, { quality: 0.3, type: file.type });
    uploadForm.picture = compressedFile;
  } else {
    uploadForm.picture = file; // Assign if it's not an image
  }
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
            uploadForm.post(route('admin.upload-form'), {
                forceFormData: true,
                onSuccess: () => {
                    updateModal.value.hide();
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
            deleteForm.delete(route('admin.delete-form'));
            SweetAlert.fire({
                icon: 'success',
                title: 'Done',
                text: 'File deleted successfully',
                confirmButtonColor: "#3a57e8"
            });
        }
    })
};

const rescheduleForm = useForm({
    id: null,
    date: null
});

const reschedule = () => {
    SweetAlert.fire({
        icon: 'question',
        title: 'Reschedule Inspection?',
        text: "This will reschedule the personnel's visit for inspection.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Confirm!'
    }).then((result) => {
        if (result.value) {
            rescheduleForm.patch(route('admin.reschedule'));
            rescheduleForm.date = null;
            updateModal.value.hide();
            SweetAlert.fire({
                icon: 'success',
                title: 'Done',
                text: 'Inspection rescheduled successfully',
                confirmButtonColor: "#3a57e8"
            });
        }
    })
};

const generateCertificateForm = useForm({
    id: null,
    certType: null,
    building: null,
    owner: null,
    description: null,
    validFrom: null,
    validUntil: null,
    address: null,
    fsicfsecNumber: null,
    date: null,
    amountPaid: null,
    ORNumber: null,
    recommendedApproval: null,
    approvedBy: null,
    inspectionOrderNumber: null,
    ditControlNumber: null,
    buildingNumber: null
});

const generateCertificate = (id, name, address, building, certType) => {
    generateCertificateForm.id = id;
    generateCertificateForm.building = building;
    generateCertificateForm.owner = name;
    generateCertificateForm.address = address
    generateCertificateForm.certType = certType;

    certificateModal.value.show();
}

const generateCertificateFormData = () => {
    SweetAlert.fire({
        icon: 'question',
        title: 'Generate Certificate',
        text: "This will generate the certificate for the applicant. Action cannot be undo.",
        showCancelButton: true,
        confirmButtonColor: '#160e45',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Confirm!'
    }).then((result) => {
        if (result.value) {
            generateCertificateForm.patch(route('admin.generate-certificate'));
            certificateModal.value.hide();
            SweetAlert.fire({
                icon: 'success',
                title: 'Done',
                text: 'Certificate Generated successfully. Please view the certificate indicated in the table',
                confirmButtonColor: "#3a57e8"
            });
        }
    })
};

const updateStatus = (id, name) => {
    uploadForm.id = id;
    uploadForm.name = name;
    rescheduleForm.id = id;
    updateModal.value.show()
}

const downloadExcel = () => {
    if (props.inspections.length === 0) {
        SweetAlert.fire({
            icon: 'info',
            title: 'No Data',
            text: 'There is no data to be downloaded.',
            confirmButtonText: 'OK'
        });
        return;
    }

    const data = [
        ["Report Title", "BFP FIRE INSPECTION/EVALUATION MONTHLY REPORT"],
        ["Report Month/Year", formatMonthYear(props.today)],
        [],
        ["No.", "Establishment/Building Name", "Owner", "Municipal", "Barangay", "Description", "FSIC/FSEC Number", "Date FSEC/FSIC", "Valid Until", "Amount Paid", "OR Number", "Date of OR", "Recommended Approval", "Approved By", "Inspector", "Inspection Order Number", "Date of Inspection", "DIT Control Number", "Business/Building Number", "Owner Contact Number", "Owner Email", "Cert Type"],
    ];

    props.inspections.forEach((inspection, index) => {
        let certTypeName;
        if (inspection.certType === 1) {
            certTypeName = "Fire Safety Evaluation Clearance";
        } else if (inspection.certType === 2) {
            certTypeName = "Fire Safety Inspection Certificate (Occupancy)";
        } else if (inspection.certType === 3) {
            certTypeName = "Fire Safety Inspection Certificate (Business)";
        } else {
            certTypeName = "Unknown Certificate Type";
        }

        data.push([
            index + 1,
            inspection.buildingName,
            inspection.applicant.name,
            'Hilongos',
            inspection.address,
            inspection.description,
            inspection.certType === 1 ? inspection.FSECNumber : inspection.FSICNumber,
            inspection.certType === 1 ? formatFullDate(inspection.dateFSEC) : formatFullDate(inspection.dateFSIC),
            (inspection.certType === 2 || inspection.certType === 3) ? formatFullDate(inspection.validUntil) : '-',
            inspection.amountPaid,
            inspection.ORNumber,
            formatFullDate(inspection.dateOR),
            inspection.recommendApproval,
            inspection.approved,
            inspection.personnel.name,
            inspection.inspectionOrderNumber,
            formatFullDate(inspection.schedule),
            inspection.ditControlNumber,
            inspection.buildingNumber,
            inspection.applicant.contactNumber,
            inspection.user.email,
            certTypeName
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
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 },
        { wpx: 200 }
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
    a.download = `Fire Inspections - ${formatMonthYear(props.today)} Report.xlsx`;
    document.body.appendChild(a);
    a.click();

    document.body.removeChild(a);
    URL.revokeObjectURL(url);
};



</script>

<template>
    <div class="container-scroller">

        <Navbar v-if="id === 1" :page="'Pending'" />
        <Navbar v-if="id === 2" :page="'Scheduled'" />
        <Navbar v-if="id === 3" :page="'Inspection History'" />

        <div class="container-fluid page-body-wrapper">

            <Sidebar />

            <div class="main-panel">
                <div class="content-wrapper">

                    <div class="modal fade" id="certificateModal" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Generate Certificate</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" @submit.prevent="generateCertificateFormData">
                                    <div class="modal-body">

                                        <div class="row">
                                            <div class="col-md-6">

                                                <label for="">Building Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm mb-3"
                                                    v-model="generateCertificateForm.building" required>

                                                <label for="">Owner <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm mb-3"
                                                    v-model="generateCertificateForm.owner" required>

                                                    <label for="" class="mb-1">Municipal <span class="text-danger text-xs">*</span></label>
                                                    <input type="text" class="form-control mb-3" :value="municipal.citymunDesc" readonly>

                                                    <label for="" class="mb-1">Barangay <span class="text-danger text-xs">*</span></label>
                                                    <select name="" id="" class="form-control mb-3" v-model="generateCertificateForm.address" required>
                                                        <option v-for="(br, index) in barangay" :value="br.brgyDesc">
                                                            {{ br.brgyDesc }}
                                                        </option>
                                                    </select>
                                              
                                                <div
                                                    v-if="generateCertificateForm.certType === 2 || generateCertificateForm.certType === 3">
                                                    <label for="">Description <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm mb-3"
                                                        v-model="generateCertificateForm.description" required>

                                                    <label for="">Valid From <span class="text-danger">*</span></label>
                                                    <input type="date"
                                                        class="form-control form-control-sm mb-3"
                                                        v-model="generateCertificateForm.validFrom">

                                                    <label for="">Valid Until <span class="text-danger">*</span></label>
                                                    <input type="date"
                                                        class="form-control form-control-sm mb-3"
                                                        v-model="generateCertificateForm.validUntil">
                                                </div>

                                                <label for="" v-if="generateCertificateForm.certType === 1">FSEC
                                                    Number <span class="text-danger">*</span></label>
                                                <label for=""
                                                    v-if="generateCertificateForm.certType === 2 || generateCertificateForm.certType === 3">FSIC
                                                    Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm mb-3"
                                                    v-model="generateCertificateForm.fsicfsecNumber" required>

                                                <label for="">Date <span class="text-danger">*</span></label>
                                                <input type="date"
                                                    class="form-control form-control-sm mb-3"
                                                    v-model="generateCertificateForm.date" required>

                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Amount Paid <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control form-control-sm mb-3"
                                                    v-model="generateCertificateForm.amountPaid" min="0" step="0.01"
                                                    required>

                                                <label for="">OR Number <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm mb-3"
                                                    v-model="generateCertificateForm.ORNumber" required>

                                                <label for="">Recommended Approval: <span class="text-danger">*</span></label>
                                                <select name="" id="" class="form-control form-control-sm mb-3"
                                                    v-model="generateCertificateForm.recommendedApproval" required>
                                                    <option value="">Select...</option>
                                                    <option v-for="(ps, index) in personnel" :value="ps.id">{{ ps.name
                                                        }}</option>
                                                </select>

                                                <label for="">Approved By: <span class="text-danger">*</span></label>
                                                <select name="" id="" class="form-control form-control-sm mb-3"
                                                    v-model="generateCertificateForm.approvedBy" required>
                                                    <option value="">Select...</option>
                                                    <option v-for="(ps, index) in personnel" :value="ps.id">{{ ps.name
                                                        }}</option>
                                                </select>

                                                <div>
                                                    <label for="">Inspection Order Number <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm mb-3"
                                                        v-model="generateCertificateForm.inspectionOrderNumber" required>

                                                    <label for="">DIT Control Number <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control form-control-sm mb-3"
                                                        v-model="generateCertificateForm.ditControlNumber" required>

                                                    <label for="">Business/Building Number <span class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control form-control-sm mb-3"
                                                        v-model="generateCertificateForm.buildingNumber" required>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="" class="btn btn-sm btn-primary">Generate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

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
                                                <label for="">Upload Checklist Form <span class="text-danger text-xs">*</span></label>
                                                <input type="file" class="form-control form-control-sm mb-3"
                                                    @change="handleFileChange" accept=".pdf, .jpg"
                                                    required>

                                                <label for="">Upload Picture for Proof <span class="text-danger text-xs">*</span></label>
                                                <input type="file" class="form-control form-control-sm mb-3"
                                                    @change="handlePictureChange" accept=".jpg"
                                                    required>
                                                    
                                                <button class="btn btn-sm btn-info">Upload</button>
                                            </form>
                                        </div>
                                        <div class="col-md-12">
                                            <form action="" @submit.prevent="reschedule()">
                                                <label class="text-dark text-muted">Reschedule
                                                    Visit/Inspection <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control form-control-sm mb-3"
                                                    v-model="rescheduleForm.date" :min="today" required>
                                                <button class="btn btn-sm btn-info">Set</button>
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

                    <div class="row overflowx-auto">

                        <div class="col-md-8" v-if="id === 3">
                            <form action="" @submit.prevent="searchYearMonth">
                                <div class="d-flex justify-content-between align-items-center mb-4 mt-1">
                                    <!-- Year Selector -->
                                    <select v-model="searchForm.searchYear" id="year" class="form-control mr-3"
                                        style="border-radius: 5px;" required>
                                        <option value="">Select Year ...</option>
                                        <option v-for="year in years" :key="year" :value="year">
                                            {{ year }}
                                        </option>
                                    </select>

                                    <!-- Month Selector -->
                                    <select v-model="searchForm.searchMonth" id="month" class="form-control mr-3"
                                        style="border-radius: 5px;" required>
                                        <option value="">Select Month ...</option>
                                        <option v-for="(month, index) in months" :key="index" :value="String(index + 1).padStart(2, '0')">
                                            {{ month }}
                                        </option>

                                    </select>

                                    <!-- Search Button -->
                                    <button
                                        class="btn btn-dark btn-sm ms-3 d-flex justify-content-center align-items-center shadow-md rounded-md">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>

                        </div>
                        <div class="col-md-4">
                            <div class="mb-3" v-if="id === 3">
                            <button @click="downloadExcel" style="font-size: 11px; font-weight: normal; padding: 5px 5px 5px; margin-top: 5px;" class="btn btn-success btn-sm d-flex align-items-center">
                                <iconify-icon icon="iwwa:file-csv" width="20"></iconify-icon> <span>Download Report</span>
                            </button></div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="card rounded-md">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="fw-bold" v-if="id === 1">Pending</h6>
                                        <h6 class="fw-bold" v-if="id === 2">Scheduled</h6>
                                        <h6 class="fw-bold" v-if="id === 3">Inspection History</h6>
                                        <h6 class="fw-bold" v-if="id === 3" style="font-weight: bold; font-size: 16px">{{ formatMonth(today) }}</h6>
                                    </div>
                                </div>

                                <div class="card-body shadow-md">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap" id="inspection-table">
                                            <thead>
                                                <tr>
                                                    <th style="font-size: 13px;">Information</th>
                                                    <th style="font-size: 13px;">Status</th>
                                                    <th style="font-size: 13px;" v-if="id === 2 || id === 3">
                                                        Files</th>
                                                    <th style="font-size: 13px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(ip, index) in inspections">

                                                    <td>
                                                        <div style="display: flex; align-items: flex-start;">
                                                            <img :src="'/storage/profile/' + ip.applicant.picture"
                                                                style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px; box-shadow: 2px 5px 10px gray;"
                                                                class="mb-3" alt="">


                                                            <div style="margin-left: 15px;">
                                                                <div class="p-1"><span class="text-muted">Owner:</span>
                                                                    {{ ip.applicant.name }}</div>
                                                                <div class="p-1"><span class="text-muted">Phone:</span>
                                                                    {{ ip.applicant.contactNumber }}</div>
                                                                <div class="p-1"><span
                                                                        class="text-muted">Address:</span> {{ ip.purok }},  {{ ip.address
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
                                                        <span class="text-danger" v-if="ip.status === 1">Pending</span>
                                                        <span class="text-warning" v-if="ip.status === 2">
                                                            <div class="mb-2">
                                                                Scheduled on {{ formatDate(ip.schedule) }}
                                                            </div>
                                                            <div>
                                                                Personnel: {{ ip.personnel.name }}
                                                            </div>

                                                        </span>
                                                        <p class="text-success" v-if="ip.status === 3">
                                                        <div>Done</div>
                                                        <div>Inspected On: {{ formatDate(ip.schedule) }}</div>
                                                        <div class="text-gray">By: {{ ip.personnel.name }}</div>
                                                        </p>
                                                    </td>
                                                    <td v-if="id === 2 || id === 3" class="">


                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex flex-column">
                                                                <a :href="`/storage/files/${ip.file}`" v-if="ip.file != null"  class="text-decoration-none mb-2">
                                                                    <i class="fa-solid fa-file-pdf"></i> Checklist Form
                                                                </a>

                                                                <a :href="`/storage/files/${ip.picture}`" v-if="ip.file != null"  class="text-decoration-none">
                                                                    <i class="fa-solid fa-images"></i> Picture/Image
                                                                </a>
                                                            </div>

                                                            <a href="#" class="ml-2 text-danger" v-if="ip.file != null && id === 2" @click.prevent="deleteFile(ip.id)">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a>
                                                        </div>

                                                        <p v-if="ip.file === null" class="text-danger"
                                                            style="font-size: 12px;">No File Yet</p>
                                                    </td>
                                                    <td v-if="id === 1">
                                                        <form action="" class="text-center"
                                                            @submit.prevent="setSchedule(ip.id)">
                                                            <label for=""><small>Schedule</small></label>
                                                            <input type="date" v-model="createForm.schedule"
                                                                class="form-control form-control-sm mr-2 mb-2"
                                                                :min="today" required>

                                                            <label for=""><small>Personnel</small></label>
                                                            <select name="" id="" v-model="createForm.personnel"
                                                                class="form-control form-control-sm mb-4" required>
                                                                <option value="">Select...</option>
                                                                <option v-for="(ps, index) in personnel" :value="ps.id">
                                                                    {{ ps.name }}</option>
                                                            </select>

                                                            <button class="btn btn-sm btn-success"><i
                                                                    class="fa-solid fa-check"></i></button>

                                                        </form>
                                                    </td>
                                                    <td v-if="id === 2" class="text-center">
                                                        <button class="btn btn-sm btn-success p-1"
                                                            style="font-size: 12px;"
                                                            @click.prevent="completeInspection(ip.id)"
                                                            :disabled="ip.file === null && ip.picture == null"><i class="fa-solid fa-check"
                                                                style="font-size: 12px;"></i> Done</button>
                                                        <i class="text-danger d-block mt-3" style="font-size: 12px;"
                                                            v-if="ip.file == null">Please upload the checklist form
                                                            first</i>
                                                        <button class="btn btn-sm btn-info mt-3 p-1"
                                                            @click.prevent="updateStatus(ip.id, ip.applicant.name)"
                                                            v-if="ip.file === null && ip.picture == null" style="font-size: 12px;">
                                                            <i class="fa-solid fa-pen-fancy"
                                                                style="font-size: 12px;"></i> Edit
                                                        </button>
                                                    </td>
                                                    <td v-if="id === 3" class="">
                                                        <button class="btn btn-sm btn-info"
                                                            @click.prevent="generateCertificate(ip.id, ip.applicant.name, ip.address, ip.buildingName, ip.certType)"
                                                            v-if="ip.certStatus === null">
                                                            <small>
                                                                <i class="fa-solid fa-file-import mr-2"></i> Generate
                                                                Certificate
                                                            </small>
                                                        </button>

                                                        <a :href="`/admin/certificate/${ip.id}`"
                                                            v-if="ip.certStatus != null" 
                                                            class="nav-link">
                                                            <i class="fa-solid fa-file-pdf"></i>
                                                            <span v-if="ip.certType === 1"> FSEC Certificate</span>
                                                            <span v-if="ip.certType === 2"> FSIC Certificate
                                                                (Occupancy)</span>
                                                            <span v-if="ip.certType === 3"> FSIC Certificate
                                                                (Business)</span>
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

function formatMonth(dateString) {
    const options = { year: 'numeric', month: 'long' };
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', options);
}

function formatMonthYear(dateString) {
    const options = { month: 'long', year: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', options);
}

function formatFullDate(dateString) {
    const options = { month: 'short', day: 'numeric', year: 'numeric' };
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', options);
}

</script>

<style>
.margin-end {
    margin-right: 10px;
}
</style>
