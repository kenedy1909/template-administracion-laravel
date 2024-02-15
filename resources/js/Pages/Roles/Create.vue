<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import MultiCheckbox from "@/Components/MultiCheckbox.vue";
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import { ref, watch, inject } from 'vue';
import SecondaryButton from "@/Components/SecondaryButton.vue";
const swal = inject('$swal');

const props = defineProps({
    permission: Object,
});

const form = useForm({
    name: '',
    permisos: []
});
const submit = () => {
    form.post(route('roles.store'), {
        onSuccess: () => swal({
            title: "Registro Guardado",
            text: "El rol se ha registrado exitosamente",
            icon: "success"
        })
    });
};
watch(
    () => usePage().props.flash.code,
    () => {
        if (usePage().props.flash.code) {
        }
    }
);

</script>

<template>
    <Head title="Nuevo Rol" />

    <AuthenticatedLayout>
        <template #header>
            <Link class="text-indigo-400 hover:text-indigo-600" href="/roles"> Roles </Link> / {{ form.name }}
        </template>

        <div class="flex flex-col bg-white border shadow-sm rounded-xl lg:w-1/2 md:w-2/3">
            <div class="bg-gray-100 border-b rounded-t-xl py-3 px-4 md:py-4 md:px-5 grid grid-cols-2 gap-4">
                <h3 class="mt-1 text-gray-500">
                    Nuevo Rol
                </h3>
                <div class="text-right">
                    <SecondaryButton :href="route('roles.index')">
                        Regresar
                    </SecondaryButton>
                </div>

            </div>
            <div class="p-4 md:p-5">
                <form @submit.prevent="submit">
                    <div class="mx-auto sm:grid sm:grid-cols-2 sm:px-2 lg:px-2 p-4">
                        <div class="mx-2 ">
                            <InputLabel for="name" value="Rol"></InputLabel>
                            <TextInput id="name" v-model="form.name" autofocus required type="text"
                                class="mt-1 block w-full">
                            </TextInput>
                            <InputError :message="form.errors.name" class="mt-2"></InputError>

                        </div>
                        <div class="sm:mx-2 sm:w-full">
                            <InputLabel for="name" value="Permisos"></InputLabel>
                            <InputError :message="form.errors.permisos" class="mt-2"></InputError>
                            <MultiCheckbox :name="permisos" v-model:value="form.permisos" :options="permission" />
                            <PrimaryButton :disabled="form.processing" class="my-2">
                                <i class="fa-solid fa-save"></i> Registrar
                            </PrimaryButton>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </AuthenticatedLayout>
</template>