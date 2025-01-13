/**
 * Sets a pagination param to the URL without reloading the page.
 * @param {number} page Page number
 * @example if page = 1, sets '?page=1' into the URL.
 */
function handleUrlPagination(page) {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('page', page);
    window.history.pushState({}, '', `?page=${page}`);
}

export default handleUrlPagination
