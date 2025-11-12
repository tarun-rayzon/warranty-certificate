<script setup>
import { ref, onMounted, nextTick, onUnmounted } from 'vue'
import { Modal } from 'bootstrap'
import FormSection from './FormSection.vue'
import { router } from '@inertiajs/vue3'

import Navbar from './Navbar.vue'
import Hero from './Hero.vue'
import About from './About.vue'
import Footer from './Footer.vue'

const submitted = ref(false)
const isLoading = ref(false)
const otp = ref(['', '', '', '', '', ''])
let otpModal = null

const formData = ref({
  name: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  state: '',
  pincode: '',
  purchaseDate: '',
  invoice: null,
  serial_no: '',
  invoice_no: '',
})

const formatCommaSeparated = () => {
  formData.serial_no = String(formData.serial_no).replace(/\s+/g, ',').replace(/,+/g, ',').replace(/,\s*,/g, ',').replace(/,\s*$/, '')
}

function handleFileChange(e) {
  const target = e.target
  if (target.files?.[0]) {
    formData.value.invoice = target.files[0]
  }
}

onMounted(() => {
  const modalEl = document.getElementById('otpModal')
  otpModal = new Modal(modalEl, { backdrop: 'static' })
})

function handleSubmit() {
  // Start loading
  isLoading.value = true

  // Simulate OTP sending API
  setTimeout(() => {
    isLoading.value = false
    showOtpModal()
  }, 1000)
}

function showOtpModal() {
  nextTick(() => {
    otpModal.show()
    // Clear previous OTP
    otp.value = ['', '', '', '', '', '']
  })
}

function verifyOtp() {
  const enteredOtp = otp.value.join('')
  if (enteredOtp.length < 6) {
    alert('Please enter all 6 digits of OTP.')
    return
  }

  alert(`OTP Verified Successfully: ${enteredOtp}`)
  otpModal.hide()

  // Proceed with actual form submission
  submitted.value = true

  setTimeout(() => {
    submitted.value = false
    Object.assign(formData.value, {
      name: '',
      email: '',
      phone: '',
      address: '',
      city: '',
      state: '',
      pincode: '',
      purchaseDate: '',
      invoice: null,
    })

    router.visit('/warranty-dashboard')
  }, 1000)
}

function resendOtp() {
  alert('OTP resent to your email.')
}

function handleOtpInput(e, index) {
  const value = e.target.value
  if (value && index < 5) {
    const nextInput = document.querySelector(`#otp-${index + 1}`)
    nextInput?.focus()
  }
  if (!value && index > 0 && e.inputType === 'deleteContentBackward') {
    const prevInput = document.querySelector(`#otp-${index - 1}`)
    prevInput?.focus()
  }
}
</script>

<template>
  <Navbar />

  <Hero />

  <div class="container mb-4">
    <About />

    <section class="warranty-form pt-5" id="warranty-form">
      <div class="text-center mb-5" data-aos="zoom-in">
        <h2 class="fw-bold display-6 mb-3">Warranty Certificate Registration</h2>
        <p class="text-muted">Complete this form to register your solar panel warranty</p>
      </div>

      <div class="row">
        <div class="col-lg-4" data-aos="fade-up">
          <div style="display: flex; flex-direction: column; gap: 25px; justify-content: center">
            <img src="@assets/images/gt-collab.png" alt="" />
            <img src="@assets/images/kiwa.png" alt="" />
            <img src="@assets/images/mahindra.png" alt="" />
          </div>
        </div>
        <div class="col-lg-8" data-aos="fade-up" data-aos-duration="3000">
          <!-- Success Message -->
          <div v-if="submitted" class="alert alert-success d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <span>Form submitted successfully! Your warranty certificate is being processed.</span>
          </div>

          <!-- Form Card -->
          <div class="card shadow border-0">
            <div class="card-body p-4 p-md-5">
              <form @submit.prevent="handleSubmit">
                <!-- Personal Information -->
                <FormSection title="Personal Information" description="Enter your basic details">
                  <div class="row g-4">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Full Name
                        <span class="text-danger">*</span>
                      </label>
                      <input type="text" name="name" v-model="formData.name" placeholder="Name" required class="form-control" />
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Email Address
                        <span class="text-danger">*</span>
                      </label>
                      <input type="email" name="email" v-model="formData.email" placeholder="Email" required class="form-control" />
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Phone Number
                        <span class="text-danger">*</span>
                      </label>
                      <input type="tel" name="phone" v-model="formData.phone" placeholder="phone" required class="form-control" />
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Purchase Date
                        <span class="text-danger">*</span>
                      </label>
                      <input type="date" name="purchaseDate" v-model="formData.purchaseDate" required class="form-control" />
                    </div>
                  </div>
                </FormSection>

                <hr class="my-4" />

                <!-- Address Information -->
                <FormSection title="Address Information" description="Provide your complete address">
                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      Street Address
                      <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="address" v-model="formData.address" placeholder="Add Address" required class="form-control" />
                  </div>

                  <div class="row g-4">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        City
                        <span class="text-danger">*</span>
                      </label>
                      <input type="text" name="city" v-model="formData.city" placeholder="Add City" required class="form-control" />
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        State
                        <span class="text-danger">*</span>
                      </label>
                      <input type="text" name="state" v-model="formData.state" placeholder="Add State" required class="form-control" />
                    </div>

                    <div class="col-md-6">
                      <label class="form-label fw-semibold">
                        Pincode
                        <span class="text-danger">*</span>
                      </label>
                      <input type="text" name="pincode" v-model="formData.pincode" placeholder="000000" required class="form-control" />
                    </div>
                  </div>
                </FormSection>

                <hr class="my-4" />

                <!-- Product Information -->
                <FormSection title="Product Information" description="Provide your product details">
                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      Serial Number
                      <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="serial" v-model="formData.serial_no" @input="formatCommaSeparated" placeholder="Enter your product serial number, comma separated" required class="form-control" />
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">
                      Invoice Number
                      <span class="text-danger">*</span>
                    </label>
                    <input type="text" name="invoice" v-model="formData.invoice_no" placeholder="Enter product invoice number" required class="form-control" />
                  </div>
                </FormSection>

                <hr class="my-4" />

                <!-- Document Upload -->
                <FormSection title="Invoice Document" description="Upload a copy of your purchase invoice">
                  <div class="rounded-3 p-4 text-center bg-light position-relative">
                    <input type="file" accept=".pdf,.jpg,.jpeg,.png" id="invoice-upload" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" @change="handleFileChange" required />
                    <label for="invoice-upload" class="d-block border border-dashed p-3 border-primary rounded-3 mb-0">
                      <div class="mb-3">
                        <i class="bi bi-upload fs-2 text-primary"></i>
                      </div>
                      <p class="fw-semibold mb-1">
                        {{ formData.invoice ? formData.invoice.name : 'Click to upload or drag and drop' }}
                      </p>
                      PDF, JPG or PNG (Max 5MB)
                    </label>
                  </div>
                </FormSection>

                <!-- Submit -->
                <div class="pt-2">
                  <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold" :disabled="isLoading">
                    <span v-if="isLoading" class="d-flex align-items-center justify-content-center">
                      <span class="spinner-border spinner-border-sm me-2"></span>
                      Processing...
                    </span>
                    <span v-else>Generate Warranty Certificate</span>
                  </button>

                  <p class="text-center text-muted mt-3 mb-0">Your information is secure and will only be used for warranty registration.</p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <teleport to="body">
      <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true" data-bs-backdrop="static" style="display: none">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content p-3">
            <div class="modal-header border-0">
              <h5 class="modal-title fw-semibold" id="otpModalLabel">Email Verification</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
              <p class="text-muted mb-4">
                We’ve sent a 6-digit code to
                <strong>{{ formData.email }}</strong>
              </p>

              <div class="d-flex justify-content-center gap-2 mb-3">
                <input v-for="(digit, index) in otp" :key="index" v-model="otp[index]" maxlength="1" class="form-control text-center" :id="`otp-${index}`" @input="handleOtpInput($event, index)" style="width: 45px; font-size: 1.5rem" />
              </div>

              <button class="btn btn-primary w-100 mb-3" @click="verifyOtp">Verify OTP</button>
              <button class="btn btn-link text-decoration-none" @click="resendOtp">Resend OTP</button>
            </div>
          </div>
        </div>
      </div>
    </teleport>
  </div>

  <Footer />
</template>
