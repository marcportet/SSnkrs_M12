<template>
    <div class="flex flex-col min-h-screen">
      <Navbar />
      <div class="flex-1 overflow-x-auto flex justify-center">
        <div class="p-1.5 min-w-full">
          <div class="overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Id</th>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Nombre</th>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Email</th>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Permisos</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="user in paginatedUsuario" :key="user.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ user.id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ user.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ user.emauil }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800"></td>
                </tr>
              </tbody>
            </table>
            <div class="flex justify-center mt-8">
              <button @click="goToPage(1)" :disabled="currentPage === 1" class="px-3 py-1 mr-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                </svg>
              </button>
              <button @click="previousPage" :disabled="currentPage === 1" class="px-3 py-1 mr-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
              </button>
              <div v-for="page in visiblePages" :key="page">
                <button @click="goToPage(page)" :class="['px-3 py-1 mx-1 rounded-md border border-gray-300 bg-white text-sm font-medium', { 'bg-blue-600 text-gray-800': page === currentPage }]" class="text-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                  {{ page }}
                </button>
              </div>
              <button @click="nextPage" :disabled="currentPage === totalPages" class="px-3 py-1 ml-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
              </button>
              <button @click="goToPage(totalPages)" :disabled="currentPage === totalPages" class="px-3 py-1 ml-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>
      <Footer />
    </div>
  </template>
  
  <script>
  import Navbar from '../navbar.vue';
  import Footer from '../footer.vue';
  import { ref, computed } from 'vue';
  import axios from 'axios';
  
  
  export default {
    components: {
      Navbar,
      Footer,
    },
    setup() {
      const currentPage = ref(1);
      const usuariosPerPage = 12;
  
      //Paginacion
      
      const startIndex = computed(() => (currentPage.value - 1) * usuariosPerPage);
      const endIndex = computed(() => Math.min(startIndex.value + usuariosPerPage, user.value.length));
      const paginatedUsuario = computed(() => user.value.slice(startIndex.value, endIndex.value));
      const totalPages = computed(() => Math.ceil(user.value.length / usuariosPerPage));
  
      const previousPage = () => {
        if (currentPage.value > 1) {
          currentPage.value--;
        }
      };
  
      const nextPage = () => {
        if (currentPage.value < totalPages.value) {
          currentPage.value++;
        }
      };
  
      const visiblePages = computed(() => {
        const totalVisiblePages = 5;
        const halfVisiblePages = Math.floor(totalVisiblePages / 2);
        const firstVisiblePage = Math.max(1, currentPage.value - halfVisiblePages);
        const lastVisiblePage = Math.min(totalPages.value, firstVisiblePage + totalVisiblePages - 1);
        const visiblePagesArray = [];
  
        for (let page = firstVisiblePage; page <= lastVisiblePage; page++) {
          visiblePagesArray.push(page);
        }
  
        return visiblePagesArray;
      });
  
      const goToPage = (page) => {
        currentPage.value = page;
      };
  
      return {
        user,
        currentPage,
        paginatedUsuario,
        totalPages,
        previousPage,
        nextPage,
        visiblePages,
        goToPage,
      };
    },
  };
  </script>
  
  <style scoped>
  button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
  </style>
  