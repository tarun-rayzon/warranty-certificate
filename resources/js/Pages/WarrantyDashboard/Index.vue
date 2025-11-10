<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 position-sticky top-0 z-1">
    <div class="container">
      <!-- Company Logo -->
      <a class="navbar-brand d-flex align-items-center" href="/">
        <img src="@assets/images/logo-dark.png" alt="Company Logo" height="35" class="me-2" />
      </a>

      <!-- Mobile Menu Button -->
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar Links -->
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-lg-center gap-lg-3">
          <li class="nav-item">
            <button class="btn btn-link visit-link text-muted px-4 fw-semibold" @click="goBack">
              Warranty Portal
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container py-5">
    <h2 class="fw-bold mb-4">Warranty Dashboard</h2>

    <!-- Table Card -->
    <div class="card shadow border-0">
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th>Request List</th>
                <th>Purchase Date</th>
                <th>Status</th>
                <th>Download</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in paginatedData" :key="item.id">
                <td>{{ item.list }}</td>
                <td>{{ formatDate(item.purchase_date) }}</td>
                <td>
                  <span class="badge px-3 py-2" :class="{
                    'bg-warning-subtle text-warning': item.status === 'Pending',
                    'bg-success-subtle text-success': item.status === 'Approved',
                    'bg-danger-subtle text-danger': item.status === 'Rejected'
                  }">
                    {{ item.status }}
                  </span>
                </td>
                <td>
                  <a v-if="item.invoice_path" :href="`/storage/${item.invoice_path}`" target="_blank"
                    class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-download"></i> Download
                  </a>
                  <span v-else class="text-muted small">No file</span>
                </td>
              </tr>

              <tr v-if="!paginatedData.length">
                <td colspan="6" class="text-center text-muted py-4">
                  No warranty requests found.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <nav v-if="totalPages > 1" class="mt-4">
      <ul class="pagination justify-content-center mb-0">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <button class="page-link" @click="changePage(currentPage - 1)" :disabled="currentPage === 1">
            Previous
          </button>
        </li>

        <li v-for="page in totalPages" :key="page" class="page-item" :class="{ active: page === currentPage }">
          <button class="page-link" @click="changePage(page)">
            {{ page }}
          </button>
        </li>

        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <button class="page-link" @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages">
            Next
          </button>
        </li>
      </ul>
    </nav>
  </div>

  <footer class="footer">
    <BContainer>
      <BRow>
        <BCol col sm="6">
          {{ new Date().getFullYear() }} © Rayzon.
        </BCol>
        <BCol col sm="6">
          <div class="text-sm-end d-none d-sm-block">
            Design & Develop by Rayzon
          </div>
        </BCol>
      </BRow>
    </BContainer>
  </footer>
</template>

<script setup>
import { ref, computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";

const { props } = usePage();
const warranties = computed(() => props.warranties || []);

// pagination state
const currentPage = ref(1);
const perPage = 5; // show 5 items per page

const totalPages = computed(() => Math.ceil(warranties.value.length / perPage));

const paginatedData = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return warranties.value.slice(start, start + perPage);
});

function changePage(page) {
  if (page < 1 || page > totalPages.value) return;
  currentPage.value = page;
}

function formatDate(dateStr) {
  if (!dateStr) return "-";
  const date = new Date(dateStr);
  return date.toLocaleDateString("en-IN", {
    year: "numeric",
    month: "short",
    day: "numeric",
  });
}

function goBack() {
  router.visit("/warranty");
}
</script>
