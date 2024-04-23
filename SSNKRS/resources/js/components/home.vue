<template>
    <div class="home bg-white">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img :src="'img/imgCarrusel1.jpg'" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="img/imgCarrusel2.jpg" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="img/imgCarrusel3.jpg" class="d-block w-100" alt="..." />
                </div>
                <div class="carousel-item">
                    <img src="img/imgCarrusel4.jpg" class="d-block w-100" alt="..." />
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="pt-5 pb-3 px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="titulo">
                <span>Lo Mejor de NIKE</span>
                <a class="vermas" href="#">
                    ver mas
                    <svg class="h-8" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                    </svg>
                </a>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <div v-for="producto in productos_masvendidos.slice(0, 4)" :key="producto.id" class="group relative">
                    <div
                        class="w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75">
                        <img :src="producto.image" :alt="producto.name"
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                    </div>

                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-base text-gray-700">
                                <router-link @click="scrollToTop" :to="producto.href">
                                    <span aria-hidden="true" class="absolute inset-0" />
                                    {{ producto.name }}
                                </router-link>
                            </h3>
                            <p class="mt-1 text-base text-gray-500">{{ producto.brand }}</p>
                        </div>
                        <p class="text-base font-medium text-gray-900">{{ producto.price }}€</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="pt-5 pb-3 px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="titulo">
                <span>Lo Mejor de YEEZY</span>
                <a class="vermas" href="#">
                    ver mas
                    <svg class="h-8" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                    </svg>
                </a>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <div v-for="producto in productos_nuevos.slice(0, 4)" :key="producto.id" class="group relative">
                    <div
                        class="w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75">
                        <img :src="producto.image" :alt="producto.name"
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-base text-gray-700">
                                <router-link @click="scrollToTop" :to="producto.href">
                                    <span aria-hidden="true" class="absolute inset-0" />
                                    {{ producto.name }}
                                </router-link>
                            </h3>
                            <p class="mt-1 text-base text-gray-500">{{ producto.brand }}</p>
                        </div>
                        <p class="text-base font-medium text-gray-900">{{ producto.price }}€</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="pt-5 pb-3 px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="titulo">
                <span>Próximos Lazamientos</span>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:gap-x-8">
                <div class="group relative">
                    <div
                        class="w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-85">
                        <img :src="'img/img-lanzamiento-1.png'" alt="Front of men's Basic Tee in black."
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                </div>
                <div class="group relative">
                    <div
                        class="w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-85">
                        <img :src="'img/img-lanzamiento-2.png'" alt="Front of men's Basic Tee in black."
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                </div>
                <div class="group relative">
                    <div
                        class="w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-85">
                        <img :src="'img/img-lanzamiento-3.png'" alt="Front of men's Basic Tee in black."
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-5 pb-3 px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div>
                <span>As Seen On Instagram <br>
                    Use #SkySNKRS and you could be featured.</span>
            </div>
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <div class="group relative">
                    <div
                        class="w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-85">
                        <img :src="'img/wastep.jpg'" alt="Front of men's Basic Tee in black."
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                </div>
                <div class="group relative">
                    <div
                        class="w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-85">
                        <img :src="'img/marcp.jpg'" alt="Front of men's Basic Tee in black."
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                </div>
                <div class="group relative">
                    <div
                        class="w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-85">
                        <img :src="'img/scrapw.jpg'" alt="Front of men's Basic Tee in black."
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                </div>
                <div class="group relative">
                    <div
                        class="w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-85">
                        <img :src="'img/joelc.jpg'" alt="Front of men's Basic Tee in black."
                            class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const productos_masvendidos = ref([]);
const productos_nuevos = ref([]);
const productos_proximos = ref([]);

// Realizar solicitudes a la API y actualizar los arrays de productos
axios.get('http://localhost:3000/api/sneakers', {
    params: {
        columna: "brand",
        filtro: "NIKE"
    }
})
    .then(response => {
        productos_masvendidos.value = response.data.map(producto => ({
            ...producto,
            href: `/detalle/${producto.id}`
        }));
    })
    .catch(error => {
        console.error('Error al obtener los productos más vendidos:', error);
    });


axios.get('http://localhost:3000/api/sneakers', {
    params: {
        columna: "brand",
        filtro: "YEEZY"
    }
})
    .then(response => {
        productos_nuevos.value = response.data.map(producto => ({
            ...producto,
            href: `/detalle/${producto.id}`,
        }));
    })
    .catch(error => {
        console.error('Error al obtener los productos nuevos:', error);
    });

axios.get('http://localhost:3000/api/sneakers', {
    params: {
        columna: "brand",
        filtro: "YEEZY"
    }
})
    .then(response => {
        productos_proximos.value = response.data.map(producto => ({
            ...producto,
            href: `/detalle/${producto.id}`,
        }));
    })
    .catch(error => {
        console.error('Error al obtener los próximos lanzamientos:', error);
    });
</script>

<script>
export default {
    methods: {
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}   
</script>