<template>
    <Link :href="href"
        class="inline-flex items-center px-4 py-2 bg-sky-700 border border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
    <slot />
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
defineProps({
    type: {
        type: String
    },
});
</script>
