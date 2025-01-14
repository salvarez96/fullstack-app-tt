/**
 * Get the current page from the URL param 'page'. If there's no 'page' param, returns 1.
 * @returns {number}
 */
function getCurrentPage() {
    const locationSearch = location.search.match(/(?:page=)\d+/)
    const currentPage = locationSearch
        ? locationSearch[0].split('=')[1]
        : 1

    return currentPage
}

export default getCurrentPage
