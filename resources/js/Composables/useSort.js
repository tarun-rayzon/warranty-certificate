// composables/useSort.js
import { ref } from 'vue';

export function useSort() {
    const sortKey = ref(''); // the key of the current column being sorted
    const sortOrder = ref('asc'); // the order of sorting: 'asc' or 'desc'

    const sortBy = (data, column) => {
        if (sortKey.value === column) {
            // If already sorting by this column, reverse the order
            sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
        } else {
            // Otherwise, sort by this column in ascending order
            sortKey.value = column;
            sortOrder.value = 'asc';
        }

        // Sort the data
        data.sort((a, b) => {
            let aValue = getNestedValue(a, column.split('.'));
            let bValue = getNestedValue(b, column.split('.'));

            let result = 0;
            if (aValue > bValue) result = 1;
            if (aValue < bValue) result = -1;
            return sortOrder.value === 'asc' ? result : -result;
        });
    };

    const getNestedValue = (object, keys) => {
        return keys.reduce((obj, key) => (obj && obj[key] !== 'undefined') ? obj[key] : null, object);
    };

    const sortIcon = (column) => {
        if (sortKey.value !== column) return 'bx bx-sort';
        return sortOrder.value === 'asc' ? 'bx bx-sort-up' : 'bx bx-sort-down';
    };

    return { sortKey, sortOrder, sortBy, sortIcon };
}
