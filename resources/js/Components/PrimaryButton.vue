<template>
    <button :type="type"
        class="inline-flex items-center px-4 py-2 bg-zinc-900 border border-white rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-cyan-950 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
        <CloudArrowUpIcon class="h-6 w-6 mr-2 text-white" />
        <slot />
    </button>
</template>

<script setup>
import { CloudArrowUpIcon } from '@heroicons/vue/24/solid'

defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    href: String,
});
</script>
