<template>
  <div class="d-flex flex-wrap justify-content-center gap-2">
    <button
      v-for="num in max"
      :key="num"
      type="button"
      class="btn rounded-circle border border-2 fw-bold transition-all"
      :class="{
        'bg-success border-success text-white scale-110': modelValue === num,
        'border-white text-white-50 hover-border-success': modelValue !== num
      }"
      style="width: 48px; height: 48px;"
      @click="$emit('update:modelValue', num)"
    >
      {{ num }}
    </button>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: Number,
    max: {
      type: Number,
      default: 10
    }
  },
  emits: ["update:modelValue"]
};
</script>

<style scoped>
.hover-border-success:hover {
  border-color: #198754 !important;
  transform: scale(1.05);
}
.scale-110 {
  transform: scale(1.1);
}
.transition-all {
  transition: all 0.2s ease;
}
</style>
