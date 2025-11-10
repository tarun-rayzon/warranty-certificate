<template>
    <div class="loader" v-if="isLoading">
      <span v-for="(char, index) in characters" :key="index" :style="{ animationDelay: `${index * 0.5}s` }">
        {{ char }}
      </span>
    </div>
  </template>

  <script>
  export default {
    props: ["isLoading"],
    data() {
      return {
        characters: ["R", "A", "Y", "Z", "O", "N"],
      };
    },
  };
  </script>

  <style scoped>
  .loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    background-color: #ffffff7a; /* Set your desired background color */
  }

  .loader span {
    font-size: 3rem; /* Adjust font size */
    font-weight: bold;
    color: #095763; /* Rayzon logo color */
    opacity: 0;
    transform: scale(0.5);
    animation: fadeInScale 3s infinite ease-in-out;
  }

  @keyframes fadeInScale {
    0% {
      opacity: 0;
      transform: scale(0.5);
    }
    50% {
      opacity: 1;
      transform: scale(1);
    }
    100% {
      opacity: 0;
      transform: scale(0.5);
    }
  }
  </style>
