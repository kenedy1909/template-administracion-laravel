<template>
    <Head title="Iniciar Sesión" />

    <GuestLayout>
        <Link href="/" class="flex items-center justify-center">
        <ApplicationLogo class="fill-current text-gray-500" />
        </Link>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Correo electronico" />
                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-3">
                <InputLabel for="password" value="Contraseña" />
                <Password id="password" class="mt-1 w-full" v-model="form.password" :feedback="false" variant="filled" required toggleMask />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 flex justify-between">
                <label class="inline-flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="mx-2 text-sm text-zinc-600">Recordarme</span>
                </label>
            </div>

            <div class="mt-6">
                <Button
                    type="button"
                    :label="'Iniciar Sesión'"
                    :loading="loading"
                    @click="submit()"
                    :disabled="form.processing"
                    class="w-full bg-zinc-900"
                />
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref} from "vue";
import Password from 'primevue/password';
import Button from 'primevue/button';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

// Botón de login
const loading = ref(false);

const submit = () => {
    loading.value = true;
    setTimeout(() => {
        form.post(route("login"), {
            onFinish: () => {
                form.reset("password"), (loading.value = false);
            },
        });
    }, 1000);
};
</script>
<style>
.p-password-input{
    width: 100% !important;
    border: solid 0.5px;
}
</style>