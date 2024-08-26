<script>
import { ref } from 'vue';
import { useForm, Link } from '@inertiajs/vue3';
import Footer from '@/Layouts/Guest-Footer.vue';

export default {
    setup() {
        const form = useForm({
            email: '',
            error: null,
            success: null
        });

        const submit = () => {
            form.error = null;
            form.success = null;

            form.post(route('password.email'), {
                onSuccess: (page) => {
                    form.success = 'A reset link has been sent to your email address.';
                },
                onError: (errors) => {
                    form.error = errors.email;
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
                                    <img src="/images/bfp-2.png" style="width: 350px; height: auto;" alt="logo">
                                </div>
                            </div>
                            <h4 class="font-weight-bold mb-3">Forgot Password</h4>

                            <div class="alert alert-danger" v-if="form.error">
                                {{ form.error }}
                            </div>

                            <div class="alert alert-success" v-if="form.success">
                                {{ form.success }}
                            </div>

                            <form @submit.prevent="submit">
                                <div>
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control form-control-sm mb-3" v-model="form.email"
                                        required autofocus />
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-sm btn-primary">Send Password Reset
                                        Link</button>
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
