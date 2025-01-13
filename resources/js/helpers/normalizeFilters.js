/**
 * Normalizes filters by removing empty values
 * @param {{  }} filters Object containing filters. Example: { 'category-id': 1, 'price': 100 }
 * @param {Function} callback Callback function to handle specific filters.
 * @returns Object containing only filters that are not empty.
 */
function normalizedFilters(filters, callback = (() => { })) {
    callback(filters)

    const normalizedFilters = {}

    for (const key in filters) {
        if (filters[key]) {
            normalizedFilters[key] = filters[key]
        }
    }

    return normalizedFilters
}

export default normalizedFilters;
