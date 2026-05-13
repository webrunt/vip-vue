<script setup>
import { onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

onMounted(() => {
    // Remove dashboard-specific classes
    document.body.classList.remove('demo1', 'kt-sidebar-fixed', 'kt-header-fixed');
    
    // Initialize Metronic components when layout mounts
    const initMetronic = () => {
        if (typeof KTComponents !== 'undefined') {
            KTComponents.init();
        }
        if (typeof KTLayout !== 'undefined') {
            KTLayout.init();
        }
    };

    // Run on first load
    initMetronic();

    // Re-initialize after every Inertia page navigation
    router.on('success', () => {
        initMetronic();
    });
});
</script>

<template>
    <div class="grid lg:grid-cols-2 grow">
        <slot />
    </div>  
</template>

<style>
    .branded-bg {
        background-image:url('@assets/media/images/2600x1600/1.png');
    }
    .dark .branded-bg {
        background-image: url('@assets/media/images/2600x1600/1-dark.png');
    }
</style>