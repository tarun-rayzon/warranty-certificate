<template>
  <div class="nps-container">
    <div class="nps-header">
      <h2 class="nps-title">How likely are you to recommend Rayzon Solar?</h2>
      <p class="nps-subtitle">(Net Promoter Score)</p>
    </div>

    <div class="nps-scale">
      <div class="nps-numbers d-flex flex-wrap justify-content-center gap-2">
        <span 
          v-for="n in 11" 
          :key="n" 
          class="nps-number"
          :class="{ 
            'active': n-1 === recommend,
            'promoter': n-1 >= 9,
            'passive': n-1 >= 5 && n-1 <= 8,
            'detractor': n-1 <= 4
          }"
          @click="setScore(n-1)"
        >
          {{ n-1 }}
        </span>
      </div>
      <div class="nps-labels">
        <span>Not at all likely</span>
        <span>Extremely likely</span>
      </div>
    </div>

    <div class="nps-feedback" :class="feedbackClass">
      <div class="nps-badge">
        <span class="nps-icon">
          <template v-if="label.includes('Promoter')">
            👍
          </template>
          <template v-else-if="label.includes('Passive')">
            🤔
          </template>
          <template v-else>
            👎
          </template>
        </span>
        <strong>{{ label }}</strong>
      </div>
      <p class="nps-message">
        <template v-if="label.includes('Promoter')">
          We're thrilled you had a great experience! Thank you for being our advocate.
        </template>
        <template v-else-if="label.includes('Passive')">
          We appreciate your feedback. We'll work to improve your experience.
        </template>
        <template v-else-if="label.includes('Detractor')">
          We're sorry to hear this. We'd love to learn how we can do better.
        </template>
        <template v-else>
          Slide to select your rating
        </template>
      </p>
    </div>
  </div>
</template>

<script>
export default {
  props: ["feedbackData"],
  data() {
    return {
      recommend: this.feedbackData.recommend || 0,
    };
  },
  computed: {
    label() {
      if (this.recommend >= 9) return "Promoter - Thank you!";
      if (this.recommend >= 7) return "Passive";
      if (this.recommend > 0) return "Detractor";
      return "Select your score";
    },
    isValid() {
      return this.recommend > 0;
    },
    feedbackClass() {
      return {
        'promoter': this.recommend >= 9,
        'passive': this.recommend >= 5 && this.recommend < 9,
        'detractor': this.recommend > 0 && this.recommend < 5,
        'empty': this.recommend === 0
      };
    }
  },
  methods: {
    setScore(score) {
      this.recommend = score;
      this.$emit("updateData", { recommend: score });
      this.$emit("valid", this.isValid);
    }
  },
  watch: {
    recommend(val) {
      this.$emit("updateData", { recommend: val });
      this.$emit("valid", this.isValid);
    },
  },
  mounted() {
    this.$emit("updateData", { recommend: this.recommend });
    this.$emit("valid", this.isValid);
  }
};
</script>