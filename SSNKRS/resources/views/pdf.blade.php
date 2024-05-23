<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla en CSS</title>
    <style>
        *{
            margin: 0px;
            padding: 0px;
        }

        .icon-4{
            height: 1rem;
            width: 1rem;
        }

        .icon-5{
            height: 1.25rem;
            width: 1.25rem;
        }

        .icon-6{
            height: 1.5rem;
            width: 1.5rem;
        }

        body{
            -webkit-font-smoothing: antialiased;
            font-family: Arial, Helvetica, sans-serif;
            font-size: .875rem;
            line-height: 1.25rem;
            overflow-x: hidden;
            padding: .75rem 2rem;
            background-color: #f1f1f1;
            height: 98vh;
        }

        .container{
            width: 98%;
            margin: auto;
        }

        .contable{
            padding-top: 10px;
            padding-bottom: 30px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .contable h4{
            text-align: center;
            color: #60B2B9;
            padding: 5px;
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 1.5rem;
            margin: 20px;
        }

        .text-resalt{
            color: #08A1AE;
            border-bottom: 2px solid;
        }

        .fontable{
            background: #f9fafb;
            border: 1px solid #d5d6d7;
            border-radius: 10px;
            padding: 1px;
        }

        .table{
            width: 100%;
            border-collapse: collapse;
        }

        .thead th{
            border-bottom: 1px solid #d5d6d7;
            background: #f9fafb;
            color: #08A1AE;
            line-height: 1.8;
            font-size: .9em;
            padding: 5px;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        tfoot{
            border-top: 2px solid #e7edf3;
            background: #f9fafb;
            color: #000;
            line-height: 1.8;
            font-size: 1em;
            margin-bottom: 5px;
        }

        tfoot tr td{
            padding: 5px;
            padding-top: 10px;
            padding-bottom: 10px;
            font-weight: bold;
        }

        tbody{
            padding: 10px;
            border-radius: 10px;
        }

        tbody tr:nth-child(odd){
            background: #d7f0f19d;
        }

        tbody tr:nth-child(even){
            background: rgba(255, 255, 255, 0.808);
        }

        tbody tr:hover {
            background:#BDE0E4;
        }

        tbody tr td{
            padding: 5px;
            border-bottom: 1px solid rgb(253, 254, 255);
        }

        .celTopLeft{
            border-radius: 10px 0px 0px 0px;
        }

        .celTopRight{
            border-radius: 0px 10px 0px 0px;
        }

        .celFootLeft{
            border-radius: 0px 0px 0px 10px;
        }

        .celFootRight{
            border-radius: 0px 0px 10px 0px;
        }

        .text-left{
            text-align: start;
        }

        .text-center{
            text-align: center;
        }

        .text-right{
            text-align: right;
        }

        .search {
            width: 100%;
            position: relative;
            display: flex;
            margin-bottom: 10px;
        }

        .searchTerm {
            width: 100%;
            border: 1px solid #d5d6d7;
            border-right: none;
            padding: 5px;
            height: 20px;
            border-radius: 10px 0 0 10px;
            outline: none;
            color: #9DBFAF;
        }

        .searchTerm:focus{
            color: #00B4CC;
        }

        .searchButton {
            width: 40px;
            height: 32px;
            border: 1px solid #d5d6d7;
            background: #d5d6d7;
            text-align: center;
            color: #08A1AE;
            border-radius: 0 10px 10px 0;
            cursor: pointer;
            font-size: 20px;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="contable">
            <h4>Stock total</h4>
            <div class="fontable">
                <table class="table">
                    <thead>
                        <tr class="thead">
                            <th class="celTopLeft text-left">ID</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-right">Marca</th>
                            <th class="text-right">Precio</th>
                            <th class="celTopRight text-right">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="producto in paginatedProductos" :key="producto.id">
                            <td>{{ producto.id }}</td>
                            <td class="text-center">222</td>
                            <td class="text-right">$100.00</td>
                            <td class="text-right">$30.00</td>
                            <td class="text-right">$70.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<script>

import { ref, computed } from 'vue';
import axios from 'axios';

export default {
  setup() {
    const productos = ref([]);

    const fetchProductos = async () => {
      try {
        const response = await axios.get('http://localhost:3000/api/sneakers');
        productos.value = response.data;
      } catch (error) {
        console.error('Error al obtener los productos más vendidos:', error);
      }
    };

    fetchProductos();

    return {
      productos
    };
  },
};
</script>
