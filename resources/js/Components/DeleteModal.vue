<script>
import Lottie from '@/Components/widgets/lottie.vue'
import animationData from '@/Components/widgets/gsqxdxog.json'

export default {
    components: { Lottie, animationData },
  data() {
    return {
      animationData,
    }
  },
  props: {
    modelValue: Boolean,
    itemName: { type: String, default: 'item' },
  },
  emits: ['confirm', 'update:modelValue'],
  setup(props, { emit }) {

    const confirmDelete = () => {
      emit('confirm')
      emit('update:modelValue', false)
    }

    return { confirmDelete }
  },
}
</script>

<template>
  <BModal centered :model-value="modelValue" @update:model-value="$emit('update:modelValue', $event)" hide-header hide-footer>
    <div class="text-center mb-3">
      <lottie class="avatar-xl" stroke="#f06548" colors="primary:#f06548,secondary:#f7b84b" :options="{ animationData: animationData }" :height="100" :width="100" />
      <h4 class="mt-2">You are sure ?</h4>
      <p class="text-muted mx-4 mb-0">Are you sure you want to remove this {{ itemName }} ?</p>
    </div>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
      <b>Warning: </b>
      <span>By deleting this {{ itemName }}, it will be permanently removed from the system. This action cannot be undone.</span>
    </div>
    <div class="d-flex justify-content-center gap-1 mt-4">
      <button type="button" class="btn btn-light btn-sm" @click="$emit('update:modelValue', false)">Cancel</button>
      <button type="button" class="btn btn-danger btn-sm" @click="confirmDelete">Yes, Delete it!</button>
    </div>
  </BModal>
</template>
