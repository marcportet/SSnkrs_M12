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
                <img :src="product.image" :alt="product.name" :href="'/detalle/' + product.id"
                  class="w-24 h-24 rounded-md object-center sm:w-48 sm:h-36" />
              </div>

              <div class="ml-4 flex-1 flex flex-col justify-between sm:ml-6">
                <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                  <div>
                    <div class="flex justify-between">
                      <h3 class="text-sm">
                        <a :href="'/detalle/' + product.id" class="font-medium text-gray-700 hover:text-gray-800">
                          {{ product.name }}
                        </a>
                      </h3>
                    </div>
                    <div class="mt-1 flex text-sm">
                      <p class="text-gray-500">
                        {{ product.brand }}
                      </p>
                      <p v-if="product.size" class="ml-4 pl-4 border-l border-gray-200 text-gray-500">
                        {{ product.size }}
                      </p>
                    </div>
                    <p class="mt-1 text-sm font-medium text-gray-900">{{ product.price }}€</p>
                  </div>

                  <div class="mt-4 sm:mt-0 sm:pr-9">
                    <label :for="`quantity-${index}`" class="sr-only">Quantity, {{ product.name }}</label>
                    <div class="absolute top-0 right-0">
                      <Link @click="deleteItem()" as="button" type="button" method="delete"
                        class="-m-2 p-2 inline-flex text-gray-400 hover:text-gray-500"
                        :href="'/carrito/' + carrito.id + '/' + product.id + '/' + product.size">
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
          <form @submit.prevent="form.patch(route('carrito.submit'))">
            <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Dirección de envio</h2>
            <div class="grid grid-cols-2 gap-4 m-2">
              <div>
                <InputLabel for="poblacion" value="Población" />

                <TextInput placeholder="ej. Barcelona" id="poblacion" type="text" class="mt-1 block w-full text-sm"
                  v-model="form.poblacion" autofocus autocomplete="poblacion" />

                <InputError class="mt-2" :message="form.errors.poblacion" />
              </div>
              <div>
                <InputLabel for="cpostal" value="Código Postal" />

                <input placeholder="ej. 08001" type="text" name="cpostal" id="cpostal"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                  autocomplete="cpostal" v-model="form.cpostal" @input="filterNonNumeric" />

                <InputError class="mt-2" :message="form.errors.cpostal" />
              </div>
            </div>
            <div class="m-2">
              <InputLabel for="calle" value="Dirección de la vivienda" />

              <TextInput placeholder="ej. C/ d'Aragó, 401, 2" id="calle" type="text" class="mt-1 block w-full text-sm"
                v-model="form.calle" autofocus autocomplete="calle" />

              <InputError class="mt-2" :message="form.errors.calle" />
            </div>
            <div class="m-2">
              <InputLabel for="info_adicional" value="Informacón adicional de envio" />

              <textarea placeholder="Añade instrucciones e información adicional para el envio." name="info_adicional"
                id="info_adicional" cols="30" rows="10" autocomplete="info_adicional" v-model="form.info_adicional"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm resize-none"></textarea>

              <InputError class="mt-2" :message="form.errors.info_adicional" />
            </div>

            <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Resumen del pedido</h2>

            <dl class="mt-6 space-y-4">
              <div class="m-2 flex items-center justify-between">
                <dt class="text-sm text-gray-600">Subtotal</dt>
                <dd class="text-sm font-medium text-gray-900">{{ productosprices ? productosprices : 0 }}€</dd>
              </div>
              <div class="m-2 border-t border-gray-200 pt-4 flex items-center justify-between">
                <dt class="flex items-center text-sm text-gray-600">
                  <span>Coste de envio estimado</span>
                </dt>
                <dd class="text-sm font-medium text-gray-900">{{ productosprices ? productosprices * 0.05 : 0 }}€</dd>
              </div>
              <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                <dt class="text-base font-medium text-gray-900">Total del pedido</dt>
                <dd class="text-base font-medium text-gray-900">{{ productosprices ? (productosprices) +
                  (productosprices * 0.05) : 0 }}€</dd>
              </div>
            </dl>

            <div class="mt-6">
              <PrimaryButton :disabled="form.processing" v-if="$page.props.auth.client"
                class="w-full bg-blue-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-blue-500">
                Realizar pedido
              </PrimaryButton>
            </div>
          </form>
        </section>
      </form>
    </div>
    <Footer />
  </div>
</template>

<script>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { usePage, Link, useForm } from '@inertiajs/vue3';

import Navbar from '../navbar.vue';
import Footer from '../footer.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

export default {
  data() {
    return {
      productDetails: [],
      productosprices: 0,
    };
  },
  props: {
    carrito: Object,
  },
  setup() {
    const page = usePage();
    const client = page.props.auth.client;

    const form = useForm({
      calle: client ? client.calle : '',
      poblacion: client ? client.poblacion : '',
      cpostal: client ? client.cpostal : '',
      info_adicional: client ? client.info_adicional : '',
    });

    const productDetails = ref([]);
    const productosprices = ref(0);

    const loadProductDetails = async (carrito) => {
      try {
        const productosArray = JSON.parse(carrito.productos);
        for (const product of productosArray) {
          const response = await axios.get(`http://localhost:3000/api/sneakers/${product.id_producto}`);
          const size = product.size;
          const productWithSize = { ...response.data[0], size };
          productDetails.value.push(productWithSize);
          productosprices.value += response.data[0].price;
        }
      } catch (error) {
        console.error('Error al cargar los detalles de los productos:', error);
      }
    };

    return {
      productDetails,
      productosprices,
      form,
      loadProductDetails,
      deleteItem() {
        setTimeout(() => {
          window.location.reload();
        }, 200);
      },
      filterNonNumeric(event) {
        const input = event.target.value;
        form.cpostal = input.replace(/\D/g, ''); // Solo deja los dígitos
      },
    };
  },
  components: {
    Navbar,
    Footer,
    Link,
    InputError,
    InputLabel,
    PrimaryButton,
    TextInput,
  },
  mounted() {
    this.loadProductDetails(this.carrito);
  },
};
</script>
