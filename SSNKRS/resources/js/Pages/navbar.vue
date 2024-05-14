<!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/aspect-ratio'),
    ],
  }
  ```
-->
<template>
  <div class="bg-white">
    <!-- Mobile menu -->
    <TransitionRoot as="template" :show="open">
      <Dialog as="div" class="relative z-40 lg:hidden" @close="open = false">
        <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0"
          enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100"
          leave-to="opacity-0">
          <div class="fixed inset-0 bg-black bg-opacity-25" />
        </TransitionChild>
        <div class="ml-4 flex lg:ml-0">
          <a @click="scrollToTop" href="/">
            <span class="sr-only">ssnkrs</span>
            <img class="h-8 w-auto" :src="'/img/logotipo.png'" alt="" />
          </a>
        </div>

        <div class="fixed inset-0 z-40 flex">
          <TransitionChild as="template" enter="transition ease-in-out duration-300 transform"
            enter-from="-translate-x-full" enter-to="translate-x-0"
            leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0"
            leave-to="-translate-x-full">
            <DialogPanel class="relative flex w-full max-w-xs flex-col overflow-y-auto bg-white pb-12 shadow-xl">
              <div class="flex px-4 pb-2 pt-5">
                <button type="button"
                  class="relative -m-2 inline-flex items-center justify-center rounded-md p-2 text-gray-400"
                  @click="open = false">
                  <span class="absolute -inset-0.5" />
                  <span class="sr-only">Close menu</span>
                  <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                </button>
              </div>

              <!-- Links -->
              <TabGroup as="div" class="mt-2">
                <div class="border-b border-gray-200">
                  <TabList class="-mb-px flex space-x-8 px-4">
                    <Tab as="template" v-for="category in navigation.categories" :key="category.name"
                      v-slot="{ selected }">
                      <button
                        :class="[selected ? 'border-blue-500 text-blue-700' : 'border-transparent text-gray-900', 'flex-1 whitespace-nowrap border-b-2 px-1 py-4 text-base font-medium']">{{
                          category.name }}</button>
                    </Tab>
                  </TabList>
                </div>
                <TabPanels as="template">
                  <TabPanel v-for="category in navigation.categories" :key="category.name"
                    class="space-y-10 px-4 pb-8 pt-10">
                    <div class="grid grid-cols-2 gap-x-4">
                      <div v-for="item in category.featured" :key="item.name" class="group relative text-sm">
                        <div
                          class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                          <img :src="item.imageSrc" :alt="item.imageAlt" class="object-cover object-center" />
                        </div>
                        <a @click="scrollToTop" :href="item.href" class="mt-6 block font-medium text-gray-900">
                          <span class="absolute inset-0 z-10" aria-hidden="true" />
                          {{ item.name }}
                        </a>
                      </div>
                    </div>
                    <div v-for="section in category.sections" :key="section.name">
                      <p :id="`${category.id}-${section.id}-heading-mobile`" class="font-medium text-gray-900">{{
                        section.name }}</p>
                      <ul role="list" :aria-labelledby="`${category.id}-${section.id}-heading-mobile`"
                        class="mt-6 flex flex-col space-y-6">
                        <li v-for="item in section.items" :key="item.name" class="flow-root">
                          <a @click="scrollToTop" :href="item.href" class="-m-2 block p-2 text-gray-500">{{
                            item.name }}</a>
                        </li>
                      </ul>
                    </div>
                  </TabPanel>
                </TabPanels>
              </TabGroup>

              <div class="space-y-6 border-t border-gray-200 px-4 py-6">
                <div v-for="page in navigation.pages" :key="page.name" class="flow-root">
                  <a @click="scrollToTop" :href="page.href" class="-m-2 block p-2 font-medium text-gray-900">{{
                    page.name }}</a>
                </div>
                <div v-if="$page.props.auth.user && $page.props.auth.user.id_admin !== null">
                    <a href="/stock" class="-m-2 block p-2 font-medium text-gray-900">Stock</a>
                </div>

              </div>

              <div class="space-y-6 border-t border-gray-200 px-4 py-6" v-if="!$page.props.auth.user">
                <div class="flow-root">
                  <a @click="scrollToTop" href="/login">Iniciar
                    sesión</a>
                </div>
                <div class="flow-root">
                  <a @click="scrollToTop" href="/register">Crear cuenta</a>
                </div>
              </div>
              <div class="space-y-6 border-t border-gray-200 px-4 py-6" v-if="$page.props.auth.user">
                <div class="flow-root">
                  <Link @click="scrollToTop" :href="route('profile.edit')">Perfil</Link>
                </div>
                <div class="flow-root">
                  <Link :href="route('logout')" @click="show = true" method="POST" as="button">Cerrar Sesión</Link>
                </div>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </Dialog>
    </TransitionRoot>

    <header class="relative bg-white">
      <p
        class="flex m-0 h-6 items-center justify-center bg-blue-500 px-4 text-sm font-medium text-white sm:px-6 lg:px-8">
      </p>

      <nav aria-label="Top" class="mx-auto  px-4 sm:px-6 lg:px-8">
        <div class="border-b border-gray-200">
          <div class="flex h-16 items-center">
            <button type="button" class="relative rounded-md bg-white p-2 text-gray-400 lg:hidden" @click="open = true">
              <span class="absolute -inset-0.5" />
              <span class="sr-only">Open menu</span>
              <Bars3Icon class="h-6 w-6" aria-hidden="true" />
            </button>

            <!-- Logo -->
            <div class="ml-4 flex lg:ml-0">
              <a @click="scrollToTop" href="/">
                <span class="sr-only">ssnkrs</span>
                <img class="h-8 w-auto" :src="'/img/logotipo.png'" alt="" />
              </a>
            </div>

            <!-- Flyout menus -->
            <PopoverGroup class="hidden lg:ml-8 lg:block lg:self-stretch" style="z-index: 3;">
              <div class="flex h-full space-x-8">
                <Popover v-for="category in navigation.categories" :key="category.name" class="flex" :placement="'top'">
                  <!-- v-slot="{ open }" -->
                  <div class="relative flex">
                    <PopoverButton
                      :class="[open ? 'border-blue-500 text-blue-700' : 'border-transparent text-gray-900', 'relative z-10 -mb-px flex items-center border-b-2 pt-px text-sm font-medium transition-colors duration-200 ease-out']">
                      {{ category.name }}</PopoverButton>
                  </div>

                  <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0"
                    enter-to-class="opacity-100" leave-active-class="transition ease-in duration-150"
                    leave-from-class="opacity-100" leave-to-class="opacity-0">
                    <PopoverPanel class="absolute inset-x-0 top-full text-sm text-gray-500">
                      <!-- Presentational element used to render the bottom shadow, if we put the shadow on the actual panel it pokes out the top, so we use this shorter element to hide the top of the shadow -->
                      <div class="absolute inset-0 top-1/2 bg-white shadow" aria-hidden="true" />

                      <div class="relative bg-white">
                        <div class="mx-auto px-8">
                          <div class="grid grid-cols-2 gap-x-8 gap-y-10 py-16">
                            <div class="col-start-2 grid grid-cols-2 gap-x-8">
                              <div v-for="item in category.featured" :key="item.name"
                                class="group relative text-base sm:text-sm">
                                <div
                                  class="aspect-h-1 aspect-w-1 overflow-hidden rounded-lg bg-gray-100 group-hover:opacity-75">
                                  <img :src="item.imageSrc" :alt="item.imageAlt" class="object-cover object-center" />
                                </div>
                                <a @click="scrollToTop" :href="item.href" class="mt-6 block font-medium text-gray-900">
                                  <span class="absolute inset-0 z-10" aria-hidden="true" />
                                  {{ item.name }}
                                </a>
                              </div>
                            </div>
                            <div class="row-start-1 grid grid-cols-3 gap-x-8 gap-y-10 text-sm">
                              <div v-for="section in category.sections" :key="section.name">
                                <p :id="`${section.name}-heading`" class="font-medium text-gray-900">{{ section.name }}
                                </p>
                                <ul role="list" :aria-labelledby="`${section.name}-heading`"
                                  class="mt-6 space-y-6 sm:mt-4 sm:space-y-4">
                                  <li v-for="item in section.items" :key="item.name" class="flex">
                                    <a @click="scrollToTop" :href="item.href" class="hover:text-gray-800">{{
                                      item.name }}</a>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </PopoverPanel>
                  </transition>
                </Popover>

                <a @click="scrollToTop" v-for="page in navigation.pages" :key="page.name" :href="page.href"
                  class="flex items-center text-sm font-medium text-gray-900">{{ page.name
                  }}
                </a>
                <div v-if="$page.props.auth.user && $page.props.auth.user.id_admin !== null" class="separador"></div>
                <a  v-if="$page.props.auth.user && $page.props.auth.user.id_admin !== null" href="/stock" class="flex items-center text-sm font-medium text-gray-900">Stock</a>
              
              </div>
            </PopoverGroup>

            <div class="ml-auto flex items-center">
              <div class="hidden lg:flex lg:flex-1 lg:items-center lg:justify-end lg:space-x-6"
                v-if="!$page.props.auth.user">
                <a @click="scrollToTop" href="/login">Iniciar
                  Sessión</a>
                <span class="h-6 w-px bg-gray-200" aria-hidden="true"></span>
                <a @click="scrollToTop" href="/register">Crear cuenta</a>

              </div>
              <Dropdown class="hidden lg:block" align="right" width="48" v-if="$page.props.auth.user">
                <template #trigger>
                  <span class="inline-flex rounded-md">
                    <button type="button"
                      class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-800 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-4 h-4 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                      </svg>

                      {{ $page.props.auth.user.name }}

                      <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd" />
                      </svg>
                    </button>
                  </span>
                </template>

                <template #content>
                  <DropdownLink :href="route('profile.edit')"> Perfil </DropdownLink>
                  <DropdownLink :href="route('logout')" @click="show = true" method="post" as="button">
                    Cerrar Sesión
                  </DropdownLink>
                </template>
              </Dropdown>

              <!-- Cart -->
              <div class="ml-4 flow-root lg:ml-6">
                <a @click="scrollToTop" v-if="$page.props.auth.client"
                  :href="route('carrito.show', $page.props.auth.client.id_carrito)"
                  class="group -m-2 flex items-center p-2">
                  <ShoppingBagIcon class="h-6 w-6 flex-shrink-0 text-gray-400 group-hover:text-gray-500"
                    aria-hidden="true" />
                </a>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </header>
    <!-- Alert Cerrar Sesión -->
    <div aria-live="assertive"
      class="position-absolute inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start mt-20"
      style="z-index: 3;">
      <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
        <transition enter-active-class="transform ease-out duration-300 transition"
          enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
          enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
          leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100"
          leave-to-class="opacity-0">
          <div v-if="show"
            class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="p-4">
              <div class="flex items-start">
                <div class="flex-shrink-0">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="green" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                  </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                  <p class="text-sm font-medium text-gray-900">¡Has cerrado sesión con exito!</p>
                  <p class="mt-1 text-sm text-gray-500">Vuelve a iniciar sesión para acceder a tu cuenta.</p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                  <button @click="show = false"
                    class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <span class="sr-only">Close</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </transition>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import {
  Dialog,
  DialogPanel,
  Popover,
  PopoverButton,
  PopoverGroup,
  PopoverPanel,
  Tab,
  TabGroup,
  TabList,
  TabPanel,
  TabPanels,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import { Bars3Icon, MagnifyingGlassIcon, ShoppingBagIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ user: Object })

const show = ref(false)

const navigation = {
  categories: [
    {
      id: 'sneakers',
      name: 'Sneakers',
      featured: [
        {
          name: '',
          href: '/',
          imageSrc: '/img/travis-jordan-low.png',
          imageAlt: 'travis-jordan-low.png',
        },
        {
          name: '',
          href: '/',
          imageSrc: '/img/sb-dunk-april.png',
          imageAlt: 'sb-dunk-april.png',
        },
      ],
      sections: [
        {
          id: 'brands',
          name: 'Brands',
          items: [
            { name: 'Adidas', href: '/catalogo/ADIDAS' },
            { name: 'Air Jordan', href: '/catalogo/JORDAN' },
            { name: 'New Balance', href: '/catalogo/NEW BALANCE' },
            { name: 'Nike', href: '/catalogo/NIKE' },
            { name: 'Yeezy', href: '/catalogo/YEEZY' },
          ],
        },
        {
          id: 'others',
          name: 'Otras Paginas',
          items: [
            { name: 'Equipo', href: '/equipo' },
            { name: 'FQs', href: '/fqs' },
          ],
        }
      ],
    },
  ],
  pages: [
    { name: 'Catálogo', href: '/catalogo' },
    { name: 'Contacto', href: '/contacto' },
  ],
}

const open = ref(false)
</script>

<script>
export default {
  data() {
    return {
      isOpen: false
    };
  },
  methods: {
    scrollToTop() {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    toggleMenu() {
      this.isOpen = !this.isOpen;
    },
    isActive(route) {
      return this.$route.path === route;
    }
  }
}
</script>