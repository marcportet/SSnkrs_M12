<template>
  <div class="flex flex-col min-h-screen">
    <Navbar />
    <div class="flex-1 overflow-x-auto flex justify-center">
      <div class="p-1.5 min-w-full">
        <div class="overflow-hidden"><br>
          <div class="flex">
            &nbsp;&nbsp;
            <svg style="margin-top: 10px;" width="20" height="20" enable-background="new 0 0 316 32" id="Glyph" version="1.1" viewBox="0 0 32 32" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M27.414,24.586l-5.077-5.077C23.386,17.928,24,16.035,24,14c0-5.514-4.486-10-10-10S4,8.486,4,14  s4.486,10,10,10c2.035,0,3.928-0.614,5.509-1.663l5.077,5.077c0.78,0.781,2.048,0.781,2.828,0  C28.195,26.633,28.195,25.367,27.414,24.586z M7,14c0-3.86,3.14-7,7-7s7,3.14,7,7s-3.14,7-7,7S7,17.86,7,14z" id="XMLID_223_"/>
          </svg>
          &nbsp;&nbsp;&nbsp;<input
            v-model="searchTerm"
            type="text"
            placeholder="Buscar por nombre"
            class="mb-4 p-2 border rounded"
          />
          </div>
          <table class="min-w-full divide-y divide-gray-200">
            <thead>
              <tr>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Id</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Nombre</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Marca</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Precio</th>
                <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Stock</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <tr v-for="producto in paginatedProductos" :key="producto.id">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ producto.id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ producto.name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ producto.brand }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ producto.price }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ producto.stock }}</td>
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
    const productos = ref([]);
    const currentPage = ref(1);
    const productsPerPage = 12;
    const searchTerm = ref('');

    const fetchProductos = async () => {
      try {
        const response = await axios.get('http://localhost:3000/api/sneakers');
        productos.value = response.data;
      } catch (error) {
        console.error('Error al obtener los productos más vendidos:', error);
      }
    };

    fetchProductos();

    // Filtrar productos en base al término de búsqueda
    const filteredProductos = computed(() => {
      return productos.value.filter(producto =>
        producto.name.toLowerCase().includes(searchTerm.value.toLowerCase())
      );
    });

    // Paginación
    const startIndex = computed(() => (currentPage.value - 1) * productsPerPage);
    const endIndex = computed(() => Math.min(startIndex.value + productsPerPage, filteredProductos.value.length));
    const paginatedProductos = computed(() => filteredProductos.value.slice(startIndex.value, endIndex.value));
    const totalPages = computed(() => Math.ceil(filteredProductos.value.length / productsPerPage));

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
      productos,
      currentPage,
      searchTerm,
      paginatedProductos,
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
