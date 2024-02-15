<template>
    <Head title="Agregar usuario" />

    <AuthenticatedLayout>
        <template #header>
            Nuevo usuario
        </template>

        <div class="flex flex-col bg-white border shadow-sm rounded-xl lg:w-1/2 md:w-2/3">
            <div class="bg-gray-100 border-b rounded-t-xl py-3 px-4 md:py-4 md:px-5 grid grid-cols-2 gap-4">
                <h3 class="mt-1 text-gray-500">
                    Nuevo Usuario
                </h3>
                <div class="text-right">
                    <SecondaryButton :href="route('users.index')">
                        Regresar
                    </SecondaryButton>
                </div>

            </div>
            <div class="p-4 md:p-5">
                <form @submit.prevent="submit" class="grid lg:grid-cols-2 gap-4">
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
                        <InputLabel for="password" value="Contraseña" />
                        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                            autocomplete="new-password" />
                        <InputError class="mt-2" :message="form.errors.password" />
                    </div>

                    <div>
                        <InputLabel for="password_confirmation" value="Confirmar contraseña" />
                        <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                            v-model="form.password_confirmation" required autocomplete="new-password" />
                        <InputError class="mt-2" :message="form.errors.password_confirmation" />


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
                        <div class="mt-4 flex flex-col items-end">
                            <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Registrar Usuario
                            </PrimaryButton>

                        </div>
                    </div>

                </form>

            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import SecondaryButton from "@/Components/SecondaryButton.vue";
import MultiSelect from 'primevue/multiselect';
import { inject } from 'vue';

const swal = inject('$swal');

const props = defineProps({
    roles: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
    roles_user: ''
});

const submit = () => {
    form.post(route('users.store'), {
        onSuccess: function () {
            form.reset('password', 'password_confirmation');
            swal({
                title: "Registro Guardado",
                text: "El usuario se ha almacenado exitosamente",
                icon: "success"
            })
        }
    });
};
</script>