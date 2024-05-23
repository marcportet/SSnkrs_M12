<template>
    <div class="min-h-screen flex flex-col">
        <Navbar />

        <div class="flex-grow overflow-x-auto">
            <h1 style="text-align:center; margin-top: 5%; font-size: 40px;"><strong>{{ sneaker[0].name }}</strong></h1>
            <div class="flex justify-center">
                <table class="w-50 mt-10 mx-10 table table-striped-columns">
                    <thead>
                        <tr>
                            <th scope="row">Size</th>
                            <th v-for="size in sizes" :key="size.id">
                                <td>{{ size.size }}</td>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Stock</th>
                            <th v-for="num in sneaker[0].stock_final" :key="num">
                                <td>{{ num }}</td>
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="lg:col-span-2 lg:pr-8">
                <div v-if="$page.props.flash.success" class="alert alert-success">
                    {{ $page.props.flash.success }}
                </div>
                <div v-if="$page.props.flash.error" class="alert alert-danger">
                    {{ $page.props.flash.error }}
                </div>
            </div>
            <div class="flex justify-center mt-10">
                <form @submit.prevent="form.patch(route('modstock.add', sneaker[0].id))" class="flex space-x-4">
                    <div>
                        <InputLabel for="size" value="Size" />
                        <select name="size" id="size" v-model="form.size" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full text-sm">
                            <option v-for="size in sizes" :key="size.id" :value="size.id">{{ size.size }}</option>
                        </select>
                    </div>
                    <div>
                        <InputLabel for="stock" value="Cantidad de Stock" />
                        <input type="number" name="stock" id="stock" v-model="form.stock" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full text-sm">
                    </div>

                    <div class="flex items-end">
                        <PrimaryButton :disabled="form.processing"
                            class="w-full bg-blue-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-blue-500">
                            Añadir Stock
                        </PrimaryButton>
                    </div>
                </form>
            </div>
            <InputError style="text-align: center;" class="mt-2" :message="form.errors.size" />

        </div>

        <Footer />
    </div>
</template>

<script>
import Navbar from '../navbar.vue';
import Footer from '../footer.vue';
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';

export default {
    components: {
        Navbar,
        Footer,
        PrimaryButton,
        InputError,
        InputLabel
    },
    props: {
        sneaker: Object,
        sizes: Array,
    },
    setup() {
        const form = useForm({
            size: '',
            stock: '',
        });

        return {
            form,
        };
    },
};
</script>

<style scoped>
.min-h-screen {
    min-height: 100vh;
}
.flex {
    display: flex;
}
.flex-col {
    flex-direction: column;
}
.flex-grow {
    flex-grow: 1;
}
.space-x-4 > * + * {
    margin-left: 1rem;
}
</style>
