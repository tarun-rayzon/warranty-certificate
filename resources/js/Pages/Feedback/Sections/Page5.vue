<template>
  <div class="text-center">
    <h2 class="text-white">Communication Rating</h2>
    <p class="text-muted">How would you rate our communication throughout the project?</p>
    <div class="btn-group mt-4" role="group">
      <button
        v-for="star in 5"
        :key="star"
        type="button"
        class="btn"
        :class="communication >= star ? 'btn-warning text-white' : 'btn-outline-light'"
        @click="selectRating(star)"
        style="font-size: 30px;"
      >
        ★
      </button>
    </div>
    <div class="mt-2">{{ communication }} out of 5</div>
  </div>
</template>

<script>
export default {
  props: ["feedbackData"],
  data() {
    return {
      communication: this.feedbackData.communication,
    };
  },
  methods: {
    selectRating(star) {
      this.communication = star;
      this.$emit("updateData", { communication: star });
      this.$emit("valid", true); // only emit valid after selection
    }
  },
  mounted() {
    // If communication was already selected before, set valid state
    this.$emit("valid", this.communication > 0);
  }
};
</script>
