<template>
  <div class="bg-white">
    <div class="pt-6" v-for="sneaker in sneaker_API" :key="sneaker.id">
      <div class="mx-auto mt-6 max-w-2xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-1 lg:gap-x-8 lg:px-8">
        <div class="aspect-h-3 aspect-w-5 lg:aspect-h-3 lg:aspect-w-full sm:overflow-hidden sm:rounded-lg">
          <img :src="sneaker.image" :alt="sneaker.name" class="h-full w-full object-cover object-center" />
        </div>
      </div>
      <form class="mt-10">
        <div
          class="mx-auto max-w-2xl px-4 pb-16 pt-10 sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:grid-rows-[auto,auto,1fr] lg:gap-x-8 lg:px-8 lg:pb-24 lg:pt-16">
          <div class="lg:col-span-2  lg:pr-8">
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ sneaker.name }}</h1>
            <p class="text-3xl tracking-tight text-gray-900">{{ sneaker.price }}€</p>
          </div>

          <div class="lg:col-span-2 lg:col-start-1 lg:pb-16 lg:pr-8">
            <!-- Sizes -->
            <div class="mt-10">
              <div class="flex items-center justify-between">
                <h3 class="text-sm font-medium text-gray-900">Size</h3>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Size guide</a>
              </div>

              <RadioGroup v-model="selectedSize" class="mt-4">
                <RadioGroupLabel class="sr-only">Choose a size</RadioGroupLabel>
                <div class="grid grid-cols-4 gap-4 sm:grid-cols-7 lg:grid-cols-4">
                  <RadioGroupOption as="template" v-for="size in sneaker.sizes" :key="size.size" :value="size.size"
                    v-slot="{ checked }">
                    <div
                      :class="['cursor-pointer bg-white text-gray-900 shadow-sm', 'ring-2 ring-blue-500', 'group relative flex items-center justify-center rounded-md border py-3 px-4 text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 sm:py-6']">
                      <RadioGroupLabel as="span">{{ size.size }}</RadioGroupLabel>
                      <span
                        :class="[active ? 'border' : 'border-2', checked ? 'border-blue-500' : 'border-transparent', 'pointer-events-none absolute -inset-px rounded-md']"
                        aria-hidden="true" />
                    </div>
                  </RadioGroupOption>
                </div>
              </RadioGroup>
            </div>
            <!-- Description y details
            <div>
              <h3 class="sr-only">Description</h3>

              <div class="space-y-6">
                <p class="text-base text-gray-900">{{ product.description }}</p>
              </div>
            </div>

            <div class="mt-10">
              <h3 class="text-sm font-medium text-gray-900">Highlights</h3>

              <div class="mt-4">
                <ul role="list" class="list-disc space-y-2 pl-4 text-sm">
                  <li v-for="highlight in product.highlights" :key="highlight" class="text-gray-400">
                    <span class="text-gray-600">{{ highlight }}</span>
                  </li>
                </ul>
              </div>
            </div>

            <div class="mt-10">
              <h2 class="text-sm font-medium text-gray-900">Details</h2>

              <div class="mt-4 space-y-6">
                <p class="text-sm text-gray-600">{{ product.details }}</p>
              </div>
            </div>
             -->
             <button type="submit"
              class="mt-10 flex w-full items-center justify-center rounded-md border border-transparent bg-blue-600 px-8 py-3 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
              Añadir al Carrito</button>
            </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { StarIcon } from '@heroicons/vue/20/solid'
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const productId = route.params.id

const sneaker_API = ref([]);

axios.get(`http://localhost:3000/api/sneakers/${productId}`)
  .then(response => {
    sneaker_API.value = response.data.map(producto => ({
      ...producto,
      href: `/detalle/${producto.id}`,
      sizes: producto.sizes.split(',').map((size, index) => ({
        size: parseInt(size),
        stock: parseInt(producto.stock.split(',')[index])
      })),
    }));
    console.log(sneaker_API.value)
  })
  .catch(error => {
    console.error('Error al obtener los productos más vendidos:', error);
  });
</script>