<script>
import { layoutComputed } from "@/state/helpers";
import { watch, computed } from 'vue'
import { usePage } from '@inertiajs/vue3';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

import Vertical from "./vertical.vue";
import Horizontal from "./horizontal.vue";
import TwoColumns from "./twocolumn.vue";

export default {
    components: {
        Vertical,
        Horizontal,
        TwoColumns
    },
    data() {
        return {};
    },
    computed: {
        ...layoutComputed,
    },
    mounted() {
        // document.querySelector("html").setAttribute('dir', 'rtl');
        // (event.ctrlKey && event.key === 'U')
        // document.addEventListener('keydown', function (event) {
        //     if (event.key === 'F12' || (event.ctrlKey && event.shiftKey && event.key === 'I') || (event.ctrlKey && event.shiftKey && event.key === 'C')) {
        //         event.preventDefault();
        //     }
        // });
    }
};
</script>

<script setup>

const toastBag = computed(() => {
    return usePage().props.flash
})

watch(toastBag, (newVal, oldVal) => {
    if (newVal && newVal.success) {
        toast.success(newVal.success, {
            autoClose: 3000,
        });
    }

    if (newVal && newVal.error) {
        toast.error(newVal.error, {
            autoClose: 3000,
        });
    }

})
</script>

<template>
    <div>
        <Vertical v-if="layoutType === 'vertical' || layoutType === 'semibox'" :layout="layoutType">
            <slot />
        </Vertical>

        <Horizontal v-if="layoutType === 'horizontal'" :layout="layoutType">
            <slot />
        </Horizontal>

        <!-- <TwoColumns v-if="layoutType === 'twocolumn'" :layout="layoutType">
            <slot />
        </TwoColumns> -->
    </div>
</template>
