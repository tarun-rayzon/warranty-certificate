<script setup>
defineProps({
    title: String,
    total: [String, Number],
    icon: String,
    color: String,
    classname: String
})
</script>

<template>
    <!-- card -->
    <div class="card border-0 shadow-sm card-animate " :class="classname">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 overflow-hidden">
                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">{{ title }}</p>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-2">
                <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ total ?? 0 }}</h4>

                <div class="avatar-sm">
                    <span class="avatar-title rounded-circle border-1 border-dashed fs-3" :class="'bg-' + color + '-subtle' + ' border-' + color">
                        <i :class="icon + ' text-' + color"></i>
                    </span>
                </div>
            </div>
        </div>
    </div><!-- end card -->
</template>
