<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import MultiSelect from 'primevue/multiselect';

import { Link, useForm, usePage } from '@inertiajs/vue3';
import { inject } from 'vue';
const swal = inject('$swal');
const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
    roles: {
        type: Object,
        default: () => ({}),
    },
    userRoles: {
        type: Object,
        default: () => ({}),
    },
});

const selectedRoles = Object.values(props.userRoles);
const user = props.user;

const submit = () => {
    form.patch(route('users.update', user.id), {
        onSuccess: () => swal({
            title: "Registro Actualizado",
            text: "El usuario se ha actualizado exitosamente",
            icon: "success"
        })
    });
};

const form = useForm({
    name: user.name,
    email: user.email,
    estado: user.estado,
    roles_user: selectedRoles
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Información usuario</h2>

            <p class="mt-1 text-sm text-gray-600">
                Actualice la información del usuario y la dirección de correo electrónico.
            </p>
        </header>
        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Nombre" />
                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                    autocomplete="name" />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Correo electronico" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
                    autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="roles" value="Roles" />

                <div class="card flex justify-content-center">
                    <MultiSelect id="roles" v-model="form.roles_user" display="chip" :options="Object.values(roles)"
                        placeholder="Seleccione rol" :maxSelectedLabels="3" class="w-full md:w-20rem" />
                </div>
                <InputError class="mt-2" :message="form.errors.roles_user" />
            </div>
            <div>
                <InputLabel for="estado" value="Estado" />

                <select id="estado" v-model="form.estado"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    <option value="Activo">Activo</option>
                    <option value="Bloqueado">Bloqueado</option>
                </select>
                <InputError class="mt-2" :message="form.errors.estado" />
            </div>
            <div class="flex items-center gap-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Guardar
                </PrimaryButton>
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Actualizado.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
