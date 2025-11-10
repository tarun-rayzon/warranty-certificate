<template>
  <div>
    <h2 class="text-center text-white">Timeline & Budget</h2>

    <div class="my-4">
      <label class="form-label text-muted">Project Timeline Rating</label>
      <input type="range" class="form-range custom-range-success" min="0" max="100" v-model="timeline" />
      <div class="text-center">{{ timeline }}%</div>
    </div>

    <div>
      <label class="form-label text-muted">Budget Management Rating</label>
      <input type="range" class="form-range custom-range-success" min="0" max="100" v-model="budget" />
      <div class="text-center">{{ budget }}%</div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["feedbackData"],
  data() {
    return {
      timeline: this.feedbackData.timeline,
      budget: this.feedbackData.budget,
      timelineTouched: false,
      budgetTouched: false
    };
  },
  computed: {
    isValid() {
      return this.timelineTouched && this.budgetTouched;
    }
  },
  watch: {
    timeline(val) {
      this.timelineTouched = true;
      this.$emit("updateData", { timeline: val });
      this.$emit("valid", this.isValid);
    },
    budget(val) {
      this.budgetTouched = true;
      this.$emit("updateData", { budget: val });
      this.$emit("valid", this.isValid);
    }
  },
  mounted() {
    // Set as invalid initially
    this.$emit("valid", this.isValid);
    // Still sync the initial values
    this.$emit("updateData", {
      timeline: this.timeline,
      budget: this.budget
    });
  }
};
</script>
