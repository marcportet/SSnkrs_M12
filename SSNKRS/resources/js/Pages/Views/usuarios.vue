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
                  <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">Client</th>
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
                    <button v-if="!user.id_admin" type="button" class="btn btn-warning">Añadir Rol Admin</button>
                    <button v-if="user.id_admin" type="button" class="btn btn-danger">Eliminar Rol Admin</button>&nbsp;&nbsp;
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                    <button v-if="user.id_client && !user.id_marketing" type="button" class="btn btn-info">Añadir Rol Marketing</button>
                    <button v-if="user.id_marketing" type="button" class="btn btn-danger">Eliminar Rol Marketing</button>&nbsp;&nbsp;
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                    <button v-if="user.id_client" type="button" class="btn btn-danger">Eliminar Cliente</button>
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
  
  
  export default {
    components: {
      Navbar,
      Footer,
    },
    props:{
        users: Object,
    },
    methods: {
        
    getPermissions(user) {
      if (user.id_admin === '1') {
        return 'Admin';
      } else if (user.id_marketing === '1') {
        return 'Marketing';
      } else if (user.id_client === '1') {
        return 'Client';
      } else {
        return 'No te permisos';
      }
    }
  }
  };
  </script>
  
  <style scoped>
  button:disabled {
    opacity: 0.5;
    cursor: not-allowed;
  }
  </style>
  