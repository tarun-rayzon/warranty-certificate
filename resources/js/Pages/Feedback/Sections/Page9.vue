<template>
  <div class="text-center">
    <h2 class="text-white">Service Improvement</h2>
    <p class="text-muted">What's one key thing we could improve in our service?</p>
    <textarea class="form-control" rows="4" v-model="improvement" placeholder="Your suggestion..."></textarea>
  </div>
</template>

<script>
export default {
  props: ["feedbackData"],
  data() {
    return {
      improvement: this.feedbackData.improvement,
    };
  },
  watch: {
    improvement(val) {
      this.$emit("updateData", { improvement: val });
    },
  },
};
</script>
