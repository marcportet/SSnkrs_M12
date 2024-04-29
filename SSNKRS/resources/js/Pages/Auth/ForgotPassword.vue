<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <div class="font-[sans-serif] text-[#333]">

        <Head title="Contraseña Olvidada" />
        <div class="min-h-screen flex flex-col items-center justify-center">
            <div
                class="grid items-center gap-4 p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md">
                <div class="md:max-w-md w-full sm:px-6 py-4">
                    <form @submit.prevent="submit">
                        <div class="mb-8 flex">
                            <a :href="route('home')">
                                <svg class="w-[23px] h-[23px] text-gray-800 dark:text-white" style="height: 35;"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    fill="#333333" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <svg class="w-[23px] h-[23px] text-gray-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                viewBox="0 0 24 24" style="height: 37;">
                                <path stroke="#333333" stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                    d="m9 5 7 7-7 7" />
                            </svg>
                            <h3 class="text-3xl font-extrabold">Contraseña Olvidada</h3>
                        </div>
                        <div class="mb-4 text-sm text-gray-600">
                            ¿Olvidaste tu contraseña? Ningún problema. Simplemente háganos saber su dirección de correo
                            electrónico y le enviaremos un correo electrónico.
                            un restablecimiento de contraseña
                            enlace que le permitirá elegir uno nuevo.
                        </div>

                        <div>
                            <InputLabel for="email" value="Email" class="text-xs block mb-2"/>

                            <div class="relative flex items-center">
                                <TextInput id="email" type="email"
                                    class="w-full text-sm border-b border-gray-300 focus:border-[#333] px-2 py-3 outline-none"
                                    v-model="form.email" required autofocus autocomplete="username" />
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb"
                                    class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 682.667 682.667">
                                    <defs>
                                        <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                            <path d="M0 512h512V0H0Z" data-original="#000000"></path>
                                        </clipPath>
                                    </defs>
                                    <g clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                                        <path fill="none" stroke-miterlimit="10" stroke-width="40"
                                            d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z"
                                            data-original="#000000"></path>
                                        <path
                                            d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z"
                                            data-original="#000000"></path>
                                    </g>
                                </svg>
                            </div>

                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div class="mt-12">
                            <button
                                class="w-full shadow-xl py-2.5 px-4 text-sm font-semibold rounded-full text-white bg-blue-600 hover:bg-blue-700 focus:outline-none"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Enviar Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
