<script setup>

defineProps({
    total_roles: {
        type: Number,
        default: 0
    }
})
</script>

<template>
    <BRow>
        <BCol xl="3" md="6">
            <!-- card -->
            <BCard class="card border-0 shadow-sm card-animate summary-card">
                <div class="d-flex align-items-center mb-2">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Roles</p>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-0">{{ total_roles }}</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-primary-subtle border border-primary border-dashed rounded-circle fs-4">
                            <i class='bx bx-user text-primary'></i>
                        </span>
                    </div>
                </div>
            </BCard><!-- end card -->
        </BCol>
    </BRow>
</template>