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
    // Reactive variable to toggle password visibility
    const showPassword = ref(false);

    // Define form data and error handling
    const form = useForm({
      token: props.token,
      email: props.email || '',
      password: '',
      password_confirmation: '',
      error: null,
      success: null,
    });

    // Password validation using regex
    const validatePassword = () => {
      const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

      if (!passwordRegex.test(form.password)) {
        form.error =
          'Password must be at least 8 characters, contain an uppercase letter, a lowercase letter, a number, and a symbol.';
        return false;
      }

      // Ensure passwords match
      if (form.password !== form.password_confirmation) {
        form.error = 'Passwords do not match.';
        return false;
      }

      return true;
    };

    // Handle form submission
    const submit = () => {
      if (validatePassword()) {
        form.post(route('password.update'), {
          onError: (errors) => {
            form.error = 'Failed to reset password.';
          },
        });
      }
    };

    return {
      form,
      showPassword, // reactive variable to toggle password visibility
      submit,
    };
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
                  <img src="/images/bfp-2.png" style="width: 350px; height: auto;" alt="logo" />
                </div>
              </div>
              <h4 class="font-weight-bold mb-3">Reset Password</h4>

              <!-- Display error message -->
              <div class="alert alert-danger" v-if="form.error">
                {{ form.error }}
              </div>

              <form @submit.prevent="submit">
                <input type="hidden" v-model="form.token" />

                <!-- Email field -->
                <div>
                  <label for="email">Email</label>
                  <input type="email" class="form-control form-control-sm mb-3" v-model="form.email" readonly />
                </div>

                <!-- Password field with toggle -->
                <div class="form-group position-relative">
                  <label for="">Password <span class="text-danger text-xs">*</span></label>
                  <input :type="showPassword ? 'text' : 'password'" class="form-control form-control-sm rounded" v-model="form.password" placeholder="Password" required>
                  
                  <iconify-icon 
                    icon="ion:eye" 
                    v-if="!showPassword" 
                    @click="showPassword = !showPassword" 
                    class="eye-icon position-absolute" 
                    style="right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer;">
                  </iconify-icon>

                  <iconify-icon 
                    icon="ion:eye-off-sharp" 
                    v-else 
                    @click="showPassword = !showPassword" 
                    class="eye-icon position-absolute" 
                    style="right: 10px; top: 70%; transform: translateY(-50%); cursor: pointer;">
                  </iconify-icon>
                </div>

                <!-- Confirm Password field -->
                <div>
                  <label for="password_confirmation">Confirm Password</label>
                  <input
                    :type="showPassword ? 'text' : 'password'"
                    class="form-control form-control-sm mb-3"
                    v-model="form.password_confirmation"
                    required
                  />
                </div>

                <!-- Submit button -->
                <div>
                  <button type="submit" class="btn btn-sm btn-primary">Reset Password</button>
                </div>
              </form>

              <Footer />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.eye-icon {
  font-size: 1.25rem;
  color: #6c757d;
}
</style>

