<template>
    <header class="flex items-center justify-between border-b-4 border-zinc-700 bg-white px-3 py-3">
        <div class="flex items-center">
            <button @click="$page.props.showingMobileMenu = !$page.props.showingMobileMenu"
                class="text-gray-500 focus:outline-none lg:hidden">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </button>
        </div>

        <div class="flex items-center">
            <div class="mr-6">
            </div>
            <dropdown>
                <template #trigger>
                    <button @click="dropdownOpen = !dropdownOpen" class="flex overflow-hidden">
                        <UserCircleIcon class="h-6 w-6 mr-2"> </UserCircleIcon>{{ $page.props.auth.user.name }}
                    </button>
                </template>

                <template #content>
                    <dropdown-link :href="route('profile.edit')">
                        Perfil
                    </dropdown-link>

                    <dropdown-link class="w-full text-left" :href="route('logout')" method="post" as="button">
                        Cerrar Sesión
                    </dropdown-link>
                </template>
            </dropdown>
        </div>
        
    </header>
    <loading v-model:active="isLoading" :width="170" :height="170" :background-color="'#fff'" :opacity="1"
        color="#0e7490" :can-cancel="false" :is-full-page="true" />
</template>

<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { UserCircleIcon } from "@heroicons/vue/24/outline";
import { ref } from "vue";
import { useForm } from '@inertiajs/vue3';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
const visible = ref(false);
const isLoading = ref(false);
const form = useForm({
    id_sc: '',
});


const submitSendSucursal = (id_sc) => {
    isLoading.value = true;
    form.id_sc = id_sc;
    form.post(route('changesucur'), {
        onSuccess: function () {
            form.reset('nombre');
            visible.value = false;
            setTimeout(() => {
                isLoading.value = false;
            }, "2000");
        }
    });
};
</script>
