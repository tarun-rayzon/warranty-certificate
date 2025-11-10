<script>
import Page1 from './Sections/Page1.vue';
import Page2 from './Sections/Page2.vue';
import Page3 from './Sections/Page3.vue';
import Page4 from './Sections/Page4.vue';
import Page5 from './Sections/Page5.vue';
import Page6 from './Sections/Page6.vue';
import Page7 from './Sections/Page7.vue';
import Page8 from './Sections/Page8.vue';
import Page9 from './Sections/Page9.vue';
import Page10 from './Sections/Page10.vue';
import Page11 from './Sections/Page11.vue';

export default {
    components: {
        Page1,
        Page2,
        Page3,
        Page4,
        Page5,
        Page6,
        Page7,
        Page8,
        Page9,
        Page10,
        Page11,
    },
    data() {
        return {
            currentPage: 1,
            isPageValid: true,
            feedbackData: {
                questions: [],
                satisfaction: 0,
                timeline: 50,
                budget: 50,
                communication: 0,
                issuesResolved: "",
                quality: 0,
                reliability: 0,
                recommend: 0,
                improvement: "",
                feedback: ""
            },
        };
    },
    computed: {
        currentComponent() {
            return `Page${this.currentPage}`;
        }
    },
    methods: {
        nextPage() {
            if (this.currentPage < 11) this.currentPage++;
        },
        prevPage() {
            if (this.currentPage > 1) this.currentPage--;
        },
        updateData(newData) {
            this.feedbackData = { ...this.feedbackData, ...newData };
        },
        handleSubmit() {
            console.log("Final Feedback Data:", this.feedbackData);
        },
        indicatorStyle(index) {
            return {
                width: this.currentPage === index + 1 ? '20px' : '10px',
                height: '10px',
                backgroundColor: this.currentPage === index + 1 ? '#0ab39c' : '#aaa',
                display: 'inline-block'
            };
        },
        onPageValid(valid) {
            this.isPageValid = valid;
        }
    }
};
</script>

<template>
    <div class="rising-lines-background">
        <span class="line" v-for="n in 30" :key="n"></span>
    </div>
    
    <div class="min-vh-100 d-flex align-items-center justify-content-center text-white p-3 main-container">
        <div class="feedback-card card w-100" style="max-width: 720px;">
            <div class="card-body">
                <img src="https://rayzongreen.com/assets/img/logo/logo-white.png" alt=""
                    class="img-fluid d-block mx-auto">
                <!-- Progress Bar -->
                <div v-if="currentPage > 1 && currentPage < 11" class="mt-4 mb-0">
                    <div class="d-flex justify-content-between mb-2 small text-white">
                        <span>Steps</span>
                        <span>{{ Math.round(((currentPage - 1) / 10) * 100) }}%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" :style="{ width: ((currentPage - 1) / 10 * 100) + '%' }">
                        </div>
                    </div>
                </div>

                <!-- Page Content -->
                <div class="page-content d-flex flex-column justify-content-center text-white">
                    <div class="container">
                        <component :is="currentComponent" :feedbackData="feedbackData" @updateData="updateData"
                            @next="nextPage" @prev="prevPage" @submit="handleSubmit" @valid="onPageValid" />
                    </div>
                </div>

                <!-- Navigation -->
                <div v-if="currentPage > 1 && currentPage < 11" class="d-flex justify-content-between mt-5">
                    <button class="btn btn-outline-light" @click="prevPage">
                        <i class="bi bi-arrow-left"></i> Previous
                    </button>
                    <button class="btn btn-success" @click="nextPage" :disabled="!isPageValid">
                        Next <i class="bi bi-arrow-right"></i>
                    </button>
                </div>

                <!-- Page Indicator -->
                <div v-if="currentPage > 1 && currentPage < 10" class="d-flex justify-content-center mt-3 gap-2 indicator">
                    <span v-for="i in 10" :key="i" class="rounded indicator-icon" :style="indicatorStyle(i + 0)"></span>
                </div>
            </div>
        </div>
    </div>
</template>
