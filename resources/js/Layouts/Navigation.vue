<template>
    <div :class="$page.props.showingMobileMenu ? 'block' : 'hidden'" @click="$page.props.showingMobileMenu = false"
        class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"></div>

    <div :class="$page.props.showingMobileMenu ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
        class="overflow-y-auto fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
        <div class="flex justify-center items-center mt-4">
            <div class="flex items-center justify-center">
                <img :src="imglogo_w" class="w-1/2" alt="">

                <!-- <span class="mx-2 text-2xl font-semibold text-white">Administrador</span> -->
            </div>
        </div>

        <nav class="mt-6" x-data="{ isMultiLevelMenuOpen: false }">
            <SeparadorMenu>Menú</SeparadorMenu>
            <nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                <ChartPieIcon class="h-6 w-6 text-white" />
                <span class="mx-3">Inicio</span>
            </nav-link>
            <nav-link :href="route('about')" :active="route().current('about')">
                <ClipboardDocumentIcon class="h-6 w-6 text-white" />
                <span class="mx-3">Pagina </span>
            </nav-link>
            <SeparadorMenu>Configuración</SeparadorMenu>
            <nav-link v-if="$page.props.user.permissions.includes('usuarios-listar')" :href="route('users.index')"
                :active="route().current('users.index')">
                <UserGroupIcon class="h-6 w-6 text-white" />
                <span class="mx-3">Usuarios</span>
            </nav-link>

            <nav-link class="flex items-center " v-if="$page.props.user.permissions.includes('rol-listar')"
                :href="route('roles.index')" :active="route().current('roles.index')">
                <FingerPrintIcon class="h-6 w-6 text-white" />
                <span class="mx-3">Roles</span>

            </nav-link>


            <a class="flex items-center mt-4  ml-4 py-2 px-6 text-gray-100" href="#"
                @click="showingTwoLevelMenu = !showingTwoLevelMenu">
                <BarsArrowDownIcon class="h-6 w-6 text-white" />
                <span class="mx-3">Two-level menu</span>
            </a>
            <transition enter-to-class="transition-all duration-300 ease-in-out" enter-from-class="max-h-0 opacity-25"
                leave-from-class="opacity-100 max-h-xl" leave-to-class="max-h-0 opacity-0">
                <div v-show="showingTwoLevelMenu">
                    <ul class="overflow-hidden p-2 mx-4 mt-2 space-y-2 text-sm font-medium text-white bg-gray-700 bg-opacity-50 rounded-md shadow-inner"
                        aria-label="submenu">
                        <li class="px-2 py-1 transition-colors duration-150">
                            <Link class="w-full" :href="route('dashboard')">Child menu</Link>
                        </li>
                    </ul>
                </div>
            </transition>
        </nav>
    </div>
</template>

<script>
import NavLink from '@/Components/NavLink.vue';
import SeparadorMenu from "@/Components/SeparadorMenu.vue";
import { Link } from '@inertiajs/vue3';
import imglogo_w from '/public/assets/img/logo_white.png'
import { ref } from 'vue'
import { FingerPrintIcon, UserGroupIcon, ChartPieIcon, ClipboardDocumentIcon, BarsArrowDownIcon } from '@heroicons/vue/24/solid'

export default {
    components: {
        NavLink,
        Link,
        FingerPrintIcon,
        UserGroupIcon,
        ChartPieIcon,
        ClipboardDocumentIcon,
        BarsArrowDownIcon,
        SeparadorMenu
    },

    setup() {
        let showingTwoLevelMenu = ref(false)

        return {
            showingTwoLevelMenu,
            imglogo_w
        }
    },
}
</script>

<style scoped></style>
