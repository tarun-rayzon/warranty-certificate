<template>
  <section class="mb-4">
    <header class="mb-3">
      <h5 class="fw-bold text-dark mb-1">{{ title }}</h5>
      <p class="text-muted small mb-0">{{ description }}</p>
    </header>
    <div>
      <slot />
    </div>
  </section>
</template>

<script setup>
defineProps({
  title: String,
  description: String,
})
</script>
