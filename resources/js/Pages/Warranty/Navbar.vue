<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const page = usePage()

// This is the session your backend shared
const customerLoggedIn = page.props.customer?.loggedIn

</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 position-sticky top-0 z-2">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="/">
        <img src="@assets/images/logo-dark.png" alt="Company Logo" height="35" class="me-2" />
      </a>

      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-lg-center gap-lg-3 pt-3 pt-lg-0">
          <li class="nav-item" v-if="!customerLoggedIn">
            <Link :href="route('customer.login')" class="btn btn-link text-muted visit-link px-2 fw-semibold">Login</Link>
          </li>
          <li class="nav-item" v-if="customerLoggedIn">
            <Link :href="route('customer.dashboard')" class="btn btn-link text-muted visit-link px-2 fw-semibold">Dashboard</Link>
          </li>
          <li class="nav-item">
            <a href="https://rayzonsolar.com/" target="_blank" class="btn btn-link visit-link px-2 fw-semibold">
              Visit Us
              <i class="bi bi-arrow-right"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
