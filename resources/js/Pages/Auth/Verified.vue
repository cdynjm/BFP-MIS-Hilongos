<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 mx-3 mb-5">
            <div class="card rounded-md mt-5 shadow-sm">
                <div class="card-header">
                    <h6 class="fw-bold">Email has been Verified</h6>
                </div>
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center mb-3">
                        <iconify-icon icon="line-md:email-check-filled" class="text-success" height="60"
                            width="60"></iconify-icon>
                    </div>
                    <div class="alert alert-success m-2" role="alert">
                        <p>Your email address has been successfully verified! Thank you for completing the verification
                            process.</p>
                        <hr class="my-3">
                        <p class="mb-0">
                            To continue, please go back to the system, refresh your browser, and you will be redirected
                            to your dashboard where you can access all the features of your account or you can login
                            your account by clicking the button below.
                        </p>
                    </div>

                    <Link :href="'/login'" class="btn btn-primary btn-sm mt-3 shadow-lg">
                    <div class="d-flex">
                        <iconify-icon icon="ph:sign-in-duotone" class="mr-1"></iconify-icon> Sign In
                    </div>
                    </Link>

                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</template>
