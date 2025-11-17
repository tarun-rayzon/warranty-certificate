<script setup>
import { Link, router } from '@inertiajs/vue3'
</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 position-sticky top-0 z-1">
    <div class="container">
      <!-- Company Logo -->
      <a class="navbar-brand d-flex align-items-center" href="/">
        <img src="@assets/images/logo-dark.png" alt="Company Logo" height="35" class="me-2" />
      </a>

      <!-- Mobile Menu Button -->
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Links -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-lg-center gap-lg-3">
          <li class="nav-item">
            <Link :href="route('public.request.create')" class="btn btn-link visit-link text-muted px-0 fw-semibold">Back to Portal</Link>
          </li>
          <li class="nav-item">
            <form @submit.prevent="router.post(route('customer.logout'))">
              <button class="btn btn-link text-danger fw-semibold">Logout</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <slot></slot>
</template>
