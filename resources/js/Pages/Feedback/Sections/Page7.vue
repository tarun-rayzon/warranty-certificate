<template>
  <div>
    <h2 class="text-center fw-bold text-white mb-4">Quality & Reliability</h2>

    <div class="mb-5 text-center">
      <p class="text-muted mb-2">Installation Quality</p>
      <NumberScale :modelValue="quality" @update:modelValue="updateQuality" />
      <div class="mt-2 text-white-50">{{ quality }}/10</div>
    </div>

    <div class="text-center">
      <p class="text-muted mb-2">System Reliability</p>
      <NumberScale :modelValue="reliability" @update:modelValue="updateReliability" />
      <div class="mt-2 text-white-50">{{ reliability }}/10</div>
    </div>
  </div>
</template>

<script>
import NumberScale from "./NumberScale.vue";

export default {
  props: ["feedbackData"],
  components: {
    NumberScale,
  },
  data() {
    return {
      quality: this.feedbackData.quality,
      reliability: this.feedbackData.reliability,
    };
  },
  computed: {
    isValid() {
      return this.quality > 0 && this.reliability > 0;
    }
  },
  methods: {
    updateQuality(val) {
      this.quality = val;
      this.$emit("updateData", { quality: val });
      this.$emit("valid", this.isValid);
    },
    updateReliability(val) {
      this.reliability = val;
      this.$emit("updateData", { reliability: val });
      this.$emit("valid", this.isValid);
    }
  },
  mounted() {
    // On load, emit initial valid state
    this.$emit("valid", this.isValid);
    this.$emit("updateData", {
      quality: this.quality,
      reliability: this.reliability
    });
  }
};
</script>