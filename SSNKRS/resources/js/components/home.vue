<template>        
<div class="home">
<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img :src="'img/imgCarrusel1.jpg'" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="img/imgCarrusel2.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="img/imgCarrusel3.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
            <img src="img/imgCarrusel4.jpg" class="d-block w-100" alt="...">
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="masVendidas">
    <div class="titulo">
        <span>Lo Mas Vendido</span>
        <a class="vermas" href="#">
    ver mas
    <svg class="h-8" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
    </svg>
</a>

        
    </div>
</div>
</div>
</template>