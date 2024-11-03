<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 mx-3 mb-5">
            <div class="card rounded-md mt-5 shadow-sm">
                <div class="card-header">
                    <h6 class="fw-bold">Email is not Verified</h6>
                </div>
                <div class="card-body text-center">
                    <div class="d-flex justify-content-center mb-3">
                        <iconify-icon icon="line-md:email-alert-twotone" class="text-warning" height="60"
                            width="60"></iconify-icon>
                    </div>
                    <div class="alert alert-warning m-2" role="alert">
                        <p>Please check your email to verify your email address. You won’t be able to proceed until your
                            email is verified.</p>
                        <hr class="my-3">
                        <p class="mb-0">
                            If you didn't receive the email, please check your spam folder or wait a few minutes before
                            trying again.
                        </p>
                    </div>
                    <div>
                        <Link :href="'/logout'" class="btn btn-primary btn-sm mt-3 shadow-lg">
                        <div class="d-flex">
                            <iconify-icon icon="solar:logout-2-bold-duotone" class="mr-1"></iconify-icon> Sign Out
                        </div>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>
</template>
