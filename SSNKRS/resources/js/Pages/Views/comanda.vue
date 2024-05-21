<template>

    <body class="overflow-y-hidden light:bg-gray-900">
        <Navbar />
        <div class="py-14 px-4 md:px-6 2xl:px-20 2xl:container 2xl:mx-auto">
            <div class="flex justify-start item-start space-y-2 flex-col">
                <h1 class="text-3xl light:text-black lg:text-4xl font-semibold leading-7 lg:leading-9 text-black">
                    Comanda #{{ comanda.id }}</h1>
            </div>
            <div
                class="mt-10 flex flex-col xl:flex-row jusitfy-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0">
                <div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8 ">
                    <div
                        class="flex flex-col justify-start items-start bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full border-4 border-blue-500">
                        <p
                            class="text-lg md:text-xl dark:text-black font-semibold leading-6 xl:leading-5 text-gray-800">
                            Carrito</p>

                        <div v-for="(product, index) in productDetails" :key="index" class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                            <div 
                            class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                            <div class="pb-4 md:pb-8 w-full md:w-40">
                                <img class="w-full hidden md:block" :src="product.image"
                                    alt="dress" />
                            </div>
                            <div
                                class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                                <div class="pb-4 md:pb-8 w-full md:w-40">
                                    <img class="w-full hidden md:block" :src="product.image" alt="dress" />
                                </div>
                                <div
                                    class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0">
                                    <div class="w-full flex flex-col justify-start items-start space-y-8">
                                        <h3
                                            class="text-xl dark:text-black xl:text-2xl font-semibold leading-6 text-gray-800">
                                            {{ product.name }}</h3>
                                        <div class="flex justify-start items-start flex-col space-y-2">
                                            <p class="text-sm dark:text-black leading-none text-gray-800"><span
                                                    class="dark:text-gray-400 text-black">Size: </span>
                                                {{ product.size }}</p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between space-x-8 items-start w-full">
                                        <p
                                            class="text-base dark:text-black xl:text-lg font-semibold leading-6 text-gray-800">
                                            {{ product.price }} €</p>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-8 items-start w-full">
                                    <p
                                        class="text-base dark:text-black xl:text-lg font-semibold leading-6 text-gray-800">
                                        {{ product.price }} €</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div
                        class="flex justify-center flex-col md:flex-row flex-col items-stretch w-full space-y-4 md:space-y-0 md:space-x-6 xl:space-x-8 border-4 border-blue-500">
                        <div class="flex flex-col px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-5 space-y-6">
                            <h3 class="text-xl dark:text-black font-semibold leading-5 text-gray-800">Resumen del pedido
                            </h3>
                            <div
                                class="flex justify-center items-center w-full space-y-4 flex-col border-gray-200 border-b pb-4">
                                <div class="flex justify-between w-full">
                                    <p class="text-base dark:text-black leading-4 text-gray-800">Subtotal</p>
                                    <p class="text-base dark:text-black leading-4 text-gray-600">{{ productosprices ?
                                        productosprices : 0 }}€</p>
                                </div>
                                <div class="flex justify-between items-center w-full">
                                    <p class="text-base dark:text-black leading-4 text-gray-800">Coste de envio estimado
                                    </p>
                                    <p class="text-base dark:text-black leading-4 text-gray-600">{{ productosprices ?
                                        productosprices * 0.05 : 0 }}€</p>
                                </div>
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <p class="text-base dark:text-black font-semibold leading-4 text-gray-800">Total</p>
                                <p class="text-base dark:text-black font-semibold leading-4 text-gray-600">{{
                                    productosprices ? (productosprices) +
                                    (productosprices * 0.05) : 0 }}€</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div
                    class="border-4 border-blue-500 w-full xl:w-96 flex justify-between items-center md:items-start px-4 py-6 md:p-6 xl:p-8 flex-col">
                    <h3 class="text-xl dark:text-black font-semibold leading-5 text-gray-800">Datos del Usuario</h3>
                    <div
                        class="flex flex-col md:flex-row xl:flex-col justify-start items-stretch h-full w-full md:space-x-6 lg:space-x-8 xl:space-x-0">
                        <div class="flex flex-col justify-start items-start flex-shrink-0">
                            <div
                                class="flex justify-center w-full md:justify-start items-center space-x-4 py-8 border-b border-gray-200">
                                <div class="flex justify-start items-start flex-col space-y-2">
                                    <p
                                        class="text-base dark:text-black font-semibold leading-4 text-left text-gray-800">
                                        Nombre:&nbsp;&nbsp;{{ $page.props.auth.user.name }}</p>
                                </div>
                            </div>
                            <div
                                class="flex justify-center text-gray-800 dark:text-black md:justify-start items-center space-x-4 py-4 border-b border-gray-200 w-full">
                                <svg id="Capa_1"  style=" height: 40px; enable-background:new 0 0 20 20;" version="1.1" viewBox="0 0 60 60" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M0,8.5v2.291v38.418V51.5h60v-2.291V10.791V8.5H0z M36.625,30.564l-5.446,5.472c-0.662,0.615-1.698,0.614-2.332,0.026  l-5.473-5.498l0.048-0.047L3.647,10.5h52.719L36.577,30.518L36.625,30.564z M20.524,30.533L2,48.355V11.923L20.524,30.533z   M21.934,31.95l5.523,5.549c0.709,0.661,1.619,0.993,2.533,0.993c0.923,0,1.85-0.339,2.581-1.02l5.496-5.522L56.304,49.5H3.686  L21.934,31.95z M39.477,30.534L58,11.922v36.433L39.477,30.534z"/></svg>
                                <p class="cursor-pointer text-sm leading-5 "> {{ $page.props.auth.user.email }}</p>
                            </div>
                        </div>
                        <div class="flex justify-between xl:h-full items-stretch w-full flex-col mt-6 md:mt-0">
                            <div
                                class="flex justify-center md:justify-start xl:flex-col flex-col md:space-x-6 lg:space-x-8 xl:space-x-0 space-y-4 xl:space-y-12 md:space-y-0 md:flex-row items-center md:items-start">
                                <div
                                    class="flex justify-center md:justify-start items-center md:items-start flex-col space-y-4 xl:mt-8">
                                    <p
                                        class="text-base dark:text-black font-semibold leading-4 text-center md:text-left text-gray-800">
                                        Datos de envio</p>
                                    <p
                                        class="w-48 lg:w-full dark:text-black xl:w-48 text-center md:text-left text-sm leading-5 text-gray-600">
                                        {{ comanda.dir_envio}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <Footer />
    </body>
</template>

<script>
import Navbar from '../navbar.vue';
import Footer from '../footer.vue';
import { ref } from 'vue';

export default {
    methods: {
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    },
    components: {
        Navbar,
        Footer
    },
    data() {
        return {
            productDetails: [],
            productosprices: 0,
        };
    },
    props: {
        comanda: Object,
    }, 
    setup() {
        const productDetails = ref([]);
        const productosprices = ref(0);

        const loadProductDetails = async (comanda) => {
            try {
                const productosArray = JSON.parse(comanda.productos);
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
            loadProductDetails,
        };
    },
    mounted() {
        this.loadProductDetails(this.comanda);
    },
}
</script>