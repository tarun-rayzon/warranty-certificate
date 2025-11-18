<script setup>
import { ref, defineProps, watch } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import Layout from '@/Layouts/main.vue'
import PageHeader from '@/Components/page-header.vue'
import Widget from './widgets.vue'
import CommonTable from '@/Components/CommonDataTable.vue'
import DeleteModal from '@/Components/DeleteModal.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'

const props = defineProps({
  permissions: {
    type: Object,
    default: () => [],
  },
  total_permissions: {
    type: Number,
    default: 0,
  },
})

const showModal = ref(false)
const deletePermissionModal = ref(false)
const editPermissionModal = ref(false)
const productBeingDeleted = ref(null)

const form = useForm({
  name: '',
  guard_name: '',
})

const openCreatePermissionModal = () => {
  form.reset()
  form.errors = {}
  showModal.value = true
}

const store = () => {
  form.post(route('permission.store'), {
    preserveScroll: true,
    onSuccess: () => {
      showModal.value = false
      form.reset()
    },
  })
}

const openEditPermissionModal = (permission) => {
  form.reset()
  form.id = permission.id
  form.name = permission.name
  form.guard_name = permission.guard_name
  editPermissionModal.value = true
}

const updatePermission = () => {
  form
    .transform((data) => ({
      ...data,
    }))
    .patch(route('permission.update', form.id), {
      preserveScroll: true,
      onSuccess: () => {
        editPermissionModal.value = false
        form.reset()
      },
    })
}

const openDeletePermissionModal = (PermissionId) => {
  deletePermissionModal.value = true
  productBeingDeleted.value = PermissionId
}

const deletePermission = () => {
  form.delete(route('permission.destroy', productBeingDeleted.value), {
    preserveScroll: true,
    onFinish: () => {
      deletePermissionModal.value = false
    },
  })
}

const columns = [
  { key: 'id', label: 'ID', sortable: false, width: '80px' },
  { key: 'name', label: 'Name', sortable: false, width: '250px' },
  { key: 'guard_name', label: 'Guard', sortable: false },
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
      this.filters = { ...this.filters, ...this.$page.props.filters }
    }
  },
  methods: {
    search() {
      const query = Object.fromEntries(
        Object.entries(this.filters).filter(([_, value]) => {
          return Array.isArray(value) ? value.length > 0 : value
        })
      )

      this.$inertia.get(this.route('permission.index'), query, { replace: true, preserveState: true })
    },
    goToPage(page) {
      this.$inertia.get(
        this.route('permission.index'),
        {
          ...this.filters,
          page,
        },
        {
          replace: true,
          preserveState: true,
          preserveScroll: true,
        }
      )
    },
  },
}
</script>

<template>
  <Layout>
    <Head title="Permission" />
    <PageHeader title="Master" pageTitle="Permissions" />

    <Widget :total_permissions="total_permissions" />

    <BRow>
      <BCol lg="12">
        <BCard no-body class="card" id="permissionsList">
          <BCardHeader class="border-1">
            <div class="d-flex align-items-center">
              <h5 class="card-title mb-0 flex-grow-1">All Permissions</h5>
              <div class="flex-shrink-0">
                <div class="d-flex flex-wrap gap-2">
                  <button class="btn btn-outline-primary btn-sm add-btn" @click="openCreatePermissionModal">
                    <i class="ri-add-line align-bottom me-1"></i>
                    Create
                  </button>
                </div>
              </div>
            </div>
          </BCardHeader>
          <CommonTable :columns="columns" :pagination="permissions" @update:page="goToPage" v-model:itemsPerPage="itemsPerPage" :showColumnToggle="false">
            <template #filters>
              <div class="row g-3 flex-wrap align-items-center">
                <div class="col-md-4 col-lg-3 col-xl-3">
                  <div class="search-box">
                    <input type="text" v-model="filters.search" class="form-control search" placeholder="Search for permission or permission or something..." v-on:keyup="search" />
                    <i class="ri-search-line search-icon"></i>
                  </div>
                </div>
              </div>
            </template>
            <template #default>
              <tr v-for="(permission, index) in permissions.data" :key="index">
                <td class="id">{{ (permissions.current_page - 1) * permissions.per_page + index + 1 }}</td>
                <td>{{ permission.name }}</td>
                <td>{{ permission.guard_name }}</td>
                <td>
                  <button class="me-1 btn btn-outline-dark btn-sm" @click="openEditPermissionModal(permission)">
                    <i class="bx bx-edit-alt"></i>
                  </button>
                  <button class="btn btn-outline-danger btn-sm" @click="openDeletePermissionModal(permission.id)"><i class="bx bx-trash"></i></button>
                </td>
              </tr>
            </template>
          </CommonTable>
          <div v-if="permissions.data.length === 0" class="noresult">
            <div class="text-center mb-3">
              <h5 class="mt-2">Sorry! No Result Found</h5>
              <p class="text-muted mb-0">We've searched more than 200k+ permissions We did not find any permissions for you search.</p>
            </div>
          </div>
        </BCard>
      </BCol>
    </BRow>

    <!-- Create/Edit Permission Modal -->
    <BModal centered v-model="showModal" hide-footer title="Create Permission" header-class="p-3 bg-light" title-class="fs-14">
      <form @submit.prevent="store">
        <div class="mb-3">
          <InputLabel for="name" value="Name" />
          <TextInput id="name" type="text" v-model="form.name" :class="{ 'is-invalid': form.errors.name }" placeholder="Enter Permission Name" />
          <InputError :message="form.errors.name" />
        </div>

        <div class="mb-3">
          <InputLabel for="guard_name" value="Guard Name" />
          <TextInput id="guard_name" type="text" v-model="form.guard_name" :class="{ 'is-invalid': form.errors.guard_name }" placeholder="Enter Guard Name" />
          <InputError :message="form.errors.guard_name" />
        </div>

        <div class="float-end">
          <button type="button" class="btn btn-danger btn-sm me-1" @click="showModal = false">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Submit</button>
        </div>
      </form>
    </BModal>

    <!-- Edit Permission Modal -->
    <BModal centered v-model="editPermissionModal" hide-footer title="Edit Permission" header-class="p-3 bg-light" title-class="fs-14">
      <form @submit.prevent="updatePermission">
        <div class="mb-3">
          <InputLabel for="name" value="Name" />
          <TextInput id="name" type="text" v-model="form.name" :class="{ 'is-invalid': form.errors.name }" placeholder="Enter Permission Name" />
          <InputError :message="form.errors.name" />
        </div>

        <div class="mb-3">
          <InputLabel for="guard_name" value="Guard Name" />
          <TextInput id="guard_name" type="text" v-model="form.guard_name" :class="{ 'is-invalid': form.errors.guard_name }" placeholder="Enter Guard Name" />
          <InputError :message="form.errors.guard_name" />
        </div>

        <div class="float-end">
          <button type="button" class="btn btn-danger btn-sm me-1" @click="editPermissionModal = false">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Submit</button>
        </div>
      </form>
    </BModal>

    <!-- Delete Permission Modal -->
    <DeleteModal v-model="deletePermissionModal" item-name="item" @confirm="deletePermissionModal = false" />
  </Layout>
</template>
