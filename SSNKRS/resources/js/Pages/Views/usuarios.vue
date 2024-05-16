<template>
    <div class="flex flex-col min-h-screen">
      <Navbar />
      <div class="flex-1 overflow-x-auto flex justify-center">
        <div class="p-1.5 min-w-full">
          <div class="overflow-scroll">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Id</th>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Nombre</th>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Email</th>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Permisos</th>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Admin</th>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Marketing</th>
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">User</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr v-for="user in users" :key="user.id">
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ user.id }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">{{ user.name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ user.email }}</td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                    <span v-if="user.id_admin">Admin, </span>
                    <span v-if="user.id_client">Client</span>
                    <span v-if="user.id_marketing">, Marketing</span>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                    <Link v-if="!user.id_admin" type="button" class="btn btn-warning" as="button"
                    :href="'/profile/add_admin/' + user.id" method="put">
                    Añadir Rol Admin
                    </Link>
                    <Link v-if="user.id_admin" type="button" class="btn btn-danger" as="button"
                    :href="'/profile/remove_admin/' + user.id" method="put">
                    Eliminar Rol Admin
                    </Link>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                    <Link v-if="user.id_client && !user.id_marketing" type="button" as="button" class="btn btn-info"
                    :href="'/profile/add_marketing/' + user.id" method="put">
                      Añadir Rol Marketing
                    </Link>
                    <Link v-if="user.id_marketing" type="button" class="btn btn-danger" as="button"
                    :href="'/profile/remove_marketing/' + user.id" method="put">
                      Eliminar Rol Marketing
                    </Link>
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                    <Link v-if="user.id_client" type="button" as="button" class="btn btn-danger"
                    :href="'/profile/destroy_id/' + user.id" method="delete">
                      Eliminar User
                    </Link>
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
  import { ref, computed } from 'vue';
  import axios from 'axios';
  import { Link } from '@inertiajs/vue3'

  
  
  export default {
    components: {
      Navbar,
      Footer,
      Link,
    },
    props:{
        users: Object,
    },
  };
  </script>

  
  <style scoped>
  button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
  </style>
  