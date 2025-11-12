<template>
  <div class="common-table-container common-table-component">
    <!-- Filter Slot -->
    <div class="py-3 px-4">
      <slot name="filters"></slot>

      <!-- Column Visibility Toggle -->
      <div class="row mt-1" v-if="props.showColumnToggle && availableColumns.length">
        <div class="col-12">
          <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
            <span class="text-muted me-2">Show/Hide Columns :</span>
            <div class="dropdown">
              <button class="btn btn-outline-primary btn-sm dropdown-toggle" type="button" id="columnToggle"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-eye-line me-1"></i>
                Columns Visibility ({{ visibleColumnsCount }} / {{ totalColumnsCount }})
              </button>
              <ul class="dropdown-menu column-toggle-menu" aria-labelledby="columnToggle">
                <li v-for="column in availableColumns" :key="column.key" class="dropdown-item-text">
                  <div class="form-check">
                    <input class="form-check-input ms-0" type="checkbox" :id="`col-${column.key}`"
                      v-model="columnVisibility[column.key]" @change="updateColumnVisibility">
                    <label class="form-check-label ms-2" :for="`col-${column.key}`">
                      {{ column.label }}
                    </label>
                  </div>
                </li>
                <li>
                  <hr class="dropdown-divider" />
                </li>
                <li>
                  <button class="dropdown-item" @click="showAllColumns">
                    <i class="ri-eye-line me-1"></i> Show All
                  </button>
                </li>
                <li v-if="hasSavedColumnData">
                  <button class="dropdown-item text-danger" @click="clearSavedData">
                    <i class="ri-delete-bin-line me-1"></i> Clear Saved Settings
                  </button>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
      <div class="table-scroll-container">
        <table class="table table-hover" ref="table">
          <thead class="table-header" :class="{ scrolled: isScrolled }">
            <tr>
              <th v-for="column in visibleColumns" :key="column.key" :style="{
                minWidth: column.width || '150px',
                cursor: column.sortable !== false ? 'pointer' : 'default',
                whiteSpace: 'nowrap'
              }" @click="column.sortable !== false && handleSort(column)" :title="column.title ?? column.label">
                <template v-if="column.isHeaderSlot">
                  <slot :name="`header-${column.key}`"></slot>
                </template>

                <template v-else-if="column.sortable !== false">
                  <span class="sortable-header d-inline-flex align-items-center gap-1">
                    {{ column.label }}
                    <i :class="sortIcon(column.key)" style="font-weight: lighter;"></i>
                  </span>
                </template>

                <template v-else>
                  {{ column.label }}
                </template>
              </th>
            </tr>
          </thead>
          <tbody class="list form-check-all">
            <slot :isColumnVisible="isColumnVisible"></slot>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Pagination -->
    <div v-if="pagination.total > 0" class="row d-flex align-items-center p-4">
      <div class="col-md-6 text-muted">
        Showing {{ pagination.from }} to {{ pagination.to }} of {{ pagination.total }}
      </div>
      <div class="col-md-6">
        <div class="modern-pagination d-flex justify-content-end align-items-center py-1">
          <button class="pagination-btn pagination-nav" @click="changePage(1)"
            :disabled="pagination.current_page === 1">Previous</button>
          <button class="pagination-btn pagination-nav" @click="changePage(pagination.current_page - 1)"
            :disabled="pagination.current_page === 1">
            <i class="ri-arrow-left-s-line"></i>
          </button>

          <div class="pagination-numbers">
            <button v-for="(page, index) in visiblePages" :key="index" class="pagination-btn pagination-number"
              :class="{ active: page === pagination.current_page }" @click="page !== '...' && changePage(page)"
              :disabled="page === '...'">
              {{ page }}
            </button>
          </div>

          <button class="pagination-btn pagination-nav" @click="changePage(pagination.current_page + 1)"
            :disabled="pagination.current_page === totalPages">
            <i class="ri-arrow-right-s-line"></i>
          </button>
          <button class="pagination-btn pagination-nav" @click="changePage(totalPages)"
            :disabled="pagination.current_page === totalPages">Next</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, nextTick } from 'vue'
import { usePage } from '@inertiajs/vue3'

const props = defineProps({
  columns: Array,
  pagination: Object,
  sortKey: String,
  sortOrder: String,
  itemsPerPage: Number,
  filters: Object,
  defaultHiddenColumns: Array,
  essentialColumns: Array,
  persistColumnState: Boolean,
  tableId: {
    type: String,
    default: 'default-table'
  },
  showColumnToggle: {
    type: Boolean,
    default: true
  }
})

const emits = defineEmits(['sort', 'update:page', 'columns:changed'])

const table = ref(null)
const pageProps = usePage().props
const columnVisibility = ref({})
const isScrolled = ref(false)
const localSortKey = ref(props.sortKey || '')
const localSortOrder = ref(props.sortOrder || 'desc')

// Available columns based on permissions
const availableColumns = computed(() =>
  props.columns.filter(column => {
    if (!column.permission) return true
    return column.permission.some(p => pageProps.user.permissions.includes(p))
  })
)

// Visible columns based on columnVisibility
const visibleColumns = computed(() =>
  availableColumns.value.filter(col => columnVisibility.value[col.key] !== false)
)

const visibleColumnsCount = computed(() => visibleColumns.value.length)
const totalColumnsCount = computed(() => availableColumns.value.length)

const initializeColumnVisibility = () => {
  let visibility = {}
  let hasSaved = false

  if (props.persistColumnState) {
    const saved = localStorage.getItem(`table-columns-${props.tableId}`)
    if (saved) {
      try {
        const parsed = JSON.parse(saved)
        const currentKeys = availableColumns.value.map(c => c.key)
        if (Object.keys(parsed).some(k => currentKeys.includes(k))) {
          visibility = { ...parsed }
          hasSaved = true
        }
      } catch (e) {
        console.warn('Error parsing saved visibility state')
      }
    }
  }

  availableColumns.value.forEach(col => {
    if (!(col.key in visibility)) {
      visibility[col.key] = true
    }
  })

  columnVisibility.value = visibility
}

const updateColumnVisibility = () => {
  if (props.persistColumnState) {
    localStorage.setItem(`table-columns-${props.tableId}`, JSON.stringify(columnVisibility.value))
  }
  emits('columns:changed', {
    visible: visibleColumns.value,
    hidden: availableColumns.value.filter(col => !columnVisibility.value[col.key])
  })
}

const showAllColumns = () => {
  availableColumns.value.forEach(col => {
    columnVisibility.value[col.key] = true
  })
  updateColumnVisibility()
}

const clearSavedData = () => {
  if (props.persistColumnState) {
    localStorage.removeItem(`table-columns-${props.tableId}`)
  }
  showAllColumns()
}

const hasSavedColumnData = computed(() => {
  if (!props.persistColumnState) return false
  return !!localStorage.getItem(`table-columns-${props.tableId}`)
})

const sortIcon = (key) => {
  if (localSortKey.value !== key) return 'ri-arrow-up-down-line'
  return localSortOrder.value === 'asc' ? 'ri-arrow-down-s-fill' : 'ri-arrow-up-s-fill'
}

const handleSort = (column) => {
  if (!column || column.sortable === false) return
  if (localSortKey.value === column.key) {
    localSortOrder.value = localSortOrder.value === 'asc' ? 'desc' : 'asc'
  } else {
    localSortKey.value = column.key
    localSortOrder.value = 'asc'
  }
  emits('sort', {
    key: localSortKey.value,
    order: localSortOrder.value
  })
}

const totalPages = computed(() => Math.ceil(props.pagination.total / props.pagination.per_page))

const visiblePages = computed(() => {
  const total = totalPages.value
  const current = props.pagination.current_page
  const pages = []

  if (total <= 7) {
    for (let i = 1; i <= total; i++) pages.push(i)
  } else {
    pages.push(1)
    if (current > 4) pages.push('...')
    const start = Math.max(2, current - 2)
    const end = Math.min(total - 1, current + 2)
    for (let i = start; i <= end; i++) pages.push(i)
    if (current < total - 3) pages.push('...')
    pages.push(total)
  }
  return pages
})

const changePage = (page) => {
  if (page < 1 || page > totalPages.value) return
  emits('update:page', page)
}

const handleScroll = (e) => {
  isScrolled.value = e.target.scrollTop > 0
}

// Helper method to check visibility inside slot
const isColumnVisible = (key) => columnVisibility.value[key] !== false

onMounted(() => {
  const container = document.querySelector('.table-scroll-container')
  if (container) container.addEventListener('scroll', handleScroll)

  initializeColumnVisibility()
  nextTick(() => {
    emits('columns:changed', {
      visible: visibleColumns.value,
      hidden: availableColumns.value.filter(col => !columnVisibility.value[col.key])
    })
  })
})

// Optional expose
defineExpose({
  table,
  visibleColumns,
  columnVisibility,
  isColumnVisible,
  showAllColumns,
  clearSavedData
})
</script>
<style scoped>
.pagination-btn[disabled] {
  cursor: default;
  background-color: transparent;
  border: none;
  color: #6c757d;
  background-color: #f5f5f5;
}

.column-toggle-menu {
  min-width: 200px;
  max-height: 300px;
  overflow-y: auto;
}

.column-toggle-menu .form-check {
  padding: 0.25rem 0;
  margin: 0;
}

.column-toggle-menu .form-check-label {
  cursor: pointer;
  user-select: none;
}

.column-toggle-menu .dropdown-item-text {
  padding: 0.25rem 1rem;
}

.column-toggle-menu .dropdown-item-text:hover {
  background-color: var(--bs-gray-100);
}
</style>
