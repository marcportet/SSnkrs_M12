<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<template>
  <div class="bg-white">
    <div>
      <!-- Mobile filter dialog -->
      <TransitionRoot as="template" :show="mobileFiltersOpen">
        <Dialog as="div" class="relative z-40 lg:hidden" @close="mobileFiltersOpen = false">
          <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-black bg-opacity-25" />
          </TransitionChild>

          <div class="fixed inset-0 z-40 flex">
            <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="translate-x-full">
              <DialogPanel class="relative ml-auto flex h-full w-full flex-col overflow-y-auto bg-white py-4 pb-12 shadow-xl">
                <div class="flex items-center justify-between px-4">
                  <h2 class="text-lg font-medium text-gray-900">Filters</h2>
                  <button type="button" class="-mr-2 flex h-10 w-10 items-center justify-center rounded-md bg-white p-2 text-gray-400" @click="mobileFiltersOpen = false">
                    <span class="sr-only">Close menu</span>
                    <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                  </button>
                </div>

                <!-- Filters -->
                <form class="mt-4 border-t border-gray-200">
                  <h3 class="sr-only">Categories</h3>
                  <ul role="list" class="px-2 py-3 font-medium text-gray-900">
                    <li v-for="category in subCategories" :key="category.name">
                      <a :href="category.href" class="block px-2 py-3">{{ category.name }}</a>
                    </li>
                  </ul>

                  <Disclosure as="div" v-for="section in filters" :key="section.id" class="border-t border-gray-200 px-4 py-6" v-slot="{ open }">
                    <h3 class="-mx-2 -my-3 flow-root">
                      <DisclosureButton class="flex w-full items-center justify-between bg-white px-2 py-3 text-gray-400 hover:text-gray-500">
                        <span class="font-medium text-gray-900">{{ section.name }}</span>
                        <span class="ml-6 flex items-center">
                          <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                          <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                        </span>
                      </DisclosureButton>
                    </h3>
                    <DisclosurePanel class="pt-6">
                      <div class="space-y-6">
                        <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex items-center">
                          <input :id="`filter-mobile-${section.id}-${optionIdx}`" :name="`${section.id}[]`" :value="option.value" type="checkbox" :checked="option.checked" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                          <label :for="`filter-mobile-${section.id}-${optionIdx}`" class="ml-3 min-w-0 flex-1 text-gray-500">{{ option.label }}</label>
                        </div>
                      </div>
                    </DisclosurePanel>
                  </Disclosure>
                </form>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>

      <main class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-baseline justify-between border-b border-gray-200 pb-6 pt-24">
          <h1 class="text-4xl font-bold tracking-tight text-gray-900"></h1>

          <div class="flex items-center">
            <Menu as="div" class="relative inline-block text-left">
              <div>
                <MenuButton class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900">
                  Sort
                  <ChevronDownIcon class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" aria-hidden="true" />
                </MenuButton>
              </div>

               <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                <div>
                  <MenuItems class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none">
                    <div class="py-1">
                      <MenuItem v-for="(option, index) in sortOptions" :key="option.name" v-slot="{ active }">
                        <a :href="option.href" @click.prevent="updateSortOption(index); sortByPrice()"
                          :class="[option.current ? 'font-medium text-gray-900' : 'text-gray-500', active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm']">
                          {{ option.name }}
                        </a>
                      </MenuItem>
                    </div>
                  </MenuItems>
                </div>
              </transition>

            </Menu>

            <button type="button" class="-m-2 ml-5 p-2 text-gray-400 hover:text-gray-500 sm:ml-7">
              <span class="sr-only">View grid</span>
              <Squares2X2Icon class="h-5 w-5" aria-hidden="true" />
            </button>
            <button type="button" class="-m-2 ml-4 p-2 text-gray-400 hover:text-gray-500 sm:ml-6 lg:hidden" @click="mobileFiltersOpen = true">
              <span class="sr-only">Filters</span>
              <FunnelIcon class="h-5 w-5" aria-hidden="true" />
            </button>
          </div>
        </div>

        <section aria-labelledby="products-heading" class="pb-24 pt-6">
          <h2 id="products-heading" class="sr-only">Products</h2>

          <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
            <!-- Filters -->
            <form class="hidden lg:block">
              <h3 class="sr-only">Categories</h3>
              <ul role="list" class="space-y-4 border-b border-gray-200 pb-6 text-sm font-medium text-gray-900">
                <li v-for="category in subCategories" :key="category.name">
                  <a :href="category.href">{{ category.name }}</a>
                </li>
              </ul>

              <Disclosure as="div" v-for="section in filters" :key="section.id" class="border-b border-gray-200 py-6" v-slot="{ open }">
                <h3 class="-my-3 flow-root">
                  <DisclosureButton class="flex w-full items-center justify-between bg-white py-3 text-sm text-gray-400 hover:text-gray-500">
                    <span class="font-medium text-gray-900">{{ section.name }}</span>
                    <span class="ml-6 flex items-center">
                      <PlusIcon v-if="!open" class="h-5 w-5" aria-hidden="true" />
                      <MinusIcon v-else class="h-5 w-5" aria-hidden="true" />
                    </span>
                  </DisclosureButton>
                </h3>
                <DisclosurePanel class="pt-6">
                  <div class="space-y-4">
                    <div v-for="(option, optionIdx) in section.options" :key="option.value" class="flex items-center">
                      <input :id="`filter-${section.id}-${optionIdx}`" :name="`${section.id}[]`" :value="option.value" type="checkbox" :checked="option.checked" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                      <label :for="`filter-${section.id}-${optionIdx}`" class="ml-3 text-sm text-gray-600">{{ option.label }}</label>
                    </div>
                  </div>
                </DisclosurePanel>
              </Disclosure>
            </form>

            <!-- Product grid -->
            <div class="lg:col-span-3">
            <div class="pt-5 pb-3 px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                <div v-for="producto in allproductos" :key="producto.id" class="group relative">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                        <img :src="producto.image" :alt="producto.name"
                            class="w-full object-cover object-center lg:w-full" style="margin-top:20%; height:60%;" />
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
              <!-- Your content -->
            </div>
          </div>
        </section>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios';
import {
  Dialog,
  DialogPanel,
  Disclosure,
  DisclosureButton,
  DisclosurePanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { ChevronDownIcon, FunnelIcon, MinusIcon, PlusIcon, Squares2X2Icon } from '@heroicons/vue/20/solid'

const allproductos = ref([]);

const sortOptions = ref([
  { name: 'Precio: Bajo a Alto', href: '#', current: true },
  { name: 'Precio: Alto a Bajo', href: '#', current: false },
]);

const subCategories = [
  { name: 'Limpiar', href: '#' },
]
const filters = [
  {
    id: 'brand',
    name: 'Brand',
    options: [
      { value: 'adidas', label: 'Adidas', checked: false },
      { value: 'airjordan', label: 'Air Jordan', checked: false },
      { value: 'newbalance', label: 'New Balance', checked: false },
      { value: 'nike', label: 'Nike', checked: true },
      { value: 'yeezy', label: 'Yeezy', checked: false },
    ],
  },
  {
    id: 'tipo',
    name: 'Tipo',
    options: [
      { value: 'high', label: 'High', checked: false },
      { value: 'mid', label: 'Mid', checked: false },
      { value: 'low', label: 'Low', checked: true },
    ],
  },
  {
    id: 'size',
    name: 'Size',
    options: [
      { value: '35', label: '35', checked: false },
      { value: '36', label: '36', checked: false },
      { value: '37', label: '37', checked: false },
      { value: '38', label: '38', checked: false },
      { value: '39', label: '39', checked: false },
      { value: '40', label: '40', checked: true },
      { value: '41', label: '41', checked: true },
      { value: '42', label: '42', checked: false },
      { value: '43', label: '43', checked: false },
      { value: '44', label: '44', checked: false },
      { value: '45', label: '45', checked: false },
      { value: '46', label: '46', checked: false },
      { value: '47', label: '47', checked: false },
    ],
  },
]
// Realizar solicitudes a la API y actualizar los arrays de productos
axios.get('http://localhost:3000/api/sneakers')
    .then(response => {
        allproductos.value = response.data.map(producto => ({
            ...producto,
            href: `/detalle/${producto.id}`,
        }));
    })
    .catch(error => {
        console.error('Error al obtener los productos nuevos:', error);
    });

const mobileFiltersOpen = ref(false)


// Metode per canviar el estat de current de les opcions de sort
const updateSortOption = (index) => {
  sortOptions.value.forEach((option, i) => {
    option.current = i === index;
  });
};

//Metode per ordenar els productes segons la opcio selecionada
const sortByPrice = () => {
  const selectedOption = sortOptions.value.find(option => option.current);
  if (selectedOption) {
    if (selectedOption.name === 'Precio: Bajo a Alto') {
      allproductos.value.sort((a, b) => a.price - b.price);
    } else if (selectedOption.name === 'Precio: Alto a Bajo') {
      allproductos.value.sort((a, b) => b.price - a.price);
    }
  }
};
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