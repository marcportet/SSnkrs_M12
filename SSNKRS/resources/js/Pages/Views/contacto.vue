<template>
    <div class="bg-white">

        <Head title="Contacto" />
        <Navbar />
        <section class="relative flex flex-wrap lg:h-screen lg:items-center">
            <div class="w-full px-4 py-12 sm:px-6 sm:py-16 lg:w-1/2 lg:px-8 lg:py-24">

                <div class="mx-auto max-w-lg text-center">
                    <h1 class="text-center text-2xl font-bold text-blue-600 sm:text-3xl">Contactanos en unos segundos
                    </h1>

                    <p class="mx-auto mt-4 max-w-md text-center text-gray-500">
                        Rellena su información de contacto y describe la incidencia producida en los recuadros
                        inferiores, le
                        contestaremos lo antes posible.
                    </p>
                    <br>
                    <div v-if="showMessage"
                        class="inline-block rounded-lg bg-green-500 px-5 py-3 text-sm font-medium text-white w-100">
                        Correo enviado correctamente!
                    </div>
                </div>

                <form @submit.prevent="submitForm" class="mx-auto mb-0 mt-8 max-w-md space-y-4">
                    <div>
                        <label for="name" class="sr-only">Nombre y Apellidos</label>

                        <div class="relative">
                            <input v-model="form.name" type="text"
                                class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-sm"
                                placeholder="Introduce el Nombre y Apellidos" />
                        </div>
                        <span v-if="form.errors.name" class="text-sm m-2 text-red-400">{{ form.errors.name }}</span>
                    </div>

                    <div>
                        <label for="email" class="sr-only">Email</label>

                        <div class="relative">
                            <input v-model="form.email" type="email"
                                class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-sm"
                                placeholder="Enter email" />

                            <span class="absolute inset-y-0 end-0 grid place-content-center px-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </span>
                        </div>
                        <span v-if="form.errors.email" class="text-sm m-2 text-red-400">{{ form.errors.email }}</span>
                    </div>

                    <div>
                        <label for="text" class="sr-only">descripcion</label>

                        <div class="relative">
                            <textarea v-model="form.text"
                                class="w-full rounded-lg border-gray-200 p-4 pe-12 text-sm shadow-sm"
                                style="resize: none;height: 200px;" placeholder="Describe el problema" />
                        </div>

                        <span v-if="form.errors.text" class="text-sm m-2 text-red-400">{{ form.errors.text }}</span>
                    </div>

                    <button type="submit"
                        class="inline-block rounded-lg bg-blue-500 px-5 py-3 text-sm font-medium text-white w-100">
                        Envia el formulario
                    </button>
                </form>
            </div>

            <div class="relative h-64 w-full sm:h-96 lg:h-full lg:w-1/2">
                <img alt="" src="img/sneakers_wall.jpg" class="absolute inset-0 h-full w-full object-cover" />
            </div>
        </section>
        <Footer />
    </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({ user: Object })

const showMessage = ref(false);

function setshowMessage(value) {
    showMessage.value = value;
}

function clearForm() {
    form.reset();
    setshowMessage(true);
    setTimeout(() => setshowMessage(false), 3000)
}
const form = useForm({
    name: '',
    email: '',
    text: ''
})

const submitForm = () => {
    form.post(route('contact'), {
        onSuccess: () => clearForm(),
    })
}
</script>

<script>
import Navbar from '../navbar.vue';
import Footer from '../footer.vue';

export default {
    methods: {
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },
    components: {
        Navbar,
        Footer
    }
}
</script>