<script setup>
import { Head } from '@inertiajs/vue3'

import Layout from './Layout.vue'

import Lottie from '@/Components/widgets/lottie.vue'
import animationData from '@/Components/widgets/msoeawqm.json'

const props = defineProps({
  request: {
    type: Object,
    default: () => ({}),
  },
})
</script>

<template>
  <Layout>
    <Head title="Warranty Request Details" />

    <div class="container py-4">
      <div class="card">
        <div class="card-body">
          <div class="row g-4">
            <div class="col-md-3 col-6">
              <p class="mb-1 text-uppercase fw-semibold">Request Id</p>
              <div class="text-muted fw-medium">{{ request.request_id ?? '-' }}</div>
            </div>

            <div class="col-md-3 col-6">
              <p class="mb-1 text-uppercase fw-semibold">Invoice No</p>
              <div class="text-muted fw-medium">{{ request.invoice_no }}</div>
            </div>

            <div class="col-md-3 col-6">
              <p class="mb-1 text-uppercase fw-semibold">Purchase Date</p>
              <div class="text-muted fw-medium">{{ request.purchase_date }}</div>
            </div>

            <div class="col-md-3 col-6">
              <p class="mb-1 text-uppercase fw-semibold">Status</p>
              <div class="text-muted fw-medium">
                <span :class="`badge bg-${request.status_badge}`">{{ request.status_label ?? '-' }}</span>
              </div>
            </div>

            <div class="col-md-3 col-6">
              <p class="mb-1 text-uppercase fw-semibold">Invoice URL</p>
              <div class="text-muted fw-medium">
                <a :href="request.invoice_file_url" target="_blank">View File</a>
              </div>
            </div>

            <div class="col-md-3 col-6" v-if="request.qc_reject_reason">
              <p class="mb-1 text-uppercase fw-semibold">Reject Reason</p>
              <div class="text-muted fw-medium">{{ request.qc_reject_reason }}</div>
            </div>

            <div class="col-md-3 col-6">
              <p class="mb-1 text-uppercase fw-semibold">No of Items</p>
              <div class="text-muted fw-medium">{{ request.items.length }}</div>
            </div>

            <div class="col-md-3 col-6">
              <p class="mb-1 text-uppercase fw-semibold">Request Date</p>
              <div class="text-muted fw-medium">{{ request.created_at }}</div>
            </div>
          </div>
        </div>
      </div>

      <div class="card" v-if="request.items">
        <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-nowrap table-bordered align-middle mb-0">
                <thead class="table-light">
                  <tr>
                    <th scope="col">Serial Number</th>
                    <th scope="col">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in request.items" :key="item.id">
                    <td>{{ item.serial ?? '-' }}</td>
                    <td><span :class="`badge bg-${item.status_badge}`">{{ item.status_label ?? '-' }}</span></td>
                  </tr>
                </tbody>
              </table>
            </div>
          <div v-if="request.items.length === 0" class="noresult">
            <div class="text-center">
              <lottie class="avatar-xl" colors="primary:#121331,secondary:#08a88a" :options="{ animationData: animationData }" :height="75" :width="75" />
              <h5 class="mt-2">Sorry! No Records Found</h5>
            </div>
          </div>
        </div>
      </div>
    </div>

  </Layout>
</template>
