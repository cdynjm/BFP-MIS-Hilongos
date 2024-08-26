<script>

import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Footer from '@/Layouts/Guest-Footer.vue';

export default {
  props: {
    token: String,
    email: String,
  },
  setup(props) {
    const form = useForm({
      token: props.token,
      email: props.email || '',
      password: '',
      password_confirmation: '',
      error: null,
      success: null
    });

    const submit = () => {
      form.post(route('password.update'), {
        onError: (errors) => {
          form.error = 'Password did not match.';
        }
      });
    };

    return { form, submit };
  },
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
              <h4 class="font-weight-bold mb-3">Reset Password</h4>

              <div class="alert alert-danger" v-if="form.error">
                {{ form.error }}
              </div>

              <form @submit.prevent="submit">
                <input type="hidden" v-model="form.token" />
                <div>
                  <label for="email">Email</label>
                  <input type="email" class="form-control form-control-sm mb-3" v-model="form.email" readonly />
                </div>
                <div>
                  <label for="password">Password</label>
                  <input type="password" class="form-control form-control-sm mb-3" v-model="form.password" required />
                </div>
                <div>
                  <label for="password_confirmation">Confirm Password</label>
                  <input type="password" class="form-control form-control-sm mb-3" v-model="form.password_confirmation"
                    required />
                </div>
                <div>
                  <button type="submit" class="btn btn-sm btn-primary">Reset Password</button>
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