<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'

import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

const showOtpField = ref(false)
const resendCooldown = ref(0) // countdown value
let resendInterval = null // timer reference

const form = useForm({
  email: '',
  code: ['', '', '', '', '', ''],
})

const sendOtp = () => {
  form.post(route('otp.send'), {
    onSuccess: () => {
      showOtpField.value = true
      form.email = form.email // ensure email is set
      startCooldown()
    },
    onError: () => {
      showOtpField.value = false
    },
  })
}

/*
|--------------------------------------------------------------------------
| VERIFY OTP
|--------------------------------------------------------------------------
*/
const verifyOtp = () => {
  const enteredOtp = form.code.join('')

  if (enteredOtp.length < 6) {
    alert('Please enter all 6 digits.')
    return
  }

  form
    .transform(() => ({
      email: form.email, // ✔ send correct email
      code: form.code.join(''), // ✔ send string, not array
    }))
    .post(route('otp.verify'), {
      preserveScroll: true,

      onSuccess: (res) => {
        submitted.value = true
      },

      onError: () => {
        alert('Invalid or expired OTP.')
      },
    })
}

const handleInput = (e, index) => {
  let value = e.target.value

  // Allow only numbers
  if (!/^[0-9]$/.test(value)) {
    form.code[index] = ''
    return
  }

  // Move to next field
  if (index < form.code.length - 1) {
    e.target.nextElementSibling?.focus()
  }
}

const handleBackspace = (e, index) => {
  if (form.code[index] === '') {
    if (index > 0) {
      e.target.previousElementSibling?.focus()
    }
  }
}

const handlePaste = (e) => {
  const paste = e.clipboardData.getData('text').trim()

  if (/^\d{6}$/.test(paste)) {
    paste.split('').forEach((num, i) => {
      form.code[i] = num
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
| RESEND OTP
|--------------------------------------------------------------------------
*/
const resendOtp = () => {
  if (resendCooldown.value > 0) return // prevent double-clicks

  form.post(route('otp.send'), {
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
</script>

<template>
  <div class="auth-page-wrapper pt-5">
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
      <div class="bg-overlay"></div>

      <div class="shape">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
          <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
        </svg>
      </div>
    </div>

    <div class="auth-page-content">
      <BContainer>
        <BRow>
          <BCol lg="12">
            <div class="text-center mt-sm-5 mb-4 text-white-50">
              <div>
                <Link :href="route('public.request.create')" class="d-inline-block auth-logo">
                  <img src="@assets/images/logo-light.png" alt="" height="30" />
                </Link>
              </div>
            </div>
          </BCol>
        </BRow>

        <BRow class="justify-content-center">
          <BCol md="8" lg="6" xl="5">
            <div class="card">
              <div class="card-body">
                <div class="text-center mt-2">
                  <h5 class="text-primary">Welcome Back !</h5>
                  <p class="text-muted">{{ showOtpField ? 'Enter OTP' : 'Login with Email' }}</p>
                </div>
                <div class="p-2 mt-3" v-if="!showOtpField">
                  <form @submit.prevent="sendOtp">
                    <div class="mb-3">
                      <!-- Email Field -->
                      <InputLabel for="email" value="Email" />
                      <TextInput id="email" type="email" class="form-control" v-model="form.email" required autofocus placeholder="Please enter your email" :class="{ 'is-invalid': form.errors.email }" />
                      <InputError :message="form.errors.email" class="mt-2" />
                    </div>

                    <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">
                      <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                      {{ form.processing ? 'Sending...' : 'Send OTP' }}
                    </button>
                  </form>
                </div>

                <!-- OTP Field -->
                <div v-else>
                  <p class="text-muted mb-3 text-center">
                    We’ve sent a 6-digit OTP to
                    <strong>{{ form.email }}</strong>
                  </p>

                  <form @submit.prevent="verifyOtp()">
                    <div class="d-flex justify-content-center gap-2 mb-3">
                      <input v-for="(digit, index) in form.code" :key="index" type="text" maxlength="1" class="otp-input" v-model="form.code[index]" @input="handleInput($event, index)" @keydown.backspace="handleBackspace($event, index)" @paste="handlePaste($event)" style="width: 45px; text-align: center; font-size: 1.5rem" required />
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary w-100 mb-2" :disabled="form.processing">
                        <span v-if="form.processing" class="spinner-border spinner-border-sm me-2"></span>
                        {{ form.processing ? 'Verifying...' : 'Verify OTP' }}
                      </button>
                      <button type="button" class="btn btn-link text-decoration-underline fw-semibold" @click="resendOtp" :disabled="resendCooldown > 0">
                        <span v-if="resendCooldown === 0">Resend OTP</span>
                        <span v-else>Resend in {{ resendCooldown }}s</span>
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </BCol>
        </BRow>
      </BContainer>
    </div>

    <footer class="footer">
      <BContainer>
        <BRow>
          <BCol lg="12">
            <div class="text-center">
              <p class="mb-0 text-muted">
                &copy; {{ new Date().getFullYear() }} Rayzon. Crafted with
                <i class="mdi mdi-heart text-danger"></i>
                by Rayzon Solar
              </p>
            </div>
          </BCol>
        </BRow>
      </BContainer>
    </footer>
  </div>
</template>
