<template>
    <div v-if="links.length > 3" class="pt-4">
        <div class="d-flex flex-wrap my-3 justify-content-center">
            <div class="mt-3 px-3 mt-sm-0">
                <ul class="pagination pagination-separated pagination-sm mb-0 justify-content-center">
                    <template v-for="(link, p) in links" :key="p">
                        <li class="page-item disabled mx-1 border rounded p-1" v-if="link.url === null" v-html="link.label">

                        </li>
                        <li class="page-item" v-else>
                            <Link class="page-link" :class="link.active ? 'bg-primary text-white' : 'hover-bg-white focus-border-primary focus-text-primary'" :href="link.url" v-html="link.label"></Link>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </div>
</template>
<script>

import { Link } from "@inertiajs/vue3";

export default {
    props: {
        links: Object
    },
    components: {
        Link
    }
}
</script>
