<template>
    <nav class="navigation-container" aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <button class="page-link" @click="handlePagination('previous')" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </button>
            </li>
            <li class="page-item" v-for="link in meta?.links" :key="link.label">
                <button class="page-link" v-if="Number(link.label)" @click="handlePagination(link.label)">{{ link.label }}</button>
            </li>
            <li class="page-item">
                <button class="page-link" @click="handlePagination('next')" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </button>
            </li>
        </ul>
    </nav>
</template>

<script setup>
import { onMounted, onUnmounted, onBeforeMount, ref } from 'vue'
import { useStore } from 'vuex'
import getCurrentPage from '@helpers/getCurrentPage'
import handleUrlPagination from '@helpers/handleUrlPagination'

const props = defineProps({
    links: Array,
    meta: Array,
    storeAction: String
})
const store = useStore()
const currentPage = ref(1)

onBeforeMount(() => {
    currentPage.value = getCurrentPage();
    store.dispatch(props.storeAction, {'page': currentPage.value});
});


function handlePagination(pageToGo, isPopState = false) {
    // calculate previous and next page depending on the content's available navigation links
    if (pageToGo === 'previous' && props.links?.prev) {
        pageToGo = props.meta.current_page - 1
    } else if (pageToGo === 'next' && props.links?.next) {
        pageToGo = props.meta.current_page + 1
    }

    // if the navigation is done through the pagination buttons, push the new page
    // to the browser's history as a param and then load the content for that page
    if (Number(pageToGo) && !isPopState) {
        handleUrlPagination(pageToGo)

        store.dispatch(props.storeAction, {'page': pageToGo});
    }

    // if navigation is done through the browser's back and forward buttons,
    // set the current page to the one in the URL and then load the content for that page
    if (isPopState) {
        currentPage.value = getCurrentPage();
        store.dispatch(props.storeAction, {'page': currentPage.value});
    }
}

onMounted(() => {
    // if user navigates through the browser's back and forward buttons, handle the pagination
    window.addEventListener('popstate', () => handlePagination(1, true))
})

onUnmounted(() => {
    window.removeEventListener('popstate', () => handlePagination(1, true))
});
</script>

<style lang="scss">
.navigation-container {
    margin: 50px 0;
    display: flex;
    justify-content: center;
}
</style>
