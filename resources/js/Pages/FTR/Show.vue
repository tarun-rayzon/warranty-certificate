<script setup>
import { Head } from '@inertiajs/vue3'

import Layout from '@/Layouts/main.vue'
import CommonDataTable from '@/Components/CommonDataTable.vue'

import Lottie from '@/Components/widgets/lottie.vue'
import animationData from '@/Components/widgets/msoeawqm.json'

const props = defineProps({
  ftr_file: {
    type: Object,
    default: () => ({}),
  },
  serial_numbers: {
    type: Object,
    default: () => ({}),
  },
})

const columns = [
  { key: 'id', label: 'ID', sortable: false },
  { key: 'serial', label: 'Serial Number', sortable: false },
  { key: 'pallet_id', label: 'Pallet ID', sortable: false },
  { key: 'status', label: 'Status', sortable: false },
]
</script>
<script>
export default {
  data() {
    return {
      filters: {
        search: '',
      },
    }
  },
  created() {
    // Populate filters with values from backend
    if (this.$page.props.filters) {
      this.filters = { ...this.filters, ...this.$page.props.filters }
    }
  },
  methods: {
    getActiveFilters() {
      return Object.fromEntries(
        Object.entries(this.filters).filter(([_, value]) => {
          return Array.isArray(value) ? value.length > 0 : value !== '' && value !== false
        })
      )
    },
    search() {
      const activeFilters = this.getActiveFilters()
      this.appliedFilters = { ...activeFilters }

      this.$inertia.get(this.route('ftr-files.show', this.ftr_file.id), activeFilters, { replace: true, preserveState: true })
    },
    goToPage(page) {
      this.$inertia.get(
        this.route('ftr-files.show', this.ftr_file.id),
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
  },
}
</script>

<template>
  <Layout>
    <Head title="FTR Detail" />

    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md col-6">
            <p class="text-muted mb-1 text-uppercase fw-semibold">File Name</p>
            <div class="fw-medium">{{ ftr_file.original_name }}</div>
          </div>

          <div class="col-md col-6">
            <p class="text-muted mb-1 text-uppercase fw-semibold">Rows Parsed</p>
            <div class="fw-medium">{{ ftr_file.rows_parsed }}</div>
          </div>

          <div class="col-md col-6">
            <p class="text-muted mb-1 text-uppercase fw-semibold">Upload By</p>
            <div class="fw-medium">{{ ftr_file.uploader?.name ?? '' }}</div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-body">
        <CommonDataTable :columns="columns" :pagination="serial_numbers" @update:page="goToPage" table-id="ftr-files" :persist-column-state="true" :showColumnToggle="false">
          <template #filters>
            <BRow class="g-2">
              <BCol lg="3" md="4" class="my-2">
                <div class="search-box">
                  <input type="text" v-model="filters.search" class="form-control search" placeholder="Search for serial or pallet..." @input="search" />
                  <i class="ri-search-line search-icon"></i>
                </div>
              </BCol>
            </BRow>
          </template>
          <template #default="{ isColumnVisible }">
            <tr v-for="(serial, index) in serial_numbers.data" :key="index">
              <td v-if="isColumnVisible('id')">{{ (serial_numbers.current_page - 1) * serial_numbers.per_page + index + 1 }}</td>
              <td v-if="isColumnVisible('serial')">{{ serial.serial }}</td>
              <td v-if="isColumnVisible('pallet_id')">{{ serial.pallet_id }}</td>
              <td v-if="isColumnVisible('status')">{{ serial.status }}</td>
            </tr>
          </template>
        </CommonDataTable>
        <div v-if="serial_numbers.data.length === 0" class="noresult">
          <div class="text-center">
            <lottie class="avatar-xl" colors="primary:#121331,secondary:#08a88a" :options="{ animationData: animationData }" :height="75" :width="75" />
            <h5 class="mt-2">Sorry! No Records Found</h5>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
