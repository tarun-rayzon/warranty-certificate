<template>
  <div class="text-center">
    <h2 class="text-white">Issue Resolution</h2>
    <p class="text-muted">Were any issues during the project resolved satisfactorily?</p>
    <div class="d-flex justify-content-center gap-3 mt-5">
      <button @click="set('yes')" class="btn"
        :class="issuesResolved === 'yes' ? 'btn-success' : 'btn-outline-success'"><i
          class="bi bi-hand-thumbs-up fs-1 mb-2" :class="issuesResolved === 'yes' ? 'text-white' : 'text-success'"></i><br>
        Yes, Resolved</button>
      <button @click="set('no')" class="btn" :class="issuesResolved === 'no' ? 'btn-danger' : 'btn-outline-danger'"><i
          class="bi bi-hand-thumbs-down fs-1 mb-2" :class="issuesResolved === 'no' ? 'text-white' : 'text-danger'"></i><br>
        No Issues</button>
      <button @click="set('none')" class="btn" :class="issuesResolved === 'none' ? 'btn-info' : 'btn-outline-info'"><i
          class="bi bi-check-circle fs-1 mb-2" :class="issuesResolved === 'none' ? 'text-white' : 'text-info'"></i><br>
        No Issues Occurred</button>
    </div>
  </div>
</template>

<script>
export default {
  props: ["feedbackData"],
  data() {
    return {
      issuesResolved: this.feedbackData.issuesResolved,
    };
  },
  methods: {
    set(val) {
      this.issuesResolved = val;
      this.$emit("updateData", { issuesResolved: val });
      this.$emit("valid", true); // mark as valid when user selects
    },
  },
  mounted() {
    // If value already exists (e.g. going back), emit valid state
    this.$emit("valid", this.issuesResolved !== "");
  },
};
</script>