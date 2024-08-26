<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Footer from '@/Layouts/Guest-Footer.vue';

const form = useForm({
  email: null,
  password: null,
  name: null,
  contactNumber: null,
  file: null,
  remember: false,
  error: null,
  status: null
});

const createPicture = (event) => {
  form.file = event.target.files[0];
};

const submit = () => {
  form.post(route('register.authenticate'), {
    forceFormData: true,
    onFinish: () => {
      form.error = form.errors.error;
      form.status = form.errors.status;

      if (form.status === 500) {
        return false;
      }
    },
  });
};

</script>

<template>

  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5 shadow-lg rounded">
              <div class="brand-logo">
                <div class="d-flex justify-content-between align-items-center">
                  <img src="/images/bfp-2.png" style="width: 350px; height: auto;" class="" alt="logo">
                </div>
              </div>
              <h4 class="font-weight-bold mb-3">Create your BFP Applicant Account</h4>

              <div class="alert alert-danger" v-if="form.error">
                {{ form.error }}
              </div>

              <form class="mb-3" @submit.prevent="submit">
                <div class="form-group">
                  <label for="">Full Name</label>
                  <input type="text" class="form-control form-control-sm rounded" v-model="form.name" id=""
                    placeholder="Name" required>
                </div>
                <div class="form-group">
                  <label for="">Contact Number</label>
                  <input type="text" class="form-control form-control-sm rounded" v-model="form.contactNumber" id=""
                    placeholder="Contact Number" required>
                </div>
                <div class="form-group">
                  <label for="" class="mb-1">Profile Picture</label>
                  <input type="file" class="form-control form-control-sm rounded" @change="createPicture"
                    accept=".jpg, .png, .jpeg" required>
                </div>
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" class="form-control form-control-sm rounded" v-model="form.email"
                    id="exampleInputEmail1" placeholder="Email" required>
                </div>
                <div class="form-group">
                  <label for="">Password</label>
                  <input type="password" class="form-control form-control-sm rounded" v-model="form.password"
                    id="exampleInputPassword1" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary rounded">SIGN UP</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                </div>
                <div class="mb-2">

                </div>
                <div class="text-center mt-4 font-weight-light">
                  Already have an account?
                  <Link :href="route('login')" class="text-primary">Sign In</Link>
                </div>
              </form>

              <Footer />
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

</template>