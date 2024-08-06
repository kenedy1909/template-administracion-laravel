<template>
    <div :class="$page.props.showingMobileMenu ? 'block' : 'hidden'" @click="$page.props.showingMobileMenu = false"
        class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"></div>

    <div :class="$page.props.showingMobileMenu ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
        class="overflow-y-auto fixed inset-y-0 left-0 z-30 w-64 bg-zinc-900 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
        <div class="flex justify-center items-center mt-4">
            <div class="flex items-center justify-center">
                <img :src="imglogo_w" class="w-1/2" alt="">

                <!-- <span class="mx-2 text-2xl font-semibold text-white">Administrador</span> -->
            </div>
        </div>

        <nav class="mt-6" x-data="{ isMultiLevelMenuOpen: false }">
            <SeparadorMenu>Menú</SeparadorMenu>
            <nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                <ChartPieIcon class="h-6 w-6" />
                <span class="mx-3">Inicio</span>
            </nav-link>
            <nav-link :href="route('about')" :active="route().current('about')">
                <ClipboardDocumentIcon class="h-6 w-6 " />
                <span class="mx-3">Pagina </span>
            </nav-link>
            <SeparadorMenu>Configuración</SeparadorMenu>
            <nav-link v-if="$page.props.user.permissions.includes('usuarios-listar')" :href="route('users.index')"
                :active="route().current('users.index')">
                <UserGroupIcon class="h-6 w-6 " />
                <span class="mx-3">Usuarios</span>
            </nav-link>

            <nav-link class="flex items-center " v-if="$page.props.user.permissions.includes('rol-listar')"
                :href="route('roles.index')" :active="route().current('roles.index')">
                <FingerPrintIcon class="h-6 w-6 " />
                <span class="mx-3">Roles</span>

            </nav-link>

            <a
                :class="[
                    'flex items-center mt-2 ml-4 py-2 px-6 text-gray-100',
                    showingTwoLevelMenu ? 'shadow-xl' : '',
                ]"
                href="#"
                @click="showingTwoLevelMenu = !showingTwoLevelMenu"
            >
                <BarsArrowDownIcon class="h-6 w-6 text-white" />
                <span class="mx-3">Reportes</span>
            </a>
            <Collapse
                :when="showingTwoLevelMenu"
                class="v-collapse shadow-inner"
            >
                <ul
                    class="overflow-hidden py-2 bg-zinc-700 space-y-2 text-sm font-medium text-white bg-opacity-30 shadow-inner"
                    aria-label="submenu"
                >
                    <li
                        :class="[
                            'px-4 ml-12 py-2 transition-colors duration-150 hover:border-r-4  hover:bg-zinc-950 hover:rounded-l-lg flex',
                            route().current().includes('get_uno')
                                ? 'border-r-4  bg-zinc-950 rounded-l-lg'
                                : '',
                        ]"
                    >
                        <ArrowTrendingUpIcon class="h-6 w-6 text-white" />
                        <Link
                            class="w-full ml-2 mt-1"
                        >
                            Ventas
                        </Link>
                    </li>

                    <li
                        :class="[
                            'px-4 ml-12 py-2 flex transition-colors duration-150 hover:border-r-4 hover:bg-zinc-950 hover:rounded-l-lg',
                            route().current().includes('get_dos')
                                ? 'border-r-4 bg-zinc-950 rounded-l-lg'
                                : '',
                        ]"
                    >
                        <ArrowTrendingDownIcon class="h-6 w-6 text-white" />
                        <Link
                            class="w-full ml-2 mt-1"
                            >Gastos</Link
                        >
                    </li>
                    <li
                        :class="[
                            'px-4 ml-12 flex py-2 transition-colors duration-150 hover:border-r-4 hover:bg-zinc-950 hover:rounded-l-lg',
                            route().current().includes('get_tres')
                                ? 'border-r-4 bg-zinc-950 rounded-l-lg'
                                : '',
                        ]"
                    >
                        <ArrowTrendingDownIcon class="h-6 w-6 text-white" />
                        <Link
                            class="w-full ml-2 mt-1"
                            >Retiros</Link
                        >
                    </li>
                </ul>
            </Collapse>
        </nav>
    </div>
</template>

<script setup>
import NavLink from "@/Components/NavLink.vue";
import SeparadorMenu from "@/Components/SeparadorMenu.vue";
import { usePage, Link } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { Collapse } from "vue-collapsed";
import 'primeicons/primeicons.css';
import { FingerPrintIcon, UserGroupIcon, ChartPieIcon, ClipboardDocumentIcon, BarsArrowDownIcon } from '@heroicons/vue/24/solid';

const imglogo_w = "/assets/img/logo_white.png";
const showingTwoLevelMenu = ref(false);

const ruta = usePage().url;
const user = computed(() => usePage().props.user);
console.log(user.value);
if (
    ruta.includes("get_uno") ||
    ruta.includes("get_dos") ||
    ruta.includes("get_tres")
) {
    showingTwoLevelMenu.value = true;
}
</script>

<style>
.v-collapse[data-collapse="expanding"] {
    transition: height 600ms ease-in-out;
}

.v-collapse[data-collapse="collapsing"] {
    transition: height 400ms ease-out;
}
</style>