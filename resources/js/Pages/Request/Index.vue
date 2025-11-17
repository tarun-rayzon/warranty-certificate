<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import Layout from '@/Layouts/main.vue'
import CommonDataTable from '@/Components/CommonDataTable.vue'

import Lottie from '@/Components/widgets/lottie.vue'
import animationData from '@/Components/widgets/msoeawqm.json'

import Multiselect from '@vueform/multiselect'
import '@vueform/multiselect/themes/default.css'
import Card from '@/Components/Card.vue'

const props = defineProps({
  warranty_requests: {
    type: Object,
    default: () => ({}),
  },
  count: {
    type: Object,
    default: () => ({}),
  },
})

const columns = [
  { key: 'id', label: 'ID', sortable: false },
  { key: 'request_id', label: 'Request ID', sortable: false },
  { key: 'customer_name', label: 'Customer', sortable: false },
  { key: 'phone', label: 'Mobile', sortable: false },
  { key: 'invoice', label: 'Invoice No', sortable: false },
  { key: 'invoice_file', label: 'Invoice', sortable: false },
  { key: 'status', label: 'Status', sortable: false },
  { key: 'created_at', label: 'Created At', sortable: false },
  { key: 'action', label: 'Action', sortable: false },
]
</script>
<script>
export default {
  data() {
    return {
      filters: {
        search: '',
        status: '',
      },
    }
  },
  created() {
    if (this.$page.props.filters) {
      this.filters = { ...this.filters, ...this.$page.props.filters }
    }
  },
  computed: {
    hasActiveFilters() {
      return Object.keys(this.appliedFilters).length > 0
    },
  },
  methods: {
    getActiveFilters() {
      return Object.fromEntries(
        Object.entries(this.filters).filter(([_, value]) => {
          return Array.isArray(value) ? value.length > 0 : value !== '' && value !== false
        })
      )
    },
    goToPage(page) {
      this.$inertia.get(
        this.route('warranty-requests.index'),
        {
          ...this.filters,
          page,
        },
        {
          replace: true,
          preserveState: true,
          preserveScroll: true,
        }
      )
    },
    applyFilters() {
      const activeFilters = this.getActiveFilters()
      this.appliedFilters = { ...activeFilters }

      this.$inertia.get(this.route('warranty-requests.index'), activeFilters, { replace: true, preserveState: true, preserveScroll: true })
    },
    resetFilters() {
      this.filters = {
        search: '',
        date: '',
        status: '',
        sales_person: '',
        open_from_sales: false,
        open_from_qc: false,
        date_range: '',
        complain_type: '',
      }
      this.appliedFilters = {}
      this.applyFilters()
    },
  },
}
</script>

<template>
  <Layout>
    <Head title="Warranty Requests" />

    <div class="row">
      <div class="col-lg-3">
        <Card title="Total Requests" :total="count.total" icon="ri-file-list-3-line" color="dark" />
      </div>
      <div class="col-lg-3">
        <Card title="Pending QC" :total="count.pending" icon="bx bx-hourglass" color="warning" />
      </div>
      <div class="col-lg-3">
        <Card title="Approved" :total="count.approved" icon="ri-check-double-line" color="success" />
      </div>
      <div class="col-lg-3">
        <Card title="Rejected" :total="count.rejected" icon="ri-close-line" color="danger" />
      </div>
    </div>

    <BRow>
      <BCol lg="12">
        <BCard no-body>
          <BCardHeader>
            <div class="d-flex align-items-center">
              <h5 class="card-title mb-0 flex-grow-1 fs-14">All Requests</h5>
            </div>
          </BCardHeader>
          <CommonDataTable :columns="columns" :pagination="warranty_requests" @update:page="goToPage" table-id="warranty-requests" :persist-column-state="true">
            <template #filters>
              <BRow class="g-2">
                <BCol lg="3" md="4">
                  <div class="search-box">
                    <input type="text" v-model="filters.search" class="form-control search" placeholder="Search for request id, name, email..." />
                    <i class="ri-search-line search-icon"></i>
                  </div>
                </BCol>

                <BCol lg="3" md="4">
                  <Multiselect
                    v-model="filters.status"
                    :options="{
                      pending_qc: 'Pending QC',
                      approved: 'Approved',
                      rejected: 'Rejected',
                    }"
                    placeholder="Select Status"
                  />
                </BCol>

                <div class="col mt-3 text-end">
                  <button class="btn btn-outline-primary btn-sm me-1" @click="applyFilters">
                    <i class="ri-filter-2-line align-bottom"></i>
                    Apply
                  </button>
                  <button class="btn btn-outline-primary btn-sm" @click="resetFilters">
                    <i class="ri-refresh-line align-bottom"></i>
                    Reset
                  </button>
                </div>
              </BRow>
            </template>
            <template #default="{ isColumnVisible }">
              <tr v-for="(ftr, index) in warranty_requests.data" :key="index">
                <td v-if="isColumnVisible('id')">{{ (warranty_requests.current_page - 1) * warranty_requests.per_page + index + 1 }}</td>
                <td v-if="isColumnVisible('request_id')">{{ ftr.request_id }}</td>
                <td v-if="isColumnVisible('customer_name')">
                  <div>{{ ftr.customer?.name ?? '-' }}</div>
                  <span class="small text-muted">{{ ftr.customer?.email ?? '-' }}</span>
                </td>
                <td v-if="isColumnVisible('phone')">{{ ftr.customer?.phone ?? '-' }}</td>
                <td v-if="isColumnVisible('invoice_no')">{{ ftr.invoice_no ?? '-' }}</td>
                <td v-if="isColumnVisible('invoice_file')">{{ ftr.invoice ?? '-' }}</td>
                <td v-if="isColumnVisible('status')">
                    <span :class="`badge bg-${ftr.status_badge}`">{{ ftr.status_label ?? '-' }}</span>
                </td>
                <td v-if="isColumnVisible('created_at')">{{ ftr.created_at ?? '-' }}</td>
                <td v-if="isColumnVisible('action')">
                  <Link :href="route('ftr-files.show', ftr.id)" class="me-2 btn btn-outline-primary btn-sm"><i class="bx bx-show align-middle"></i></Link>
                  <button class="me-2 btn btn-outline-danger btn-sm" @click="openDeleteModal(ftr.id)"><i class="bx bx-trash align-middle"></i></button>
                </td>
              </tr>
            </template>
          </CommonDataTable>
          <div v-if="warranty_requests.data.length === 0" class="noresult">
            <div class="text-center">
              <lottie class="avatar-xl" colors="primary:#121331,secondary:#08a88a" :options="{ animationData: animationData }" :height="75" :width="75" />
              <h5 class="mt-2">Sorry! No Records Found</h5>
            </div>
          </div>
        </BCard>
      </BCol>
    </BRow>
  </Layout>
</template>
