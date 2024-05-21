<template>
    <div class="flex flex-col min-h-screen">
        <Navbar />
        <div class="flex-1 overflow-x-auto flex justify-center">
            <div class="p-1.5 min-w-full">
                <div class="overflow-hidden"><br>
                    <table class="min-w-full divide-y table-auto divide-gray-200 overflow-scroll">
                        <thead>
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Id</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Productos
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Direccion
                                    Envio</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Fecha de
                                    pedido</th>
                                <th scope="col"
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Ver Pedido
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr v-for="comanda in comandes" :key="comanda.id">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ comanda.id
                                    }}</td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">
                                    <table class="min-w-full divide-x table-auto divide-gray-200">
                                        <tbody>
                                            <tr v-for="producto in comanda.productos" :key="producto.id">
                                                <td class="py-3 whitespace-nowrap text-sm font-medium text-gray-800">
                                                    <img :src="producto.image" alt="sneaker image" class="w-15 h-10">
                                                </td>
                                                <td
                                                    class="py-4 inline-block align-baseline whitespace-nowrap text-sm font-medium text-gray-800">
                                                    {{ producto.name }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 inline-block align-baseline whitespace-nowrap text-sm font-medium text-gray-800">
                                                    {{ producto.price }}€
                                                </td>
                                                <td
                                                    class="px-6 py-4 inline-block align-baseline whitespace-nowrap text-sm font-medium text-gray-800">
                                                    Talla: {{ producto.size }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ comanda.dir_envio }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ comanda.fecha_compra }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    <a :href="route('comanda',comanda.id)"
                                        class="w-full bg-blue-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-blue-500">
                                        ver comanda
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Footer />
    </div>
</template>

<script>
import Navbar from '../navbar.vue';
import Footer from '../footer.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';

export default {
    methods: {
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },
    components: {
        Navbar,
        Footer,
        PrimaryButton
    },
    data() {
        return {
            productDetails: [],
            productosprices: 0,
        };
    },
    props: {
        comandes: Object,
    },
    setup() {
        const productDetails = ref([]);
        const productosprices = ref(0);

        const loadProductDetails = async (comandes) => {
            try {
                for (const comanda of comandes) {
                    const productosArray = JSON.parse(comanda.productos);
                    for (const product of productosArray) {
                        const response = await axios.get(`http://localhost:3000/api/sneakers/${product.id_producto}`);
                        const size = product.size;
                        const productWithSize = { ...response.data[0], size };
                        productDetails.value.push(productWithSize);
                        productosprices.value += response.data[0].price;
                    }
                    comanda.productos = productDetails.value;
                    productDetails.value = [];
                }
            } catch (error) {
                console.error('Error al cargar los detalles de los productos:', error);
            }
        };
        return {
            productDetails,
            productosprices,
            loadProductDetails,
        };
    },
    mounted() {
        this.loadProductDetails(this.comandes);
    },
}
</script>

<style scoped>
button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}
</style>