<script setup>
import { ref, computed, watch } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import Layout from '@/Layouts/main.vue'
import PageHeader from '@/Components/page-header.vue'

import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'

import Multiselect from '@vueform/multiselect'
import '@vueform/multiselect/themes/default.css'

import CommonTable from '@/Components/CommonDataTable.vue'

import Lottie from '@/Components/widgets/lottie.vue'
import animationData from '@/Components/widgets/msoeawqm.json'
import DeleteModal from '@/Components/DeleteModal.vue'
import Card from '@/Components/Card.vue'

const props = defineProps({
  users: {
    type: Object,
    default: () => ({ data: [], per_page: 10, current_page: 1 }),
  },
  roles: {
    type: Object,
    default: () => [],
  },
  data: {
    type: Object,
    default: () => ({}),
  },
})

// Convert roles into the required format
const formattedRoles = computed(() => {
    return props.roles.map((role) => ({
        label: role.name,
        value: role.name,
    }))
})

const showCreateModal = ref(false)
const showEditModal = ref(false)
const showDeleteModal = ref(false)
const currentUserId = ref(null)
const showResetPassModal = ref(false)

const form = useForm({
  id: null,
  name: '',
  email: '',
  mobile: '',
  role: [],
  password: '',
  password_confirmation: '',
})

const openCreateModal = () => {
  form.reset()
  form.errors = {}
  showCreateModal.value = true
}

const openEditModal = (user) => {
  form.reset()
  form.errors = {}
    Object.assign(form, user)
  form.role = user.roles.map((role) => role.name)
  showEditModal.value = true
}

// Create
const store = () => {
  form.post(route('user.store'), {
    preserveScroll: true,
    onSuccess: () => {
      showCreateModal.value = false
      form.reset()
    },
  })
}

// Update
const update = () => {
  form.put(route('user.update', form.id), {
    preserveScroll: true,
    onSuccess: () => {
      showEditModal.value = false
      form.reset()
    },
  })
}

// Delete
const destroy = () => {
  form.delete(route('user.destroy', currentUserId.value), {
    preserveScroll: true,
    onSuccess: () => {
      showDeleteModal.value = false
      currentUserId.value = null
    },
  })
}

// Reset Password
const openResetPassModal = (userId) => {
  form.reset()
  currentUserId.value = userId
  showResetPassModal.value = true
}

const resetPass = () => {
  form.post(route('user.update-password', currentUserId.value), {
    preserveScroll: true,
    onSuccess: () => {
      showResetPassModal.value = false
      currentUserId.value = null
      form.reset()
    },
  })
}

// Clear session
const clearSession = (userId) => {
  form.post(route('user.clear-session', userId), {
    preserveScroll: true,
  })
}

// Table
const usersdata = computed(() => props.users)

const columns = [
  { key: 'sr_no', label: 'Sr No.', width: '80px', sortable: false },
  { key: 'name', label: 'Name', sortable: true },
  { key: 'email', label: 'Email', sortable: true },
  { key: 'mobile', label: 'Mobile', sortable: true },
  { key: 'role', label: 'Role', sortable: false },
  {
    key: 'actions',
    label: 'Action',
    sortable: false,
    permission: ['user.edit', 'user.delete'],
  },
]

const sortKey = ref(props.sortKey)
const sortOrder = ref(props.sortOrder)
</script>

<script>
export default {
  data() {
    return {
      togglePassword: false,
      togglePassword_conf: false,
      filters: {
        search: '',
      },
      appliedFilters: {},
    }
  },
  created() {
    if (this.$page.props.filters) {
      const merged = { ...this.filters, ...this.$page.props.filters }

      this.filters = merged
    }
  },
  computed: {
    hasActiveFilters() {
      return Object.keys(this.appliedFilters).length > 0
    },
  },
  methods: {
    applyFilters() {
      const activeFilters = this.getActiveFilters()
      this.appliedFilters = { ...activeFilters }

      this.$inertia.get(this.route('user.index'), activeFilters, {
        replace: true,
        preserveState: true,
        preserveScroll: true,
      })
    },
    resetFilters() {
      this.filters = {
        search: '',
      }
      this.appliedFilters = {}
      this.applyFilters()
    },
    getActiveFilters() {
      return Object.fromEntries(
        Object.entries(this.filters).filter(([_, value]) => {
          return Array.isArray(value) ? value.length > 0 : value !== '' && value !== false
        })
      )
    },
    goToPage(page) {
      const activeFilters = this.getActiveFilters()

      this.$inertia.get(
        this.route('user.index'),
        {
          ...activeFilters,
          page,
        },
        {
          replace: true,
          preserveState: true,
          preserveScroll: true,
        }
      )
    },
    onSort({ key: sortKey, order: sortOrder }) {
      const activeFilters = this.getActiveFilters()

      this.$inertia.get(
        this.route('user.index'),
        {
          ...activeFilters,
          sort: sortKey,
          order: sortOrder,
        },
        {
          replace: true,
          preserveState: true,
          preserveScroll: true,
        }
      )
    },
    clearFilter(field) {
      this.filters[field] = field === 'active' || field === 'inactive' ? false : ''
      this.applyFilters()
    },
  },
}
</script>

<template>
  <Layout>
    <Head title="Users" />

    <PageHeader title="Rayzon" pageTitle="Users" />

    <div class="row">
        <div class="col-lg-3">
            <Card title="Total Users" :total="data.users[0].total" icon="bx bx-user" color="primary" />
        </div>
    </div>

    <BCard no-body id="usersList">
      <BCardHeader class="border-1">
        <div class="d-flex align-items-center">
          <h5 class="card-title mb-0 flex-grow-1">All Users</h5>
          <div class="flex-shrink-0">
            <div class="d-flex flex-wrap gap-2">
              <button v-if="$page.props.user.permissions.includes('user.create')" class="btn btn-outline-primary btn-sm add-btn" @click="openCreateModal">
                <i class="ri-add-line align-bottom"></i>
                Create
              </button>
            </div>
          </div>
        </div>
      </BCardHeader>
      <CommonTable :columns="columns" :pagination="usersdata" :sort-key="sortKey" :sort-order="sortOrder" @sort="onSort" @update:page="goToPage" table-id="user-table" :persist-column-state="true">
        <template #filters>
          <div class="row g-3 flex-wrap align-items-center">
            <div class="col-md-4 col-lg-3">
              <div class="search-box">
                <input type="text" v-model="filters.search" class="form-control search" placeholder="Search for user or something..." />
                <i class="ri-search-line search-icon"></i>
              </div>
            </div>

            <div class="mt-3 text-end">
              <button class="btn btn-outline-primary btn-sm me-1" @click="applyFilters">
                <i class="ri-filter-2-line align-bottom"></i>
                Apply
              </button>
              <button class="btn btn-outline-primary btn-sm" @click="resetFilters">
                <i class="ri-refresh-line align-bottom"></i>
                Reset
              </button>
            </div>
          </div>
        </template>
        <template #default="{ isColumnVisible }">
          <tr v-for="(user, index) in usersdata.data" :key="user.id">
            <td v-if="isColumnVisible('sr_no')">{{ (usersdata.current_page - 1) * usersdata.per_page + index + 1 }}</td>
            <td v-if="isColumnVisible('name')">{{ user.name }}</td>
            <td v-if="isColumnVisible('email')">{{ user.email }}</td>
            <td v-if="isColumnVisible('mobile')">{{ user.mobile }}</td>
            <td v-if="isColumnVisible('role')">
              <div class="d-flex gap-1 flex-wrap">
                <span class="badge bg-primary-subtle text-primary" v-for="role in user.roles" :key="role.id">{{ role.name }}</span>
              </div>
            </td>
            <td v-if="isColumnVisible('actions') && ($page.props.user.permissions.includes('user.edit') || $page.props.user.permissions.includes('user.delete'))">
              <BButton v-if="$page.props.user.permissions.includes('user.edit')" class="btn btn-outline-dark me-1" size="sm" @click="openEditModal(user)">
                <i class="bx bx-edit-alt"></i>
              </BButton>

              <button v-if="$page.props.user.permissions.includes('user.edit')" class="btn btn-sm btn-outline-danger me-1" @click="openResetPassModal(user.id)">
                <i class="bx bx-key"></i>
              </button>

              <button class="btn btn-sm btn-outline-info" @click="clearSession(user.id)">
                <i class="bx bx-log-out"></i>
              </button>
            </td>
          </tr>
        </template>
      </CommonTable>
      <div v-if="usersdata.data.length === 0" class="noresult">
        <div class="text-center">
          <lottie class="avatar-xl" colors="primary:#121331,secondary:#08a88a" :options="{ animationData: animationData }" :height="75" :width="75" />
          <h5 class="mt-2">Sorry! No Records Found</h5>
        </div>
      </div>
    </BCard>

    <!-- create users modal -->
    <BModal centered v-model="showCreateModal" hide-footer title="Create User" header-class="p-3 bg-light" size="lg" title-class="fs-14">
      <form @submit.prevent="store()">
        <div class="row">
          <div class="col-lg-6">
            <div class="mb-3">
              <InputLabel for="name" value="Name" />
              <TextInput id="name" v-model="form.name" type="text" required autofocus autocomplete="name" placeholder="Enter your name" :class="{ 'is-invalid': form.errors.name }" />
              <InputError :message="form.errors.name" />
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3">
              <InputLabel for="email" value="Email" />
              <TextInput id="email" v-model="form.email" type="email" required autocomplete="email" :class="{ 'is-invalid': form.errors.email }" placeholder="Enter your email" />
              <InputError :message="form.errors.email" />
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3">
              <InputLabel for="mobile" value="Mobile" />
              <TextInput id="mobile" v-model="form.mobile" type="text" required autofocus autocomplete="mobile" placeholder="Enter your mobile" :class="{ 'is-invalid': form.errors.mobile }" />
              <InputError :message="form.errors.mobile" />
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3">
              <InputLabel for="role" value="Role" />
              <Multiselect v-model="form.role" :options="formattedRoles" mode="tags" :searchable="true" placeholder="Select Role" :class="{ 'is-invalid': form.errors.role }" />
              <InputError :message="form.errors.role" />
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3">
              <InputLabel for="password" value="Password" />
              <div class="position-relative auth-pass-inputgroup">
                <input :type="togglePassword ? 'text' : 'password'" class="form-control pe-5 password-input" placeholder="Enter password" id="password" required v-model="form.password" :class="{ 'is-invalid': form.errors.password }" autocomplete="new-password" />
                <BButton variant="link" class="position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" @click="togglePassword = !togglePassword"><i class="ri-eye-fill align-middle"></i></BButton>
                <InputError :message="form.errors.password" />
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3">
              <InputLabel for="password_confirmation" value="Confirm Password" />
              <div class="position-relative auth-pass-inputgroup">
                <input :type="togglePassword_conf ? 'text' : 'password'" class="form-control pe-5 password-input" placeholder="Enter password" id="password_confirmation" required v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.password_confirmation }" autocomplete="new-password" />
                <BButton variant="link" class="position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" @click="togglePassword_conf = !togglePassword_conf"><i class="ri-eye-fill align-middle"></i></BButton>
                <InputError :message="form.errors.password_confirmation" />
              </div>
            </div>
          </div>
        </div>

        <div class="float-end">
          <button type="button" class="btn btn-danger btn-sm me-1" @click="showCreateModal = false">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Submit</button>
        </div>
      </form>
    </BModal>

    <!-- update user modal -->
    <BModal centered v-model="showEditModal" hide-footer title="Edit User" header-class="p-3 bg-light" title-class="fs-14" size="lg">
      <form @submit.prevent="update()">
        <div class="row">

          <div class="col-lg-6">
            <div class="mb-3">
              <InputLabel for="edit-name" value="Name" />
              <TextInput id="edit-name" v-model="form.name" type="text" required autofocus autocomplete="name" placeholder="Enter your name" :class="{ 'is-invalid': form.errors.name }" />
              <InputError :message="form.errors.name" />
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3">
              <InputLabel for="edit-email" value="Email" />
              <TextInput id="edit-email" v-model="form.email" type="email" required autocomplete="email" :class="{ 'is-invalid': form.errors.email }" placeholder="Enter your email" />
              <InputError :message="form.errors.email" />
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3">
              <InputLabel for="edit-mobile" value="Mobile" />
              <TextInput id="edit-mobile" v-model="form.mobile" type="text" required autofocus autocomplete="mobile" placeholder="Enter your mobile" :class="{ 'is-invalid': form.errors.mobile }" />
              <InputError :message="form.errors.mobile" />
            </div>
          </div>

          <div class="col-lg-6">
            <div class="mb-3">
              <InputLabel for="role" value="Role" />
              <Multiselect v-model="form.role" :options="formattedRoles" mode="tags" :searchable="true" placeholder="Select Role" :class="{ 'is-invalid': form.errors.role }" />
              <InputError :message="form.errors.role" />
            </div>
          </div>
        </div>

        <div class="float-end">
          <button type="button" class="btn btn-danger btn-sm me-1" @click="showEditModal = false">Cancel</button>
          <button type="submit" class="btn btn-success btn-sm" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Submit</button>
        </div>
      </form>
    </BModal>

    <!-- Delete User Modal -->
    <DeleteModal v-if="$page.props.user.permissions.includes('user.delete')" v-model="showDeleteModal" item-name="user" @confirm="destroy" />

    <BModal v-if="$page.props.user.permissions.includes('user.edit')" v-model="showResetPassModal" title="Reset Password" title-class="fs-14" hide-footer header-class="p-3 bg-light" centered>
      <form @submit.prevent="resetPass">
        <div class="row">
          <div class="col-lg-12">
            <div class="mb-3">
              <InputLabel for="reset-password" value="Password" />
              <div class="position-relative auth-pass-inputgroup">
                <input :type="togglePassword ? 'text' : 'password'" class="form-control pe-5 password-input" placeholder="Enter password" id="reset-password" required v-model="form.password" :class="{ 'is-invalid': form.errors.password }" autocomplete="new-password" />
                <BButton variant="link" class="position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" @click="togglePassword = !togglePassword"><i class="ri-eye-fill align-middle"></i></BButton>
                <InputError :message="form.errors.password" />
              </div>
            </div>
          </div>

          <div class="col-lg-12">
            <div class="mb-3">
              <InputLabel for="reset_password_confirmation" value="Confirm Password" />
              <div class="position-relative auth-pass-inputgroup">
                <input :type="togglePassword_conf ? 'text' : 'password'" class="form-control pe-5 password-input" placeholder="Enter password" id="reset_password_confirmation" required v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.password_confirmation }" autocomplete="new-password" />
                <BButton variant="link" class="position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" @click="togglePassword_conf = !togglePassword_conf"><i class="ri-eye-fill align-middle"></i></BButton>
                <InputError :message="form.errors.password_confirmation" />
              </div>
            </div>
          </div>

          <div class="text-end">
            <button type="button" class="btn btn-danger btn-sm me-1" @click="showResetPassModal = false">Cancel</button>
            <button type="submit" class="btn btn-success btn-sm" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Reset Password</button>
          </div>
        </div>
      </form>
    </BModal>
  </Layout>
</template>
