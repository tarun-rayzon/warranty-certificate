<script setup>
defineProps({
    value: String,
    required: {
        type: Boolean,
        default: true
    }
});
</script>

<template>
    <label class="form-label" v-if="value">
        {{ value }} <span class="text-danger" v-if="required == true">*</span>
    </label>
</template>
