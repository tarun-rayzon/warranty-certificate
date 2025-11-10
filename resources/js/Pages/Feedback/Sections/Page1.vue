<template>
  <div class="interactive-container">
    <div class="solar-animation">
      <div class="sun" @mousemove="trackMouse">
        <div class="sun-core"></div>
        <div class="sun-ray" v-for="n in 12" :key="n"
          :style="{ transform: `rotate(${n * 30}deg)`, opacity: rayOpacities[n - 1] }"></div>
      </div>

      <div class="solar-system">
        <div class="panel-panel" v-for="(panel, index) in panels" :key="index" :style="{
          left: `${panel.x}%`,
          top: `${panel.y}%`,
          transform: `rotate(${panel.rotation}deg) scale(${panel.scale})`,
          opacity: panel.opacity
        }" @mouseenter="activatePanel(index)" @mouseleave="deactivatePanel(index)">
          <div class="panel-grid">
            <div class="panel-cell" v-for="cell in 16" :key="cell"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="welcome-content">
      <h1 class="text-white">
        Solar EPC Solutions
      </h1>

      <p class="welcome-text text-muted">Your feedback powers our improvement</p>

      <button class="start-button" @click="$emit('updateData', {}); $emit('next')" @mouseenter="animateButton(true)"
        @mouseleave="animateButton(false)">
        <span class="button-text">Start Feedback</span>
        <div class="button-arrow">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
            stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14"></path>
            <path d="M12 5l7 7-7 7"></path>
          </svg>
        </div>
        <div class="button-energy"></div>
      </button>
    </div>

    <div class="row mt-3 g-4 mx-auto" style="max-width: 600px;">
      <div class="col text-center">
        <p class="text-success fw-medium mb-0"><i class="bi bi-sun-fill text-success"></i> Clean Energy
        </p>
      </div>
      <div class="col text-center">
        <p class="text-teal fw-medium mb-0"><i class="bi bi-lightning-charge-fill text-teal "></i> High
          Efficiency</p>
      </div>
      <div class="col text-center">
        <p class="text-info fw-medium mb-0"><i class="bi bi-leaf-fill text-info "></i> Eco Friendly</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Page1",
  data() {
    return {
      rayOpacities: Array(12).fill(0.6),
      headingRotations: Array(16).fill(0),
      panels: Array(5).fill().map((_, i) => ({
        x: 20 + (i * 15),
        y: 30 + Math.random() * 40,
        rotation: Math.random() * 360,
        scale: 0.8 + Math.random() * 0.4,
        opacity: 0.7,
        active: false
      })),
      mouseX: 0,
      mouseY: 0
    };
  },
  methods: {
    trackMouse(event) {
      this.mouseX = event.clientX;
      this.mouseY = event.clientY;
      this.animateRays();
    },
    animateRays() {
      const centerX = window.innerWidth / 2;
      const centerY = window.innerHeight / 2;
      const angle = Math.atan2(this.mouseY - centerY, this.mouseX - centerX) * (180 / Math.PI);

      this.rayOpacities = this.rayOpacities.map((_, i) => {
        const rayAngle = i * 30;
        const diff = Math.abs(((angle - rayAngle) + 180) % 360 - 180);
        return 0.3 + (0.7 * (1 - Math.min(diff, 45) / 45));
      });
    },
    activatePanel(index) {
      this.panels[index].active = true;
      this.panels[index].scale = 1.1;
      this.panels[index].opacity = 1;

      // Animate heading letters
      this.headingRotations = this.headingRotations.map((_, i) =>
        Math.random() * 10 - 5
      );
    },
    deactivatePanel(index) {
      this.panels[index].active = false;
      this.panels[index].scale = 0.8 + Math.random() * 0.4;
      this.panels[index].opacity = 0.7;

      // Reset heading letters
      this.headingRotations = Array(16).fill(0);
    },
    animateButton(hover) {
      if (hover) {
        this.headingRotations = this.headingRotations.map((_, i) =>
          Math.random() * 15 - 7.5
        );
      } else {
        this.headingRotations = Array(16).fill(0);
      }
    }
  },
  mounted() {
    // Initial animation
    setTimeout(() => {
      this.headingRotations = this.headingRotations.map((_, i) =>
        Math.random() * 20 - 10
      );
      setTimeout(() => {
        this.headingRotations = Array(16).fill(0);
      }, 1000);
    }, 500);
  }
};
</script>
