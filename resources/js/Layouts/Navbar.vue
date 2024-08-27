<script setup>

import { ref, onMounted } from 'vue';
import { usePage, Link, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const user = ref(null);
const notifCount = ref(null);
const notif = ref(null);

const props = defineProps({
  page: String,
})

const editProfileModal = ref(null);

const editProfileForm = useForm({
  id: null,
  name: null,
  contactNumber: null,
  file: null,
  email: null,
  password: null,
  error: null,
  status: null,
});

onMounted(() => {
  const page = usePage();
  user.value = page.props.auth;

  editProfileModal.value = new bootstrap.Modal($('#editProfileModal'), {
    keyboard: false
  });

  axios.get(route('notification'))
    .then(response => {
      notifCount.value = response.data.notifCount;
      notif.value = response.data.notif;
    })
    .catch(error => {
      console.error(error);
    });
});

const sidebar = () => {
  $(".sidebar-offcanvas").toggleClass("active");

}

const insidebar = () => {
  $(".sidebar-offcanvas").toggleClass("inactive");
  $(".main-panel").toggleClass("inactive");
  
  if ($(".sidebar-offcanvas").hasClass("inactive")) {
    $(".navbar-content").attr("id", "dirty-white");
  } else {
    $(".navbar-content").removeAttr("id", "dirty-white");
  }
}


const editProfile = (name, contactNumber, email) => {
  editProfileForm.name = name
  editProfileForm.contactNumber = contactNumber
  editProfileForm.email = email

  editProfileModal.value.show();
};

const editPicture = (event) => {
  editProfileForm.file = event.target.files[0];
};

const updateProfile = () => {
  SweetAlert.fire({
    position: 'center',
    icon: 'info',
    title: 'Processing...',
    allowOutsideClick: false,
    showConfirmButton: false
  });
  editProfileForm.post(route('update-profile'), {
    forceFormData: true,
    onFinish: () => {
      editProfileForm.error = editProfileForm.errors.error;
      editProfileForm.status = editProfileForm.errors.status;

      if (editProfileForm.status === 500) {
        SweetAlert.close();
        return false;
      } else {
        setTimeout(() => {
          editProfileModal.value.hide();
          SweetAlert.fire({
            icon: 'success',
            title: 'Done',
            text: 'Profile Updated Successfully',
            confirmButtonColor: "#3a57e8"
          });
        });
      }
    }
  });
};

</script>

<template>

  <!-- MODALS -->

  <div class="modal fade" id="editProfileModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Update Profile</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" @submit.prevent="updateProfile">
          <div class="modal-body">

            <div class="alert alert-danger" v-if="editProfileForm.error">
              {{ editProfileForm.error }}
            </div>

            <div class="row">
              <div class="col-md-12">

                <label for="">Name</label>
                <input type="text" class="form-control form-control-sm mb-3" v-model="editProfileForm.name" required>

                <div v-if="user?.role === 2 || user?.role === 3">

                  <label for="">Contact Number</label>
                  <input type="text" class="form-control form-control-sm mb-3" v-model="editProfileForm.contactNumber"
                    required>

                  <label for="" class="mb-1">Update Profile Picture</label>
                  <input type="file" class="form-control form-control-sm mb-3" @change="editPicture"
                    accept=".jpg, .png, .jpeg">

                </div>

                <label for="">Email</label>
                <input type="text" class="form-control form-control-sm mb-3" v-model="editProfileForm.email" required>

                <label for="">Change Password</label>
                <input type="password" class="form-control form-control-sm mb-3" v-model="editProfileForm.password">

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

  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row navbar-content">
    <div class="text-center d-flex align-items-center justify-content-center">
      <div class="d-flex justify-content-between align-items-center ml-lg-4 ml-2">
        <a class="" href="#"><img src="/images/logo-mini.svg" style="width: 40px;" alt="logo" /></a>
        <span style="margin-left: 8px;" class="font-weight-bold text-primary d-none d-lg-block">BFP MIS</span>
      </div>

      <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex ml-4" @click="insidebar" type="button"
        data-toggle="minimize">
        <iconify-icon icon="icon-park-twotone:menu-fold-one" width="24" height="24" class="text-muted"></iconify-icon>
      </button>
    </div>

    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end" style="background: #F5F5F5;">
      <ul class="navbar-nav mr-lg-2">

        <li class="nav-item d-none d-lg-flex">
          <a class="nav-link active" href="#">
            {{ page }}
          </a>
        </li>
      </ul>
      <span class="mr-4 font-weight-bold d-sm-flex d-lg-none">Bureau of Fire Protection</span>
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item dropdown d-flex">
          <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
            id="notificationDropdown" href="#" data-toggle="dropdown">
            <i class="typcn typcn-bell mr-0"></i>
            <span class="count bg-danger" v-if="notifCount != null">{{ notifCount }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
            aria-labelledby="notificationDropdown">
            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
            <a class="dropdown-item preview-item" v-for="(nf, index) in notif" v-if="user?.role === 1">

              <div class="preview-thumbnail">
                <div class="preview-icon bg-primary">
                  <i class="typcn typcn-info-large mx-0"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <h6 class="preview-subject font-weight-normal">New Inspection Request</h6>
                <p class="font-weight-light small-text mb-0">
                  <small>From: </small>{{ nf.applicant.name }}
                </p>
                <p>{{ timeAgo(nf.created_at) }}</p>
                <hr>
              </div>
            </a>

            <a class="dropdown-item preview-item" v-for="(nf, index) in notif" v-if="user?.role === 2">

              <div class="preview-thumbnail">
                <div class="preview-icon bg-warning">
                  <i class="typcn typcn-info-large mx-0"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <h6 class="preview-subject font-weight-normal">You have a new Scheduled Inspection</h6>
                <p class="font-weight-light small-text mb-0">
                  <small>From: </small>{{ nf.applicant.name }}
                <div><small>Date: </small> {{ formatDate(nf.schedule) }}</div>
                </p>
                <p>{{ timeAgo(nf.created_at) }}</p>
                <hr>
              </div>

            </a>

            <a class="dropdown-item preview-item" v-for="(nf, index) in notif" v-if="user?.role === 3">

              <div class="preview-thumbnail">
                <div class="preview-icon bg-success">
                  <i class="typcn typcn-info-large mx-0"></i>
                </div>
              </div>
              <div class="preview-item-content">
                <h6 class="preview-subject font-weight-normal">Your Inspection Request has been approved</h6>
                <p class="font-weight-light small-text mb-0">
                <div><small>Sheduled On: </small> {{ formatDate(nf.schedule) }}</div>
                </p>
                <p>{{ timeAgo(nf.created_at) }}</p>
                <hr>
              </div>

            </a>
          </div>
        </li>
        <li class="nav-item nav-profile dropdown">
          <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
            <i class="typcn typcn-user-outline mr-0"></i>
            <span class="nav-profile-name" v-if="user?.role === 1">{{ user?.name }}</span>
            <span class="nav-profile-name" v-if="user?.role === 2">{{ user?.personnel.name }}</span>
            <span class="nav-profile-name" v-if="user?.role === 3">{{ user?.applicant.name }}</span>
          </a>
          <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
            <a class="dropdown-item" @click.prevent="editProfile(user?.name, null, user?.email)" href="#"
              v-if="user?.role === 1">
              <i class="fa-solid fa-user"></i> My Account
            </a>
            <a class="dropdown-item"
              @click.prevent="editProfile(user?.personnel.name, user?.personnel.contactNumber, user?.email)" href="#"
              v-if="user?.role === 2">
              <i class="fa-solid fa-user"></i> My Account
            </a>
            <a class="dropdown-item"
              @click.prevent="editProfile(user?.applicant.name, user?.applicant.contactNumber, user?.email)" href="#"
              v-if="user?.role === 3">
              <i class="fa-solid fa-user"></i> My Account
            </a>
            <hr>
            <Link :href="route('logout')" class="dropdown-item">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </Link>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" @click="sidebar"
        data-toggle="offcanvas">
        <iconify-icon icon="icon-park-twotone:menu-fold-one" width="24" height="24" class="text-dark mt-1"></iconify-icon>
      </button>
    </div>
  </nav>
</template>

<script>

var SweetAlert = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-sm btn-danger margin-end',
    cancelButton: 'btn btn-sm btn-secondary'
  },
  buttonsStyling: false
});

const timeAgo = (dateString) => {
  const now = new Date();
  const then = new Date(dateString);
  const seconds = Math.floor((now - then) / 1000);
  let interval = Math.floor(seconds / 31536000);

  if (interval >= 1) {
    return then.toLocaleString();
  }
  interval = Math.floor(seconds / 2592000);
  if (interval >= 1) {
    return then.toLocaleString();
  }
  interval = Math.floor(seconds / 86400);
  if (interval >= 2) {
    return then.toLocaleString();
  } else if (interval >= 1) {
    return `${interval} day ago`;
  }
  interval = Math.floor(seconds / 3600);
  if (interval >= 1) {
    return `${interval} hour${interval !== 1 ? 's' : ''} ago`;
  }
  interval = Math.floor(seconds / 60);
  if (interval >= 1) {
    return `${interval} minute${interval !== 1 ? 's' : ''} ago`;
  }
  return 'just now';
};

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

#dirty-white {
  background: #F5F5F5;
}

@media (max-width: 991px) {
  .navbar-content {
    background: #F5F5F5;
  }
}
</style>