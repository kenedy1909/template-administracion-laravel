<template>
    <Link :href="href" :class="classes">
    <slot name="icon" />
    <slot />
    </Link>
</template>

<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? 'flex items-center mt-2 ml-4 py-2 px-6 bg-sky-500  text-gray-100 rounded-l-lg'
    : 'flex items-center mt-2 ml-4 py-2 px-6 text-gray-100 hover:bg-sky-600 hover:rounded-l-lg'
);
</script>
