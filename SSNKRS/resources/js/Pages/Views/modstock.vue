<template>
    <div>
        <Navbar />

        <div class="overflow-x-auto">
            <h1 style="text-align:center; margin-top: 5%; font-size: 40px;">{{ sneaker[0].name }}</h1>
            <div class="flex justify-center">
                <table class="w-50 mt-10 mx-10 table table-striped-columns">
                    <thead>
                        <tr>
                            <th scope="row">Size</th>
                            <th v-for="size in sizes" :key="size">
                            <td>{{ size.size }}</td>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Stock</th>
                            <th v-for="num in sneaker[0]['stock_final']" :key="num">
                            <td>{{ num }}</td>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center mt-10">
                <form @submit.prevent="form.patch(route('carrito.submit'))">
                    <select name="" id=""  v-model="form.size">
                        <option v-for="size in sizes" :key="size" :value="size.id">{{ size.size }}</option>
                    </select>

                    <input type="number" value="qty"  v-model="form.stock">

                    <a href="">Añadir Stock</a>
                </form>
            </div>

        </div>

        <Footer />
    </div>
</template>

<script>
import Navbar from '../navbar.vue';
import Footer from '../footer.vue';
import { ref, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';

export default {
    data() {
        return {
            stock: []
        }
    },
    components: {
        Navbar,
        Footer,
    },
    props: {
        sneaker: Object,
        sizes: Object,
    },
    setup() {
        const form = useForm({
            size: '',
            stock: '',
        });

        const sizes_stock = async (sizes, sneaker) => {
            var stock = [];
            var trobat = false;
            for (let i = 0; i < sizes.length; i++) {
                for (let m = 0; m < sneaker[0].size_stock.length; m++) {
                    if (sizes[i].size == sneaker[0].size_stock[m].size && trobat == false) {
                        stock[i] = '' + sneaker[0].size_stock[m].stock;
                        trobat = true;
                    }

                }
                if (!trobat) {
                    stock[i] = '0';
                }
                trobat = false;
            }

            sneaker[0]['stock_final'] = stock;
        };

        return {
            sizes_stock,
            form,
        };
    },
    mounted() {
        this.sizes_stock(this.sizes, this.sneaker);
    },
};


</script>