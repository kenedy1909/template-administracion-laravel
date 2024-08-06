<template>
    <div class="flex h-screen bg-gray-200 font-roboto">
        <Navigation />

        <div class="flex flex-1 flex-col overflow-hidden">
            <Header />

            <main class="flex-1 overflow-y-auto overflow-x-hidden bg-gray-200 scroll-container">
                <div class="bg-zinc-900 px-6 py-2 grid grid-cols-2">
                    <div>
                        <h3 class="min-[300px]:text-sm md:text-md lg:text-lg font-medium text-white">
                            <slot name="header" />
                        </h3>
                    </div>
                    <div>
                        <nav class="flex justify-end" aria-label="Breadcrumb">
                            <ol
                                class="inline-flex items-center space-x-1 min-[300px]:text-sm md:text-md lg:text-lg  md:space-x-2 rtl:space-x-reverse">
                                <li class="items-center hidden lg:block">
                                    <a href="#" class="inline-flex items-center text-white">
                                        <svg class="w-3 h-3 me-2.5" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                        </svg>
                                        Inicio
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="rtl:rotate-180 w-3 h-3 text-white 0 mx-1" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 9 4-4-4-4" />
                                        </svg>
                                        <a href="#" class="ms-1 text-white md:ms-2">
                                            <slot name="header" />
                                        </a>
                                    </div>
                                </li>

                            </ol>
                        </nav>
                    </div>

                </div>
                <div class="mx-auto px-3 py-4">

                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import Header from '@/Layouts/Header.vue';
import Navigation from '@/Layouts/Navigation.vue';
</script>
