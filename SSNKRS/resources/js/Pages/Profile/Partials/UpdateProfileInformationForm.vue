<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const client = usePage().props.auth.client;

const form = useForm({
    name: user.name,
    email: user.email,
    dataN: client.dataN,
    telefon: client.telefon,
    calle: client.calle,
    poblacion: client.poblacion,
    cpostal: client.cpostal,
    info_adicional: client.info_adicional,
});

function filterNonNumeric(event) {
    const input = event.target.value;
    form.telefon = input.replace(/\D/g, ''); // Solo deja los dígitos
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Información de Usuario</h2>

            <p class="mt-1 text-sm text-gray-600">
                Actualice la información del perfil y la dirección de correo electrónico de su cuenta.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Nombre" />

                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus
                    autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Correo electrónico   " />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email"
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="dataN" value="Fecha de nacimiento" />

                <input
                    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full"
                    ref="input" id="dataN" type="date" v-model="form.dataN" autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.dataN" />
            </div>

            <div>
                <InputLabel for="telefon" value="Numero de teléfon" />
                <div class="relative mt-2 rounded-md shadow-sm">
                    <input type="text" name="telefon" id="telefon"
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        autocomplete="telefon" v-model="form.telefon" @input="filterNonNumeric" />
                </div>

                <InputError class="mt-2" :message="form.errors.telefon" />
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <InputLabel for="poblacion" value="Población" />
                    <input type="text" name="poblacion" id="poblacion"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        autocomplete="poblacion" v-model="form.cpostal" />

                    <InputError class="mt-2" :message="form.errors.poblacion" />
                </div>
                <div>
                    <InputLabel for="calle" value="Calle" />
                    <input type="text" name="calle" id="calle"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        autocomplete="calle" v-model="form.cpostal" />

                    <InputError class="mt-2" :message="form.errors.calle" />
                </div>
                <div>
                    <InputLabel for="cpostal" value="Código postal" />
                    <input type="text" name="cpostal" id="cpostal"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        autocomplete="cpostal" v-model="form.cpostal" @input="filterNonNumeric" />

                    <InputError class="mt-2" :message="form.errors.cpostal" />
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800">
                    Su dirección de correo electrónico no está verificada.
                    <Link :href="route('verification.send')" method="post" as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Haga clic aquí para volver a enviar el correo electrónico de verificación.
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600">
                    Se ha enviado un nuevo enlace de verificación a su dirección de correo electrónico.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
