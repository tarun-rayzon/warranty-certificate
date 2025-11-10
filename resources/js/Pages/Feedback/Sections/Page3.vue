<template>
  <div>
    <SatisfactionRating
      v-model="satisfaction"
      @updateData="emit('updateData', $event)"
      @valid="emit('valid', $event)"
    />
  </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import SatisfactionRating from './SatisfactionRating.vue';

const props = defineProps({
  feedbackData: Object
});
const emit = defineEmits(['updateData', 'valid']);

const satisfaction = ref(props.feedbackData.satisfaction || 0);

watch(satisfaction, (val) => {
  emit('updateData', { satisfaction: val });
  emit('valid', val > 0);
});
</script>
