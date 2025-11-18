<script setup>
import { ref, computed } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import Card from '@/Components/Card.vue'
import Layout from './Layout.vue'

const props = defineProps({
  requests: {
    type: Object,
    default: () => ({}),
  },
  count: {
    type: Object,
    default: () => ({}),
  },
})
</script>

<template>
  <Layout>
    <div class="container py-5">
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

      <!-- Table Card -->
      <div class="card shadow border-0">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table table-nowrap table-bordered align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>Request Id</th>
                  <th>Purchase Date</th>
                  <th>Invoice No</th>
                  <th>No of Items</th>
                  <th>Status</th>
                  <th>Certificate</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in requests.data" :key="item.id">
                  <td>{{ item.request_id }}</td>
                  <td>{{ item.purchase_date }}</td>
                  <td>{{ item.invoice_no }}</td>
                  <td>{{ item.items_count }}</td>
                  <td>
                    <span :class="`badge bg-${item.status_badge}`">{{ item.status_label ?? '-' }}</span>
                  </td>
                  <td>
                    <Link v-if="item.certificate" :href="route('warranty-dashboard.download', item.id)" class="btn btn-sm btn-primary">Download</Link>
                    <span v-else class="text-muted">Not Generated</span>
                  </td>
                    <td>
                        <Link :href="route('warranty-request.view', item.id)" class="btn btn-sm btn-info text-white">View</Link>
                    </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </Layout>
</template>
