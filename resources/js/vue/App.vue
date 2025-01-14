<template>
    <component :is="currentView"></component>
</template>

<script setup>
import { ref, onMounted } from 'vue';

// Use ref to store the view dynamically
const currentView = ref(null);

onMounted(() => {
    const appElement = document.querySelector('#app');

    if (appElement) {
        currentView.value = appElement.dataset.view;
    }
});
</script>
