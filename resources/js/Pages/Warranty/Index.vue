<script setup>
import { ref, watch } from 'vue'
import FormSection from './FormSection.vue'
import { useForm } from '@inertiajs/vue3'

import Navbar from './Navbar.vue'
import Hero from './Hero.vue'
import About from './About.vue'
import Footer from './Footer.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

const submitted = ref(false)
const otpLoading = ref(false)
const resendCooldown = ref(0) // countdown value
let resendInterval = null // timer reference
const otpModal = ref(false)
const checkingSerial = ref(false)
const invalidSerials = ref([])
const serialCheckCompleted = ref(false)
const serialValid = ref(false)

const formData = useForm({
  name: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  state: '',
  pincode: '',
  purchase_date: '',
  invoice: null,
  serial_no: '',
  invoice_no: '',
})

const formatCommaSeparated = () => {
  formData.serial_no = String(formData.serial_no).replace(/\s+/g, ',').replace(/,+/g, ',').replace(/,\s*,/g, ',').replace(/,\s*$/, '')
  formData.serial_no = formData.serial_no.toLocaleUpperCase()
}

function handleFileChange(e) {
  const target = e.target
  if (target.files?.[0]) {
    formData.value.invoice = target.files[0]
  }
}

/*
|--------------------------------------------------------------------------
| HANDLE WARRANTY FORM SUBMISSION
|--------------------------------------------------------------------------
*/
const handleSubmit = () => {
  formData.post(route('public.request.submit'), {
    forceFormData: true,
    preserveScroll: true,

    onSuccess: () => {
      otpForm.reset()
      otpForm.email = formData.email
      otpModal.value = true
    },
  })
}

/*
|--------------------------------------------------------------------------
| VERIFY OTP
|--------------------------------------------------------------------------
*/
const otpForm = useForm({
  email: '',
  code: ['', '', '', '', '', ''],
})

const handleInput = (e, index) => {
  let value = e.target.value

  // Allow only numbers
  if (!/^[0-9]$/.test(value)) {
    otpForm.code[index] = ''
    return
  }

  // Move to next field
  if (index < otpForm.code.length - 1) {
    e.target.nextElementSibling?.focus()
  }
}

const handleBackspace = (e, index) => {
  if (otpForm.code[index] === '') {
    if (index > 0) {
      e.target.previousElementSibling?.focus()
    }
  }
}

const handlePaste = (e) => {
  const paste = e.clipboardData.getData('text').trim()

  if (/^\d{6}$/.test(paste)) {
    paste.split('').forEach((num, i) => {
      otpForm.code[i] = num
    })

    // Focus last input
    setTimeout(() => {
      document.querySelectorAll('.otp-input')[5].focus()
    }, 10)
  }

  e.preventDefault()
}

/*
|--------------------------------------------------------------------------
| VERIFY OTP
|--------------------------------------------------------------------------
*/
const verifyOtp = () => {
  const enteredOtp = otpForm.code.join('')

  if (enteredOtp.length < 6) {
    alert('Please enter all 6 digits.')
    return
  }

  otpLoading.value = true

  otpForm
    .transform(() => ({
      email: otpForm.email, // ✔ send correct email
      code: otpForm.code.join(''), // ✔ send string, not array
    }))
    .post(route('otp.verify'), {
      preserveScroll: true,

      onSuccess: (res) => {
        otpLoading.value = false
        otpModal.value = false
        submitted.value = true
      },

      onError: () => {
        otpLoading.value = false
        alert('Invalid or expired OTP.')
      },
    })
}

/*
|--------------------------------------------------------------------------
| RESEND OTP
|--------------------------------------------------------------------------
*/
const resendOtp = () => {
  if (resendCooldown.value > 0) return // prevent double-clicks
  

  otpForm.post(route('otp.send'), {
    preserveScroll: true,
    onSuccess: () => {
      alert('OTP sent again.')
      startCooldown() // 🔥 start the 60-sec timer
    },
  })
}

const startCooldown = () => {
  resendCooldown.value = 60 // 60 seconds

  // clear previous interval if any
  if (resendInterval) clearInterval(resendInterval)

  resendInterval = setInterval(() => {
    if (resendCooldown.value > 0) {
      resendCooldown.value--
    } else {
      clearInterval(resendInterval)
    }
  }, 1000)
}

/**
 * Check Serial Numbers
 */
const checkSerialNumbers = () => {
  checkingSerial.value = true
  invalidSerials.value = []
  serialCheckCompleted.value = false

  formData.post(route('serial.check'), {
    preserveScroll: true,
    onStart: () => {
      checkingSerial.value = true
    },
    onSuccess: () => {
      serialValid.value = true
      serialCheckCompleted.value = true
    },
    onError: (errors) => {
      serialValid.value = false
      invalidSerials.value = errors.serial_no ?? []
    },
    onFinish: () => {
      checkingSerial.value = false
    },
  })
}

// Watch for serial number changes
watch(
  () => formData.serial_no,
  () => {
    serialValid.value = false
  }
)
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
                      <InputLabel for="name" value="Name" />
                      <TextInput id="name" type="text" v-model="formData.name" :class="{ 'is-invalid': formData.errors.name }" placeholder="Enter your name" required />
                      <InputError class="mt-2" :message="formData.errors.name" />
                    </div>

                    <div class="col-md-6">
                      <InputLabel for="email" value="Email" />
                      <TextInput id="email" type="email" v-model="formData.email" :class="{ 'is-invalid': formData.errors.email }" placeholder="Enter your email" required />
                      <InputError class="mt-2" :message="formData.errors.email" />
                    </div>

                    <div class="col-md-6">
                      <InputLabel for="phone" value="Phone" />
                      <TextInput id="phone" type="tel" v-model="formData.phone" :class="{ 'is-invalid': formData.errors.phone }" placeholder="Enter your phone number" required />
                      <InputError class="mt-2" :message="formData.errors.phone" />
                    </div>

                    <div class="col-md-6">
                      <InputLabel for="purchase_date" value="Purchase Date" />
                      <TextInput id="purchase_date" type="date" v-model="formData.purchase_date" :class="{ 'is-invalid': formData.errors.purchase_date }" placeholder="Enter purchase date" required />
                      <InputError class="mt-2" :message="formData.errors.purchase_date" />
                    </div>
                  </div>
                </FormSection>

                <hr class="my-4" />

                <!-- Address Information -->
                <FormSection title="Address Information" description="Provide your complete address">
                  <div class="mb-3">
                    <InputLabel for="address" value="Address" />
                    <TextInput id="address" type="text" v-model="formData.address" :class="{ 'is-invalid': formData.errors.address }" placeholder="Enter your address" required />
                    <InputError class="mt-2" :message="formData.errors.address" />
                  </div>

                  <div class="row g-4">
                    <div class="col-md-6">
                      <InputLabel for="city" value="City" />
                      <TextInput id="city" type="text" v-model="formData.city" :class="{ 'is-invalid': formData.errors.city }" placeholder="Add City" required />
                      <InputError class="mt-2" :message="formData.errors.city" />
                    </div>

                    <div class="col-md-6">
                      <InputLabel for="state" value="State" />
                      <TextInput id="state" type="text" v-model="formData.state" :class="{ 'is-invalid': formData.errors.state }" placeholder="Add State" required />
                      <InputError class="mt-2" :message="formData.errors.state" />
                    </div>

                    <div class="col-md-6">
                      <InputLabel for="pincode" value="Pincode" />
                      <TextInput id="pincode" type="number" v-model="formData.pincode" :class="{ 'is-invalid': formData.errors.pincode }" placeholder="Add Pincode" required />
                      <InputError class="mt-2" :message="formData.errors.pincode" />
                    </div>
                  </div>
                </FormSection>

                <hr class="my-4" />

                <!-- Product Information -->
                <FormSection title="Product Information" description="Provide your product details">
                  <div class="mb-3">
                    <!-- Show invalid serial numbers -->
                    <div v-if="serialCheckCompleted" class="mt-3">
                      <div v-if="!serialValid" class="alert alert-danger">
                        <strong>Invalid Serials Found:</strong>
                        <ul class="mb-0">
                          <li v-for="s in invalidSerials" :key="s">{{ s }}</li>
                        </ul>
                      </div>

                      <div v-else class="alert alert-success">✔ All serial numbers are valid!</div>
                    </div>
                    <InputLabel for="serial_number" value="Serial Number" />
                    <TextInput id="serial_number" @input="formatCommaSeparated" type="text" v-model="formData.serial_no" :class="{ 'is-invalid': formData.errors.serial_no }" placeholder="Comma separated serial numbers" required />
                    <InputError class="mt-2" :message="formData.errors.serial_no" />
                    <!-- Check Button -->
                    <div class="text-end">
                      <button type="button" class="btn btn-outline-primary btn-sm mt-2" @click="checkSerialNumbers" :disabled="checkingSerial">
                        <span v-if="checkingSerial">
                          <span class="spinner-border spinner-border-sm me-2"></span>
                          Checking...
                        </span>
                        <span v-else>Check Serial Numbers</span>
                      </button>
                    </div>
                  </div>
                  <div class="mb-3">
                    <InputLabel for="invoice" value="Invoice Number" />
                    <TextInput id="invoice" type="text" v-model="formData.invoice_no" :class="{ 'is-invalid': formData.errors.invoice_no }" placeholder="Invoice Number" required />
                    <InputError class="mt-2" :message="formData.errors.invoice_no" />
                  </div>
                </FormSection>

                <hr class="my-4" />

                <!-- Document Upload -->
                <FormSection title="Invoice Document" description="Upload a copy of your purchase invoice">
                  <div class="rounded-3 p-4 text-center bg-light position-relative">
                    <input type="file" accept=".pdf,.jpg,.jpeg,.png" id="invoice-upload" class="position-absolute top-0 start-0 w-100 h-100 opacity-0 cursor-pointer" @change="handleFileChange" :class="{ 'is-invalid': formData.errors.invoice }" />
                    <InputError class="mt-2" :message="formData.errors.invoice" />
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
                  <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold" :disabled="formData.processing || !serialValid" :class="{ 'opacity-25': formData.processing || !serialValid }">
                    <span v-if="formData.processing" class="d-flex align-items-center justify-content-center">
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

    <BModal centered v-model="otpModal" hide-footer title="Email Verification" header-class="bg-white p-3" title-class="fs-14" no-body @hide.prevent hide-header-close>
      <div class="modal-body text-center">
        <p class="text-muted mb-4">
          We’ve sent a 6-digit code to
          <strong>{{ formData.email ?? 'your-email@example.com' }}</strong>
        </p>

        <form @submit.prevent="verifyOtp()">
          <div class="d-flex justify-content-center gap-2 mb-3">
            <input v-for="(digit, index) in otpForm.code" :key="index" type="text" maxlength="1" class="otp-input" v-model="otpForm.code[index]" @input="handleInput($event, index)" @keydown.backspace="handleBackspace($event, index)" @paste="handlePaste($event)" style="width: 45px; text-align: center; font-size: 1.5rem" required />
          </div>

          <button type="submit" class="btn btn-primary w-100 mb-3">Verify OTP</button>
          <button type="button" class="btn btn-link text-decoration-underline fw-semibold" @click="resendOtp" :disabled="resendCooldown > 0">
            <span v-if="resendCooldown === 0">Resend OTP</span>
            <span v-else>Resend in {{ resendCooldown }}s</span>
          </button>
        </form>
      </div>
    </BModal>
  </div>

  <Footer />
</template>
