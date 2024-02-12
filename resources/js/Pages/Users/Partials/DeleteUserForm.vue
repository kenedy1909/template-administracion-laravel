<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref, inject } from 'vue';

const swal = inject('$swal');

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);
const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    }
});

const user = props.user;
const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('users.destroy', user.id), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            swal({
                title: "Registro Eliminado",
                text: "El usuario se ha eliminado exitosamente",
                icon: "success"
            })
        },
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900">Eliminar Usuario</h2>

            <p class="mt-1 text-sm text-gray-600">
                Una vez que se elimine la cuenta, todos sus recursos y datos se eliminarán permanentemente. Antes de
                eliminar la cuenta, descargue cualquier dato o información que desee conservar.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">Eliminar Usuario</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    ¿Estás seguro de que quieres eliminar la cuenta?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Una vez que se elimine la cuenta, todos sus recursos y datos se eliminarán permanentemente.
                    Por favor ingrese su contraseña para confirmar que desea eliminar permanentemente su cuenta.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only" />

                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="mt-1 block w-3/4" placeholder="Contraseña" @keyup.enter="deleteUser" />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancelar </SecondaryButton>

                    <DangerButton class="ms-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteUser">
                        Eliminar Usuario
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
