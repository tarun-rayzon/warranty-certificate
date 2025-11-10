<template>
  <div class="rating-container">
    <h2 class="rating-title">Overall Satisfaction</h2>
    <p class="text-muted">How would you rate our project execution and the quality of our workmanship?</p>

    <div class="emoji-container">
      <div v-for="emoji in emojis" :key="emoji.value" class="emoji-item"
           :class="{ 'active': modelValue === emoji.value }"
           @click="updateSatisfaction(emoji.value)">
        <div class="emoji-icon-wrapper">
          <i :class="[
            'bi',
            modelValue === emoji.value ? emoji.filledIcon : emoji.icon,
            'emoji-icon',
            modelValue === emoji.value ? 'selected' : emoji.color
          ]"></i>
        </div>
        <span :class="['emoji-label', { 'text-white fw-bold': modelValue === emoji.value }]">
          {{ emoji.label }}
        </span>
      </div>
    </div>

    <div class="selected-value" v-if="modelValue">
      Selected: <strong>{{ selectedLabel }}</strong>
    </div>
  </div>
</template>

<script setup>
import { computed, watch } from 'vue';

const props = defineProps({
  modelValue: {
    type: Number,
    default: 0
  }
});
const emit = defineEmits(['update:modelValue', 'updateData', 'valid']);

const emojis = [
  { icon: 'bi-emoji-frown', filledIcon: 'bi-emoji-frown-fill', label: 'Poor', value: 1, color: 'emoji-poor' },
  { icon: 'bi-emoji-neutral', filledIcon: 'bi-emoji-neutral-fill', label: 'Fair', value: 2, color: 'emoji-fair' },
  { icon: 'bi-emoji-smile', filledIcon: 'bi-emoji-smile-fill', label: 'Good', value: 3, color: 'emoji-good' },
  { icon: 'bi-emoji-smile', filledIcon: 'bi-emoji-smile-fill', label: 'Great', value: 4, color: 'emoji-great' },
  { icon: 'bi-emoji-heart-eyes', filledIcon: 'bi-emoji-heart-eyes-fill', label: 'Excellent', value: 5, color: 'emoji-excellent' },
];

const selectedLabel = computed(() => {
  const selected = emojis.find(e => e.value === props.modelValue);
  return selected ? selected.label : '';
});

function updateSatisfaction(value) {
  emit('update:modelValue', value);
  emit('updateData', { satisfaction: value });
  emit('valid', true);
}

watch(
  () => props.modelValue,
  (val) => {
    emit('valid', val > 0);
  },
  { immediate: true }
);
</script>

<style scoped>

</style>
