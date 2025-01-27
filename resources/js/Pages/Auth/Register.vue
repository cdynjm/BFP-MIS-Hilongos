<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Footer from '@/Layouts/Guest-Footer.vue';
import { ref } from 'vue';

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

const showPassword = ref(false); // Reactive variable to toggle password visibility



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
// Handle file input change and compress image before setting it to form
const createPicture = async (event) => {
  const file = event.target.files[0];
  if (file && file.type.startsWith('image')) {
    const compressedFile = await compressImage(file, { quality: 0.3, type: file.type });
    form.file = compressedFile;
  } else {
    form.file = file; // Assign if it's not an image
  }
};


const validateForm = () => {
  const phoneRegex = /^\d{11}$/;
  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

  if (!phoneRegex.test(form.contactNumber)) {
    form.error = 'Contact number must be exactly 11 digits.';
    return false;
  }

  if (!passwordRegex.test(form.password)) {
    form.error = 'Password must be at least 8 characters, contain an uppercase letter, a lowercase letter, a number, and a symbol.';
    return false;
  }

  return true;
};

const submit = () => {
  if (!validateForm()) return;

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
                  <img src="/images/bfp-2.png" style="width: 300px; height: auto;" class="" alt="logo">
                </div>
              </div>
              <h4 class="font-weight-bold mb-3">Create your BFP Applicant Account</h4>

              <div class="alert alert-danger" v-if="form.error">
                {{ form.error }}
              </div>

              <form class="mb-3" @submit.prevent="submit">
                <div class="form-group">
                  <label for="">Full Name <span class="text-danger text-xs">*</span></label>
                  <input type="text" class="form-control form-control-sm rounded" v-model="form.name" placeholder="Name" required>
                </div>
                <div class="form-group">
                  <label for="">Contact Number <span class="text-danger text-xs">*</span></label>
                  <input type="text" class="form-control form-control-sm rounded" v-model="form.contactNumber" placeholder="Contact Number" required>
                </div>
                <div class="form-group">
                  <label for="" class="mb-1">Profile Picture <span class="text-danger text-xs">*</span></label>
                  <input type="file" class="form-control form-control-sm rounded" @change="createPicture" accept=".jpg" required>
                </div>
                <div class="form-group">
                  <label for="">Email <span class="text-danger text-xs">*</span></label>
                  <input type="email" class="form-control form-control-sm rounded" v-model="form.email" placeholder="Email" required>
                </div>
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
                <div class="mt-3">
                  <button class="btn btn-block btn-primary rounded" :disabled="form.processing">SIGN UP</button>
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
    </div>
  </div>
</template>

<style scoped>
.eye-icon {
  font-size: 1.25rem;
  color: #6c757d;
}
</style>
