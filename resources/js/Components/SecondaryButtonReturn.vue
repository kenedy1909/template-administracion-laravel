<script setup>
import { ArrowLeftIcon } from "@heroicons/vue/24/solid";

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <button
        @click="goBack"
        class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
    >
        <ArrowLeftIcon class="h-4 w-4 mr-2" />
        Regresar
    </button>
</template>
