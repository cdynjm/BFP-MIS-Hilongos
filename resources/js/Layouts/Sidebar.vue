<script>
import { Head, Link, useForm } from "@inertiajs/vue3";

export default {
  methods: {
    navigateTo(routeName) {
      this.$inertia.get(route(routeName));
    },

    isActive($active) {
      return this.$page.component === $active;
    },
  },
};
</script>

<script setup>

import { ref, onMounted } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';

const user = ref(null);

defineProps({
  page: String
})

onMounted(() => {
  const page = usePage();
  user.value = page.props.auth;
});

</script>

<template>
  <nav class="sidebar sidebar-offcanvas shadow-sm bg-white" id="sidebar">
    <hr class="mx-3">
    <ul class="nav">
      <li class="nav-item">
        <div class="d-flex sidebar-profile">
          <div class="sidebar-profile-image">
            <img :src="'/storage/profile/' + user?.applicant.picture" style="width: 40px; height: auto;" alt="image"
              v-if="user?.role === 3">
            <img :src="'/storage/profile/' + user?.personnel.picture" style="width: 40px; height: auto;" alt="image"
              v-if="user?.role === 2">
            <img src="/images/firefighter.png" style="width: 45px; height: auto;" alt="image" v-if="user?.role === 1">
            <span class="sidebar-status-indicator"></span>
          </div>
          <div class="sidebar-profile-name">
            <p class="sidebar-name text-dark" style="margin-left: 10px;" v-if="user?.role === 1">
              {{ user?.name }}
            </p>
            <p class="sidebar-name text-dark" style="margin-left: 10px;" v-if="user?.role === 2">
              {{ user?.personnel.name }}
            </p>
            <p class="sidebar-name text-dark" style="margin-left: 10px;" v-if="user?.role === 3">
              {{ user?.applicant.name }}
            </p>

            <p class="sidebar-designation text-dark" style="margin-left: 10px;" v-if="user?.role === 1">
              Administrator
            </p>

            <p class="sidebar-designation text-dark" style="margin-left: 10px;" v-if="user?.role === 2">
              Personnel
            </p>

            <p class="sidebar-designation text-dark" style="margin-left: 10px;" v-if="user?.role === 3">
              Applicant
            </p>
          </div>
        </div>
        <p class="sidebar-menu-title mb-2">Pages</p>
      </li>

      <div v-if="user?.role === 1">
        <li :class="['nav-item', isActive('Admin/Dashboard') ? 'active' : '']">
          <a class="nav-link" @click.prevent="navigateTo('admin.dashboard')" href="#">
            <i class="typcn typcn-device-desktop menu-icon"></i>
            <span class="menu-title" style="margin-left: 5px;">Dashboard</span>
          </a>
        </li>
        <li :class="['nav-item', isActive('Admin/Personnel') ? 'active' : '']">
          <a class="nav-link" @click.prevent="navigateTo('admin.personnel')" href="#">
            <i class="fa-solid fa-users-gear menu-icon"></i>
            <span class="menu-title">Personnel</span>
          </a>
        </li>

        <li :class="['nav-item', isActive('Admin/Fire-Incident') ? 'active' : '']">
          <a class="nav-link" @click.prevent="navigateTo('admin.fire-incident')" href="#">
            <i class="fa-solid fa-fire menu-icon mr-4"></i>
            <span class="menu-title">Fire Incidents</span>
          </a>
        </li>

        <li :class="['nav-item', isActive('Admin/SMS') ? 'active' : '']">
          <a class="nav-link" @click.prevent="navigateTo('admin.sms-token')" href="#">
            <i class="fa-solid fa-comment-sms menu-icon"></i>
            <span class="menu-title">SMS API Token</span>
          </a>
        </li>
      </div>

      <div v-if="user?.role === 2">
        <li :class="['nav-item', isActive('Personnel/Dashboard') ? 'active' : '']">
          <a class="nav-link" @click.prevent="navigateTo('personnel.dashboard')" href="#">
            <i class="typcn typcn-device-desktop menu-icon"></i>
            <span class="menu-title" style="margin-left: 5px;">Dashboard</span>
          </a>
        </li>
        <li :class="['nav-item', isActive('Personnel/Fire-Incident') ? 'active' : '']">
          <a class="nav-link" @click.prevent="navigateTo('personnel.fire-incident')" href="#">
            <i class="fa-solid fa-fire menu-icon mr-4"></i>
            <span class="menu-title">Fire Incidents</span>
          </a>
        </li>
      </div>

      <div v-if="user?.role === 3">
        <li :class="['nav-item', isActive('Applicant/Dashboard') ? 'active' : '']">
          <a class="nav-link" @click.prevent="navigateTo('applicant.dashboard')" href="#">
            <i class="typcn typcn-device-desktop menu-icon"></i>
            <span class="menu-title" style="margin-left: 5px;">Dashboard</span>
          </a>
        </li>
        <li :class="['nav-item', isActive('Applicant/RequestInspection') ? 'active' : '']">
          <a class="nav-link" @click.prevent="navigateTo('applicant.request-inspection')" href="#">
            <i class="fa-solid fa-bullhorn menu-icon"></i>
            <span class="menu-title" style="margin-left: 5px;">Request Inspection</span>
          </a>
        </li>
      </div>


    </ul>
  </nav>
</template>

<style>
.sidebar-offcanvas.inactive {
  transition: transform 0.5s ease-in-out;
  transform: translateX(-255px);
  opacity: 1;
}

.main-panel.inactive {
  margin-left: 0;
  width: 100%;
}
</style>
