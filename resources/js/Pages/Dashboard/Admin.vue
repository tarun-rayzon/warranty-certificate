<script setup>
import Layout from "@/Layouts/main.vue";
import { Head } from "@inertiajs/vue3";

</script>
<template>
    <Layout>

        <Head title="Dashboard" />

        <BRow class="mb-3 pb-1">
            <BCol cols="12">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <h4 class="fs-16 mb-1">Hello, {{ $page.props.auth.user.name }}!</h4>
                        <p class="text-muted mb-0">Here's what's happening with your company.</p>
                    </div>
                </div><!-- end card header -->
            </BCol>
        </BRow>


    </Layout>

</template>
