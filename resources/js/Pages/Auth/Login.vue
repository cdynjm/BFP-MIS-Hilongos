<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Footer from '@/Layouts/Guest-Footer.vue';
import { ref } from 'vue';

const form = useForm({
  email: null,
  password: null,
  remember: false,
  error: null
});

const submit = () => {
  form.post(route('login.authenticate'), {
    onFinish: () => {
      form.error = form.errors.status
    },
  });
};

const showPassword = ref(false);

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
                  <img src="/images/bfp-2.png" style="width: 300px; height: auto;" class="" alt="logo">
                </div>
              </div>
              <h4 class="font-weight-bold mb-3">Sign In with your credentials to proceed.</h4>

              <div class="alert alert-danger" v-if="form.error">
                {{ form.error }}
              </div>

              <form class="mb-3" @submit.prevent="submit">
                <div class="form-group">
                  <label for="">Email</label>
                  <input type="email" class="form-control form-control-sm rounded" v-model="form.email"
                    id="exampleInputEmail1" placeholder="Username" required>
                </div>
                <div class="form-group position-relative">
                  <label for="">Password</label>
                  <input :type="showPassword ? 'text' : 'password'" class="form-control form-control-sm rounded"
                    v-model="form.password" placeholder="Password" required>

                  <iconify-icon icon="ion:eye" v-if="!showPassword" @click="showPassword = !showPassword"
                    class="eye-icon position-absolute"
                    style="right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer;">
                  </iconify-icon>

                  <iconify-icon icon="ion:eye-off-sharp" v-else @click="showPassword = !showPassword"
                    class="eye-icon position-absolute"
                    style="right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer;">
                  </iconify-icon>
                </div>
                <div class="mt-3">
                  <button class="btn btn-block btn-primary rounded">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">

                  <Link :href="route('password.request')" class="auth-link text-black">Forgot password?</Link>
                </div>
                <div class="mb-2">

                </div>
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account?
                  <Link :href="route('register')" class="text-primary">Sign Up</Link>
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

<style scoped>
.eye-icon {
  font-size: 1.25rem;
  color: #6c757d;
}
</style>