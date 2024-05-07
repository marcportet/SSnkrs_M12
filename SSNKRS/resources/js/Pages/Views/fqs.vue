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


                                    <div class="accordion" id="accordionPanelsStayOpenExample">
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
        Accordion Item #1
      </button>
    </h2>
    <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show">
      <div class="accordion-body">
        <strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
        Accordion Item #2
      </button>
    </h2>
    <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse">
      <div class="accordion-body">
        <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
        Accordion Item #3
      </button>
    </h2>
    <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse">
      <div class="accordion-body">
        <strong>This is the third item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
      </div>
    </div>
  </div>
</div>
                                </div>
                            </div>
                            <div role="cell" class="bg-gray-100">
                                <div class="relative bg-white p-5 rounded-md relative h-full w-full">
                                    <!-- class="absolute inset-0 object-center object-cover h-full w-full"  -->
                                    <h1 class="pb-4 text-2xl font-semibold">Preferencias del perfil</h1>
                                    <span><img class="bg-gray-200 p-2 mb-5 rounded-full" src="https://i.ibb.co/HFC1hqn/people-1.png" alt="home-1" /></span>
                                    <div class="my-5">
                                        <div class="flex items-center pb-4 dark:border-gray-700 cursor-pointer w-full">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12.5" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </div>
                                            <h4 class="text-md text-black-900 dark:text-black-100 pl-4">Puedo cambiar mi contraseña?</h4>
                                        </div>
                                        <div class="flex items-center pb-4 dark:border-gray-700 cursor-pointer w-full">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12.5" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </div>
                                            <h4 class="text-md text-black-900 dark:text-black-100 pl-4">Puedo hacer cambios de informacion de perfil?</h4>
                                        </div>
                                        <div class="flex items-center pb-4 dark:border-gray-700 cursor-pointer w-full">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12.5" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                </svg>
                                            </div>
                                            <h4 class="text-md text-black-900 dark:text-black-100 pl-4">Como elimino mi cuenta?</h4>
                                        </div>
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