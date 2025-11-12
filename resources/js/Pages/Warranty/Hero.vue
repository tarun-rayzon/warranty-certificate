<script setup>
import { onMounted, onUnmounted, ref } from 'vue'
import bannerImage from '@assets/images/banner-image.png'

const textList = ['Generate', 'Manage', 'Download']
const currentIndex = ref(0)
let timer = null

// interval in ms
const DELAY = 2500

onMounted(() => {
  timer = setInterval(() => {
    currentIndex.value = (currentIndex.value + 1) % textList.length
  }, DELAY)
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
})
</script>

<template>
  <section class="hero-section d-flex align-items-center position-relative">
    <div class="hero-bg" :style="{ backgroundImage: `url(${bannerImage})` }">
      <div class="hero-overlay"></div>
    </div>

    <div class="container position-relative">
      <div class="row align-items-start">
        <div class="col-lg-7">
          <div class="mb-4 d-inline-flex align-items-center gap-2 px-3 py-2 rounded border backdrop-blur">
            <i class="bi bi-file-earmark-check text-white"></i>
            <span class="text-white small fw-semibold">Enterprise-Grade Portal</span>
          </div>

          <h1 class="display-4 fw-bold text-warning">
            <transition name="fade" mode="out-in">
              <span class="animated-word d-inline-block" :key="currentIndex" aria-live="polite">
                {{ textList[currentIndex] }}
              </span>
            </transition>
          </h1>

          <h1 class="display-4 fw-bold">
            <span class="text-white mb-4">Warranty Certificate</span>
          </h1>

          <p class="lead text-light opacity-75 mb-4">Streamlined access to all your solar panel warranty documentation. Manage certificates, track expiration dates, and submit claims.</p>

          <div class="system-info">
            <div class="d-sm-flex d-block align-items-center justify-content-between gap-4">
              <div class="d-flex flex-column text-center mb-sm-0 mb-3">
                <span class="h3 text-light">15 years</span>
                <span class="text-light opacity-75">Materials Warranty</span>
              </div>
              <span class="status-dot bg-warning"></span>
              <div class="d-flex flex-column text-center mb-sm-0 mb-3">
                <span class="h3 text-light">30 years</span>
                <span class="text-light opacity-75">80% Power Warranty</span>
              </div>
              <span class="status-dot bg-warning"></span>
              <div class="d-flex flex-column text-center mb-sm-0 mb-3">
                <span class="h3 text-light">ISO</span>
                <span class="text-light opacity-75">27001 Certified</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
