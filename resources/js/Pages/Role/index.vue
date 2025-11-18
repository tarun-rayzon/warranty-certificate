<script setup>
import { ref, defineProps, watch } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import Layout from '@/Layouts/main.vue';
import PageHeader from '@/Components/page-header.vue';
import Widget from './widgets.vue';
import CommonTable from '@/Components/CommonDataTable.vue';
import DeleteModal from '@/Components/DeleteModal.vue';

const props = defineProps({
    roles: {
        type: Object,
        default: () => ({
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
            from: 1,
            to: 1,
        }),
    },
    permissions: {
        type: Object,
        default: () => [],
    },
    total_roles: {
        type: Number,
        default: 0,
    }
});

const showModal = ref(false);
const deleteRoleModal = ref(false);
const editRoleModal = ref(false);
const productBeingDeleted = ref(null);

const form = useForm({
    name: null,
    permissions: [],
});

const openCreateRoleModal = () => {
    form.reset();
    form.errors = {};
    showModal.value = true;
}

const store = () => {
    form.post(route('role.store'), {
        preserveScroll: true,
        onSuccess: () => {
            showModal.value = false;
            form.reset();
        },
    });
}

const openEditRoleModal = (role) => {
    form.reset();
    form.id = role.id;
    form.name = role.name;
    form.permissions = role.permissions.map(permission => permission.name);
    editRoleModal.value = true;
}

const updateRole = () => {
    form.transform(data => ({
        ...data,
    })).patch(route('role.update', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            editRoleModal.value = false;
            form.reset();
        },
    });
}

const openDeleteRoleModal = (RoleId) => {
    deleteRoleModal.value = true;
    productBeingDeleted.value = RoleId;
};

const deleteRole = () => {
    form.delete(route('role.destroy', productBeingDeleted.value), {
        preserveScroll: true,
        onFinish: () => {
            deleteRoleModal.value = false;
        },
    });
}

const columns = [
    { key: 'id', label: 'ID', sortable: false, width: '80px' },
    { key: 'name', label: 'Role', sortable: false, width: '250px' },
    { key: 'permissions.name', label: 'Permissions', sortable: false },
    { key: 'action', label: 'Action', sortable: false },
]

const itemsPerPage = ref(10)

watch(itemsPerPage, () => {
    this.goToPage(1)
})
</script>

<script>
export default {
    data() {
        return {
            filters: {
                search: '',
            },
        }
    },
    created() {
        if (this.$page.props.filters) {
            this.filters = { ...this.filters, ...this.$page.props.filters };
        }
    },
    methods: {
        search() {
            const query = Object.fromEntries(
                Object.entries(this.filters).filter(([_, value]) => {
                    return Array.isArray(value) ? value.length > 0 : value;
                })
            );

            this.$inertia.get(this.route('role.index'), query, { replace: true, preserveState: true })
        },
        goToPage(page) {
            this.$inertia.get(this.route('role.index'), {
                ...this.filters,
                page,
            }, {
                replace: true,
                preserveState: true,
                preserveScroll: true,
            });
        },
    },
}
</script>

<template>
    <Layout>

        <Head title="Role" />
        <PageHeader title="Master" pageTitle="Roles" />

        <Widget :total_roles="total_roles" />

        <BRow>
            <BCol lg="12">
                <BCard no-body class="card" id="rolesList">
                    <BCardHeader class="border-1">
                        <div class="d-flex align-items-center">
                            <h5 class="card-title mb-0 flex-grow-1">All Roles</h5>
                            <div class="flex-shrink-0">
                                <div class="d-flex flex-wrap gap-2">
                                    <button class="btn btn-outline-primary btn-sm add-btn" @click="openCreateRoleModal">
                                        <i class="ri-add-line align-bottom me-1"></i> Create
                                    </button>
                                </div>
                            </div>
                        </div>
                    </BCardHeader>
                    <CommonTable :columns="columns" :pagination="roles" @update:page="goToPage"
                        v-model:itemsPerPage="itemsPerPage" :showColumnToggle="false">
                        <template #filters>
                            <div class="row g-3 flex-wrap align-items-center">
                                <div class="col-md-4 col-lg-3 col-xl-3">
                                    <div class="search-box">
                                        <input type="text" v-model="filters.search" class="form-control search"
                                            placeholder="Search for role or permission or something..."
                                            v-on:keyup="search">
                                        <i class="ri-search-line search-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template #default>
                            <tr v-for="(role, index) in roles.data" :key="index">
                                <td class="id">{{ (roles.current_page - 1) * roles.per_page + index + 1 }}</td>
                                <td>{{ role.name }}</td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <span v-for="permission in role.permissions" :key="permission"
                                            class="badge bg-primary-subtle text-primary">{{ permission.name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <button class="me-1 btn btn-outline-dark btn-sm" @click="openEditRoleModal(role)">
                                        <i class="bx bx-edit-alt"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" @click="openDeleteRoleModal(role.id)"><i
                                            class="bx bx-trash"></i></button>
                                </td>
                            </tr>
                        </template>
                    </CommonTable>
                    <div v-if="roles.data.length === 0" class="noresult">
                        <div class="text-center mb-3">
                            <h5 class="mt-2">Sorry! No Result Found</h5>
                            <p class="text-muted mb-0">We've searched more than 200k+ roles We did not find any roles
                                for you search.</p>
                        </div>
                    </div>
                </BCard>

            </BCol>
        </BRow>

        <!-- Create/Edit Role Modal -->
        <BModal centered v-model="showModal" hide-footer title="Create Role" header-class="p-3 bg-light" title-class="fs-14"
            size="lg">
            <form @submit.prevent="store">
                <div class="mb-3">
                    <label for="name">Role <span class="text-danger">*</span></label>
                    <input type="text" v-model="form.name" id="name" class="form-control" placeholder="Enter Role">
                    <div class="text-danger mt-1 small" v-if="form.errors.name">{{ form.errors.name }}</div>
                </div>

                <div class="mb-3">
                    <label for="permission">Permissions <span class="text-danger">*</span></label>
                    <ul class="ps-0 d-flex flex-wrap gap-2">
                        <li class="list-inline" v-for="permission in permissions" :key="permission.id">
                            <input class="form-check-input" type="checkbox" v-model="form.permissions"
                                :value="permission.name" :id="'permission-' + permission.id">
                            <label :for="'permission-' + permission.id" class="form-check-label ms-2">{{ permission.name
                            }}</label>
                        </li>
                    </ul>
                    <div class="text-danger mt-1 small" v-if="form.errors.permissions">{{ form.errors.permissions }}
                    </div>
                </div>

                <div class="float-end">
                    <button type="button" class="btn btn-danger btn-sm me-1" @click="showModal = false">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Submit
                    </button>
                </div>
            </form>
        </BModal>

        <!-- Edit Role Modal -->
        <BModal centered v-model="editRoleModal" hide-footer title="Edit Role" header-class="p-3 bg-light" title-class="fs-14"
            size="lg">
            <form @submit.prevent="updateRole">
                <div class="mb-3">
                    <label for="name">Role <span class="text-danger">*</span></label>
                    <input type="text" v-model="form.name" id="name" class="form-control" placeholder="Enter Role">
                    <div class="text-danger mt-1 small" v-if="form.errors.name">{{ form.errors.name }}</div>
                </div>

                <div class="mb-3">
                    <label for="permission">Permissions <span class="text-danger">*</span></label>
                    <ul class="ps-0 d-flex flex-wrap gap-2">
                        <li class="list-inline" v-for="permission in permissions" :key="permission.id">
                            <input class="form-check-input" type="checkbox" v-model="form.permissions"
                                :value="permission.name" :id="'permission-' + permission.id">
                            <label :for="'permission-' + permission.id" class="form-check-label ms-2">{{ permission.name
                            }}</label>
                        </li>
                    </ul>
                    <div class="text-danger mt-1 small" v-if="form.errors.permissions">{{ form.errors.permissions }}
                    </div>
                </div>

                <div class="float-end">
                    <button type="button" class="btn btn-danger btn-sm me-1"
                        @click="editRoleModal = false">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm" :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing">
                        Submit
                    </button>
                </div>
            </form>
        </BModal>

        <!-- Delete Role Modal -->
        <DeleteModal v-model="deleteRoleModal" item-name="item" @confirm="deleteRoleModal = false" />
    </Layout>
</template>
