<template>
  <div class="bg-white">
    <Navbar />
    <div class="max-w-2xl mx-auto pt-16 pb-24 px-4 sm:px-6 lg:max-w-7xl lg:px-8">
      <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Carrito de productos</h1>
      <form class="mt-12 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16">
        <section aria-labelledby="cart-heading" class="lg:col-span-7">
          <h2 id="cart-heading" class="sr-only">Items in your shopping cart</h2>
          <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
            <li v-for="(product, index) in productDetails" :key="index" class="flex py-6 sm:py-10">
              <div class="flex-shrink-0">
                <img :src="product[0].image" :alt="product[0].name" :href="'/detalle/' + product[0].id"
                  class="w-24 h-24 rounded-md object-center object-cover sm:w-48 sm:h-48" />
              </div>

              <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                  <div>
                    <div class="flex justify-between">
                      <h3 class="text-sm">
                        <a :href="'/detalle/' + product[0].id" class="font-medium text-gray-700 hover:text-gray-800">
                          {{ product[0].name }}
                        </a>
                      </h3>
                    </div>
                    <div class="mt-1 flex text-sm">
                      <p class="text-gray-500">
                        {{ product[0].brand }}
                      </p>
                      <p v-if="product" class="ml-4 pl-4 border-l border-gray-200 text-gray-500">
                        {{ product.size }}
                      </p>
                    </div>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ product[0].price }}€</p>
                  </div>

                  <div class="mt-4 sm:mt-0 sm:pr-9">
                    <label :for="`quantity-${index}`" class="sr-only">Quantity, {{ product[0].name }}</label>
                    <div class="absolute top-0 right-0">
                      <Link @click="deleteItem()" as="button" type="button" method="delete"
                        class="-m-2 p-2 inline-flex text-gray-400 hover:text-gray-500"
                        :href="'/carrito/' + carrito.id + '/' + product[0].id + '/' + product.size">
                      <span class="sr-only">Eliminar</span>
                      <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M10 12L14 16M14 12L10 16M18 6L17.1991 18.0129C17.129 19.065 17.0939 19.5911 16.8667 19.99C16.6666 20.3412 16.3648 20.6235 16.0011 20.7998C15.588 21 15.0607 21 14.0062 21H9.99377C8.93927 21 8.41202 21 7.99889 20.7998C7.63517 20.6235 7.33339 20.3412 7.13332 19.99C6.90607 19.5911 6.871 19.065 6.80086 18.0129L6 6M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6"
                          stroke="#7a7a7a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                      </svg>
                      </Link>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </section>

        <!-- Order summary -->
        <section aria-labelledby="summary-heading"
          class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
          <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Resumen del pedido</h2>

          <dl class="mt-6 space-y-4">
            <div class="flex items-center justify-between">
              <dt class="text-sm text-gray-600">Subtotal</dt>
              <dd class="text-sm font-medium text-gray-900">{{ productosprices }}€</dd>
            </div>
            <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
              <dt class="flex items-center text-sm text-gray-600">
                <span>Coste de envio estimado</span>
              </dt>
              <dd class="text-sm font-medium text-gray-900">{{ productosprices * 0.05 }}€</dd>
            </div>
            <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
              <dt class="text-base font-medium text-gray-900">Total del pedido</dt>
              <dd class="text-base font-medium text-gray-900">{{ (productosprices) + (productosprices * 0.05) }}€</dd>
            </div>
          </dl>

          <div class="mt-6">
            <button type="submit"
              class="w-full bg-indigo-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-indigo-500">Checkout</button>
          </div>
        </section>
      </form>
    </div>
    <Footer />
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';

import Navbar from '../navbar.vue';
import Footer from '../footer.vue';
import { Link } from '@inertiajs/vue3'

export default {
  data() {
    return {
      productDetails: [],
    };
  },
  props: {
    carrito: Object,
  },
  setup(props) {
    const productDetails = ref([]);
    const productosprices = ref(0);

    const loadProductDetails = async () => {
      try {
        const productosArray = JSON.parse(props.carrito.productos);

        for (const product of productosArray) {
          const response = await axios.get(`http://localhost:3000/api/sneakers/${product.id_producto}`);
          const size = product.size;
          const productWithSize = { ...response.data, size };
          productDetails.value.push(productWithSize);
          productosprices.value += response.data[0].price;
        }
      } catch (error) {
        console.error('Error al cargar los detalles de los productos:', error);
      }
    };

    onMounted(() => {
      loadProductDetails();
    });

    return {
      productDetails,
      productosprices,
    };
  },
  components: {
    Navbar,
    Footer,
    Link
  },
  methods: {
    deleteItem() {
      setTimeout(() => {
        window.location.reload();
      }, 200); // 5000 milisegundos = 5 segundos
    }
  },
};
</script>
