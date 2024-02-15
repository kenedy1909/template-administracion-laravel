<template>
    <Head title="Roles del sistema" />

    <AuthenticatedLayout>
        <template #header>
            Roles del sistema
        </template>


        <div class="lg:w-1/2 md:w-2/3 overflow-x-scroll md:overflow-x-auto">
            <div class="text-right p-4">
                <PrimaryLink :href="route('roles.create')">
                    Agregar
                </PrimaryLink>
            </div>
        </div>

        <div class="lg:w-1/2 md:w-2/3 overflow-x-scroll md:overflow-x-auto rounded-lg shadow">
            <table class="w-full whitespace-no-wrap overflow-x-auto">
                <thead>
                    <tr class="border-b bg-gray-50 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">
                        <th
                            class="border-b-2 border-gray-200 bg-gray-100 sm:px-5 sm:py-3 p-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Nombre
                        </th>
                        <th
                            class="border-b-2 border-gray-200 bg-gray-100 sm:px-5 sm:py-3 p-2 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in slicedRoles" :key="role.id" class="text-gray-700">
                        <td class="border-b border-gray-200 bg-white sm:px-5 sm:py-5 p-2 sm:text-sm text-xs">
                            <p class="text-gray-900 whitespace-no-wrap">{{ role.name }}</p>
                        </td>
                        <td
                            class="inline-flex w-full border-b border-gray-200 bg-white sm:px-5 sm:py-5 p-2 sm:text-sm text-xs">

                            <SecondaryButton :href="route('roles.edit', role.id)" class="mr-2">
                                Editar
                            </SecondaryButton>

                            <DangerButton @click="confirmUserDeletion(role.id)">Eliminar</DangerButton>

                        </td>
                    </tr>
                </tbody>
            </table>

            <div
                class="flex items-center border-b bg-gray-50 px-5 py-2 xs:flex-row justify-between text-gray-500 text-xs font-semibold">
                <button class="hover:scale-125 transition duration-500 cursor-pointer" @click="previousPage"
                    :disabled="currentPage === 0"><i class="fa-solid fa-arrow-left"></i></button>
                <p>Pagina {{ currentPage + 1 }} de {{ totalPages }}</p>
                <button class="hover:scale-125 transition duration-500 cursor-pointer" @click="nextPage"
                    :disabled="currentPage === totalPages - 1"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
        </div>
        <Modal :show="confirmingDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Estás seguro de que quieres eliminar un rol de usuario?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Una vez que se elimine el rol, todos los permisos se eliminaran permanentemente de los usuarios.

                    Por favor ingrese su contraseña para confirmar que desea eliminar.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Contraseña" class="sr-only" />

                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="mt-1 block w-3/4" placeholder="Contraseña" @keyup.enter="deleteRol" />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancelar </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteRol">
                        Eliminar rol
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Pagination.vue'
import PrimaryLink from '@/Components/PrimaryLink.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { ref, computed, watch, inject } from 'vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
const props = defineProps({
    roles: Object
})
const swal = inject('$swal');

// Modal de eliminacion
const confirmingDeletion = ref(false);
const role_id = ref();
const form = useForm({
    password: '',
});

const closeModal = () => {
    confirmingDeletion.value = false;
    form.reset();
};

const confirmUserDeletion = (id) => {
    confirmingDeletion.value = true;
    role_id.value = id;
};
const deleteRol = () => {
    form.delete(route('roles.destroy', role_id.value), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            swal({
                title: "Registro Eliminado",
                text: "El rol se ha eliminado exitosamente",
                icon: "success"
            })
        },
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

//paginacion tutores
const itemsPerPage = ref(8);
const currentPage = ref(0);

const totalPages = computed(() => Math.ceil(props.roles.length / itemsPerPage.value));



const previousPage = () => {
    if (currentPage.value > 0) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value - 1) {
        currentPage.value++;
    }
};
//FIN Paginacion

watch(itemsPerPage, () => {
    currentPage.value = 0;
});

//SEARCH
const searchTerm = ref('');

//Paginacion y filtro
const slicedRoles = computed(() => {
    const start = currentPage.value * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    const filteredUsers = props.roles.filter(roles =>
        roles.name.toLowerCase().includes(searchTerm.value.toLowerCase())
    );
    return filteredUsers.slice(start, end);
});

</script>
