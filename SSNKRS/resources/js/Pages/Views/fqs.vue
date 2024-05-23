<template>
    <body style="min-height: 1000px">
        <div class="bg-gray-100">
            <Navbar></Navbar>
            <div class="container mx-auto">
                <div role="article" class="bg-gray-100 py-12 md:px-8">
                    <div class="px-4 xl:px-0 py-10">
                        <div class="flex flex-col lg:flex-row flex-wrap">
                            <div class="mt-4 lg:mt-0 lg:w-3/5">
                                <div>
                                    <h1 class="text-3xl ml-2 lg:ml-0 lg:text-4xl font-bold text-gray-900 tracking-normal lg:w-11/12">Preguntas más frecuentes</h1>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="px-6 xl:px-0">
                        <div class="grid sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-3 xl:grid-cols-2 pb-6 gap-8">
                            <div role="cell" class="bg-gray-100">
                                <div class="bg-white p-5 rounded-md relative h-full w-full">
                                    <!-- class="absolute inset-0 object-center object-cover h-full w-full"  -->
                                    <h1 class="pb-4 text-2xl font-semibold">Productos</h1>
                                    <img width="32" height="32" src="https://img.icons8.com/windows/32/shopping-bag.png" alt="shopping-bag" class="bg-gray-200 p-2 mb-5 rounded-full"/>
                                  <div id="acordeon">
                                    <details>
                                        <summary>Descripción de la guía de tallas</summary>
                                        <p>Nuestra guía de tallas está disponible en el detalle de cada producto bajo "Guía de tallas".</p>
                                    </details>
                                    <details>
                                        <summary>Tiempo estimado de entrega</summary>
                                        <p>Los envíos suelen demorar entre 5 y 10 días hábiles, excluyendo los fines de semana.</p>
                                    </details>
                                    <details>
                                        <summary>Proveedores de servicios de envío</summary>
                                        <p>Trabajamos directamente con la compañía de Correos para realizar los envíos.</p>
                                    </details>
                                    <details>
                                        <summary>Política de devoluciones</summary>
                                        <p>El período de devolución es de 30 días a partir de la recepción del producto por parte del cliente.</p>
                                    </details>
                                  </div>

                                </div>
                            </div>
                            <div role="cell" class="bg-gray-100">
                                <div class="relative bg-white p-5 rounded-md relative h-full w-full">
                                    <!-- class="absolute inset-0 object-center object-cover h-full w-full"  -->
                                    <h1 class="pb-4 text-2xl font-semibold">Preferencias del perfil</h1>
                                    <span><img class="bg-gray-200 p-2 mb-5 rounded-full" src="https://i.ibb.co/HFC1hqn/people-1.png" alt="home-1" /></span>
                                    <div id="acordeon">
                                      <details>
                                        <summary>Cambio de contraseña</summary>
                                        <p>Sí, para cambiar tu contraseña, debes acceder a la sección de información de tu perfil, donde encontrarás las instrucciones para realizar el cambio.</p>
                                    </details>
                                    <details>
                                        <summary>Actualización de información de perfil</summary>
                                        <p>Para actualizar la información de tu perfil, accede a la sección correspondiente en tu perfil. Allí podrás modificar todos los detalles que desees.</p>
                                    </details>
                                    <details>
                                        <summary>Procedimiento para eliminar la cuenta</summary>
                                        <p>Desde la sección de información del perfil, tienes la opción de eliminar tu cuenta en nuestra plataforma. Sin embargo, se te pedirá confirmación y deberás ingresar tu contraseña para completar el proceso.</p>
                                    </details>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Footer></Footer>
        </div>
    </body>
</template>

<script>
  import Navbar from '../navbar.vue';
  import Footer from '../footer.vue';

  export default {
    components: {
      Navbar,
      Footer,
    }
  }
  </script>