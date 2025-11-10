<template>
  <div class="text-center">
    <h2 class="text-white">Additional Feedback</h2>
    <p class="text-muted">Any other comments about your experience?</p>
    <textarea class="form-control" rows="4" v-model="feedback" placeholder="Additional comments..."></textarea>
    <!-- <button type="submit" class="btn btn-success mt-3 d-flex mx-auto" @click="handleSubmit">Done <i class="bi bi-hand-thumbs-up ms-3"></i></button> -->
  </div>
</template>

<script>
export default {
  props: ["feedbackData"],
  data() {
    return {
      feedback: this.feedbackData.feedback,
    };
  },
  watch: {
    feedback(val) {
      this.$emit("updateData", { feedback: val });
    },
  },
  methods: {
    handleSubmit() {
      // Update parent with latest feedback and trigger submission
      this.$emit("updateData", { feedback: this.feedback });
      this.$emit("submit");
      this.nextPage();
    },
  },
};
</script>
