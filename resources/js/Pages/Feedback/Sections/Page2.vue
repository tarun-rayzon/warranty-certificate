<template>
  <div>
    <h2 class="text-center text-white">Project Questions</h2>
    <form action="" class="mt-4">
      <input type="text" class="form-control mb-3" placeholder="Enter your Company Name " v-model="questions[0]"
        @input="$emit('updateData', { company: questions[0] })" />
      <input type="text" class="form-control mb-3" placeholder="Enter your name" v-model="questions[1]"
        @input="$emit('updateData', { name: questions[1] })" />
      <input type="email" class="form-control mb-3" placeholder="Enter your email" v-model="questions[2]"
        @input="$emit('updateData', { email: questions[2] })" />
      <input type="tel" class="form-control mb-3" placeholder="Enter your phone number" v-model="questions[3]"
        @input="$emit('updateData', { phone: questions[3] })" />
    </form>
  </div>
</template>

<script>
export default {
  name: "Page2",
  props: ["feedbackData"],
  data() {
    return {
      questions: this.feedbackData.questions.length
        ? [...this.feedbackData.questions]
        : ["", ""],
    };
  },
  computed: {
    isValid() {
      return this.questions.every(q => q !== "");
    },
  },
  watch: {
    questions: {
      handler(val) {
        this.$emit("updateData", { questions: val });
        this.$emit("valid", this.isValid);
      },
      deep: true,
      immediate: true,
    },
  },
};
</script>