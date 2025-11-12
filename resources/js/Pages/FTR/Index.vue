<script setup>
import { ref } from 'vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import Layout from '@/Layouts/main.vue'
import CommonDataTable from '@/Components/CommonDataTable.vue'

import Lottie from '@/Components/widgets/lottie.vue'
import animationData from '@/Components/widgets/msoeawqm.json'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import DeleteModal from '@/Components/DeleteModal.vue'

const props = defineProps({
  ftr_files: {
    type: Object,
    default: () => ({}),
  },
})

const form = useForm({
  id: null,
  ftr_file: '',
})

const showCreateModal = ref(false)
const showDeleteModal = ref(false)

const openCreateModal = () => {
  form.reset()
  form.errors = {}
  form.ftr_file = null
  showCreateModal.value = true
}

const store = () => {
  form.post(route('ftr-files.store'), {
    onSuccess: () => {
      showCreateModal.value = false
      form.reset()
      form.errors = {}
    },
  })
}

const openDeleteModal = (id) => {
  form.id = id
  showDeleteModal.value = true
}

const destroy = () => {
  form.delete(route('ftr-files.destroy', form.id), {
    onSuccess: () => {
      showDeleteModal.value = false
      form.reset()
      form.errors = {}
    },
  })
}

// Columns
const columns = [
  { key: 'id', label: 'ID', sortable: false },
  { key: 'original_name', label: 'File', sortable: false },
  { key: 'rows_parsed', label: 'Rows', sortable: false },
  { key: 'uploaded_by', label: 'Uploaded By', sortable: false },
  { key: 'action', label: 'Action', sortable: false },
]
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

      this.$inertia.get(this.route('ftr-files'), query, { replace: true, preserveState: true })
    },
    goToPage(page) {
      this.$inertia.get(
        this.route('ftr-files'),
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
    <Head title="FTR Files" />

    <BRow>
      <BCol lg="12">
        <BCard no-body>
          <BCardHeader>
            <div class="d-flex align-items-center">
              <h5 class="card-title mb-0 flex-grow-1 fs-14">All FTR Files</h5>
              <div class="flex-shrink-0">
                <div class="d-flex flex-wrap gap-2">
                  <button class="btn btn-outline-primary btn-sm add-btn" @click="openCreateModal">
                    <i class="ri-add-line align-bottom me-1"></i>
                    Create
                  </button>
                </div>
              </div>
            </div>
          </BCardHeader>
          <CommonDataTable :columns="columns" :pagination="ftr_files" @update:page="goToPage" table-id="ftr-files" :persist-column-state="true">
            <template #default="{ isColumnVisible }">
              <tr v-for="(ftr, index) in ftr_files.data" :key="index">
                <td v-if="isColumnVisible('id')">{{ (ftr_files.current_page - 1) * ftr_files.per_page + index + 1 }}</td>
                <td v-if="isColumnVisible('original_name')">{{ ftr.original_name }}</td>
                <td v-if="isColumnVisible('rows_parsed')">{{ ftr.rows_parsed }}</td>
                <td v-if="isColumnVisible('uploaded_by')">{{ ftr.uploader?.name }}</td>
                <td v-if="isColumnVisible('action')">
                  <Link :href="route('ftr-files.show', ftr.id)" class="me-2 btn btn-outline-primary btn-sm"><i class="bx bx-show align-middle"></i></Link>
                  <button class="me-2 btn btn-outline-danger btn-sm" @click="openDeleteModal(ftr.id)"><i class="bx bx-trash align-middle"></i></button>
                </td>
              </tr>
            </template>
          </CommonDataTable>
          <div v-if="ftr_files.data.length === 0" class="noresult">
            <div class="text-center">
              <lottie class="avatar-xl" colors="primary:#121331,secondary:#08a88a" :options="{ animationData: animationData }" :height="75" :width="75" />
              <h5 class="mt-2">Sorry! No Records Found</h5>
            </div>
          </div>
        </BCard>
      </BCol>
    </BRow>

    <BModal centered v-model="showCreateModal" size="md" title="Upload FTR File" hide-footer header-class="bg-light p-3" title-class="fs-14">
      <form @submit.prevent="store()" enctype="multipart/form-data">
        <div class="mb-3">
          <InputLabel for="ftr_file" value="FTR File" />
          <input id="ftr_file" type="file" class="form-control" @input="form.ftr_file = $event.target.files[0]" :class="{ 'is-invalid': form.errors.ftr_file }" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel' }" required />
          <InputError :message="form.errors.ftr_file" class="mt-2" />
        </div>

        <div class="float-end">
          <button type="button" class="btn btn-sm btn-danger me-1" @click="editMilestoneModal = false">Cancel</button>
          <button type="submit" class="btn btn-sm btn-success" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Save</button>
        </div>
      </form>
    </BModal>

    <DeleteModal v-model="showDeleteModal" item-name="ftr" @confirm="destroy" />
  </Layout>
</template>
