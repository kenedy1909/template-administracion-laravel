<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm, usePage, Link } from "@inertiajs/vue3";
import { watch } from "vue";
import SecondaryButtonReturn from "@/Components/SecondaryButtonReturn.vue";
import MultiSelect from "primevue/multiselect";
import Fieldset from "primevue/fieldset";

const props = defineProps({
    role: { type: Object },
    permission: Object,
    rolePermissions: Object,
});

import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const selectedPermissions = Object.values(props.rolePermissions);
const form = useForm({
    name: props.role.name,
    permisos: selectedPermissions,
});

const submit = () => {
    form.patch(route("roles.update", props.role.id), {
        onSuccess: () =>
            toast.add({
                severity: "success",
                summary: "Registro Guardado",
                detail: "El rol se ha actualizado exitosamente",
                life: 5000,
            }),
    });
};

watch(
    () => usePage().props.flash.code,
    () => {
        if (usePage().props.flash.code) {
        }
    }
);

const agruparPorModulo = (permisos) => {
    const grupos = {};
    permisos.forEach((permiso) => {
        const [modulo] = permiso.split("-");
        if (!grupos[modulo]) {
            grupos[modulo] = [];
        }
        grupos[modulo].push(permiso);
    });
    return grupos;
};

const colorPorModulo = (modulo) => {
    const colores = {
        usuarios: "bg-blue-200",
        servicios: "bg-sky-600 text-white",
        empleados: "bg-cyan-200",
        sucursal: "bg-orange-400  text-white",
        gastos: "bg-red-400  text-white",
        clientes: "bg-emerald-400 text-white",
        // Agrega más colores para otros módulos si es necesario
    };
    return colores[modulo] || "bg-gray-200"; // Color predeterminado
};
</script>

<template>
    <Head title="Editar Rol" />

    <AuthenticatedLayout>
        <template #header>
            <Link class="text-white" href="/roles"> Roles </Link> /
            {{ form.name }}
        </template>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="flex flex-col bg-white border shadow-sm rounded-xl">
                <div
                    class="bg-gray-100 border-b rounded-t-xl py-3 px-4 md:py-4 md:px-5 grid min-[300px]:grid-cols-2 lg:grid-cols-2 gap-4"
                >
                    <h3 class="mt-1 text-gray-500">Editar Rol</h3>
                    <div class="text-right">
                        <SecondaryButtonReturn class="text-center"/>
                    </div>
                </div>
                <div class="p-4 md:p-5">
                    <form @submit.prevent="submit">
                        <div
                            class="mx-auto sm:grid sm:grid-cols-1 sm:px-2 lg:px-2 p-4 gap-4"
                        >
                            <div class="mx-2">
                                <InputLabel for="name" value="Rol"></InputLabel>
                                <TextInput
                                    id="name"
                                    v-model="form.name"
                                    autofocus
                                    required
                                    type="text"
                                    class="mt-1 block w-full"
                                >
                                </TextInput>
                                <InputError
                                    :message="form.errors.name"
                                    class="mt-2"
                                ></InputError>
                            </div>
                            <div class="sm:mx-2 sm:w-full">
                                <InputLabel
                                    for="name"
                                    value="Permisos"
                                    class="mb-1"
                                ></InputLabel>
                                <!-- <MultiCheckbox name="permisos" v-model:value="form.permisos" :options="permission" />  -->
                                <MultiSelect
                                    name="permisos"
                                    v-model="form.permisos"
                                    selectedItemsLabel="{} permisos seleccionados"
                                    :options="Object.values(permission)"
                                    filter
                                    placeholder="Selecciona los permisos"
                                    :maxSelectedLabels="7"
                                    class="w-full md:w-20rem"
                                    :checked="permission.id"
                                />
                            </div>
                            <div></div>
                            <div class="p-2 text-right">
                                <PrimaryButton
                                    :disabled="form.processing"
                                    :class="{ 'opacity-25': form.processing }"
                                    class="my-2"
                                >
                                    <i class="fa-solid fa-save"></i> Actualizar
                                </PrimaryButton>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div
                class="lg:col-span-2 flex flex-col bg-white border shadow-sm rounded-xl"
            >
                <div class="p-4 md:p-5 grid lg:grid-cols-2 gap-4">
                    <span
                        v-for="(grupoPermisos, modulo) in agruparPorModulo(
                            form.permisos
                        )"
                        :key="modulo"
                        class="mt-2 inline-block"
                    >
                        <Fieldset :legend="modulo">
                            <span
                                v-for="permiso in grupoPermisos"
                                :key="permiso"
                                :class="colorPorModulo(modulo)"
                                class="inline-block mt-1 text-sm font-medium me-2 px-2.5 py-0.5 rounded"
                            >
                                {{ permiso }}
                            </span>
                        </Fieldset>
                    </span>
                </div>
            </div>
        </div>
        <Toast />
    </AuthenticatedLayout>
</template>
