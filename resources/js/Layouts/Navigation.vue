<template>
    <div :class="$page.props.showingMobileMenu ? 'block' : 'hidden'" @click="$page.props.showingMobileMenu = false"
        class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden"></div>

    <div :class="$page.props.showingMobileMenu ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
        class="overflow-y-auto fixed inset-y-0 left-0 z-30 w-64 bg-gray-900 transition duration-300 transform lg:translate-x-0 lg:static lg:inset-0">
        <div class="flex justify-center items-center mt-8">
            <div class="flex items-center">
                <svg class="w-12 h-12" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M364.61 390.213C304.625 450.196 207.37 450.196 147.386 390.213C117.394 360.22 102.398 320.911 102.398 281.6C102.398 242.291 117.394 202.981 147.386 172.989C147.386 230.4 153.6 281.6 230.4 307.2C230.4 256 256 102.4 294.4 76.7999C320 128 334.618 142.997 364.608 172.989C394.601 202.981 409.597 242.291 409.597 281.6C409.597 320.911 394.601 360.22 364.61 390.213Z"
                        fill="#4C51BF" stroke="#4C51BF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M201.694 387.105C231.686 417.098 280.312 417.098 310.305 387.105C325.301 372.109 332.8 352.456 332.8 332.8C332.8 313.144 325.301 293.491 310.305 278.495C295.309 263.498 288 256 275.2 230.4C256 243.2 243.201 320 243.201 345.6C201.694 345.6 179.2 332.8 179.2 332.8C179.2 352.456 186.698 372.109 201.694 387.105Z"
                        fill="white" />
                </svg>

                <span class="mx-2 text-2xl font-semibold text-white">Administrador</span>
            </div>
        </div>

        <nav class="mt-10 pl-3" x-data="{ isMultiLevelMenuOpen: false }">
            <nav-link :href="route('dashboard')" :active="route().current('dashboard')">
                <ChartPieIcon class="h-6 w-6 text-white" />
                <span class="mx-3">Inicio</span>
            </nav-link>

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

            <nav-link :href="route('about')" :active="route().current('about')">
                <ClipboardDocumentIcon class="h-6 w-6 text-white" />
                <span class="mx-3">Pagina </span>
            </nav-link>

            <a class="flex items-center mt-4 py-2 px-6 text-gray-100" href="#"
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
import { Link } from '@inertiajs/vue3';
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
        BarsArrowDownIcon
    },

    setup() {
        let showingTwoLevelMenu = ref(false)

        return {
            showingTwoLevelMenu
        }
    },
}
</script>

<style scoped></style>
