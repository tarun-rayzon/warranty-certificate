<script setup>
import { ref } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'

import Layout from '@/Layouts/main.vue'

import Lottie from '@/Components/widgets/lottie.vue'
import animationData from '@/Components/widgets/msoeawqm.json'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import TextInput from '@/Components/TextInput.vue'

const showApprovalModal = ref(false)

const props = defineProps({
  request: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  id: props.request.id,
  status: '',
  reason: '',
})

const openActionModal = () => {
  form.reset()
  form.errors = {}
  showApprovalModal.value = true
}

const approval = () => {
  form.post(route('warranty-requests.approval', form.id), {
    onSuccess: () => {
      showApprovalModal.value = false
      form.reset()
      form.errors = {}
    },
  })
}
</script>

<template>
  <Layout>
    <Head title="Warranty Request Details" />

    <div class="alert alert-danger" role="alert" v-if="request.status === 'approved'">
      <strong>Alert:</strong>
      This warranty certificate is already generated and sent to the customer via email. Please avoid making further changes to this request to maintain data integrity.
    </div>

    <div v-if="$page.props.user.permissions.includes('warranty.create') && request.status === 'pending_qc'" class="alert alert-warning d-flex align-items-center justify-content-between" role="alert">
      <div>
        <strong>Note:</strong>
        This page is for Quality Control (QC) team to review warranty requests. Please ensure all details are accurate before approving or rejecting the request.
      </div>

      <button type="button" class="btn btn-outline-success btn-sm" @click="openActionModal">Take Action</button>
    </div>

    <div class="card">
      <div class="card-body">
        <div class="row g-4">
          <div class="col-md-3 col-6">
            <p class="mb-1 text-uppercase fw-semibold">Request Id</p>
            <div class="text-muted fw-medium">{{ request.request_id ?? '-' }}</div>
          </div>

          <div class="col-md-3 col-6">
            <p class="mb-1 text-uppercase fw-semibold">Customer Name</p>
            <div class="text-muted fw-medium">{{ request.customer?.name ?? '-' }}</div>
          </div>

          <div class="col-md-3 col-6">
            <p class="mb-1 text-uppercase fw-semibold">Customer Email</p>
            <div class="text-muted fw-medium">{{ request.customer?.email ?? '-' }}</div>
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
            <p class="mb-1 text-uppercase fw-semibold">Invoice URL</p>
            <div class="text-muted fw-medium">
              <a :href="request.invoice_file_url" target="_blank">View File</a>
            </div>
          </div>

          <div class="col-md-3 col-6" v-if="request.certificate?.warranty_certificate_file_url">
            <p class="mb-1 text-uppercase fw-semibold">Certificate URL</p>
            <div class="text-muted fw-medium">
              <a :href="request.certificate.warranty_certificate_file_url" target="_blank">View File</a>
            </div>
          </div>

          <div class="col-md-3 col-6">
            <p class="mb-1 text-uppercase fw-semibold">No of Items</p>
            <div class="text-muted fw-medium">{{ request.items.length }}</div>
          </div>

          <div class="col-md-3 col-6">
            <p class="mb-1 text-uppercase fw-semibold">Request Date</p>
            <div class="text-muted fw-medium">{{ request.created_at }}</div>
          </div>

          <div class="col-md-3 col-6">
            <p class="mb-1 text-uppercase fw-semibold">Status</p>
            <div class="text-muted fw-medium">
              <span :class="`badge bg-${request.status_badge}`">{{ request.status_label ?? '-' }}</span>
            </div>
          </div>

          <div class="col-md-3 col-6" v-if="request.qc_reject_reason">
            <p class="mb-1 text-uppercase fw-semibold">Reject Reason</p>
            <div class="text-muted fw-medium">{{ request.qc_reject_reason }}</div>
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
                <th scope="col">Serial Numbers</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in request.items" :key="item.id">
                <td>{{ item.serial ?? '-' }}</td>
                <td>
                  <span :class="`badge bg-${item.status_badge}`">{{ item.status_label ?? '-' }}</span>
                </td>
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

    <BModal centered v-model="showApprovalModal" hide-footer title="Take Action" header-class="p-3 bg-light" title-class="fs-14">
      <form @submit.prevent="approval()">
        <div class="row">
          <div class="col-lg-12">
            <div class="mb-3">
              <InputLabel for="status" value="Select Action" />
              <select class="form-select" aria-label="Default select example" v-model="form.status" :class="{ 'is-invalid': form.errors.status }">
                <option value="" disabled>Select an action</option>
                <option value="approved">Approve</option>
                <option value="rejected">Reject</option>
              </select>
              <InputError :message="form.errors.status" class="mt-2" />
            </div>
          </div>

          <div class="col-lg-12" v-if="form.status === 'rejected'">
            <div class="mb-3">
              <InputLabel for="reason" value="Rejection Reason" />
              <TextInput id="reason" type="text" class="form-control" placeholder="Enter Rejection Reason" v-model="form.reason" :class="{ 'is-invalid': form.errors.reason }" required />
              <InputError :message="form.errors.reason" class="mt-2" />
            </div>
          </div>
        </div>

        <div class="hstack gap-1 justify-content-end">
          <button type="button" class="btn btn-danger btn-sm" @click="showApprovalModal = false">Cancel</button>
          <button type="submit" class="btn btn-primary btn-sm" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Submit</button>
        </div>
      </form>
    </BModal>
  </Layout>
</template>
