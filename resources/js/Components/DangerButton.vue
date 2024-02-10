<template>
    <button
        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
        <TrashIcon class="h-4 w-4 text-white" />
        <slot />
    </button>
</template>

<script setup>
import { TrashIcon } from '@heroicons/vue/24/solid'


</script>
