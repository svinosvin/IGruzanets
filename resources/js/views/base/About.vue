
<template>
    <div
        class="relative pt-14 pb-32 w-full flex flex-col  page-wrapper"
        style="min-height: 75vh;"
    >
        <div  class="text-center font-bold text-5xl text-white mb-10 w-full bg-gray-800 p-5">
            <h1>О нас </h1>
        </div>

        <div class="main-cont  flex text-white">
            <div id="map-container" style="height: 400px"></div>
            <div class="font-bold info-container bg-gray-200 text-center text-black" style=" height: 400px">
                <h2 class="p-5">О нас</h2>
                <div class="info w-full text-left  font-light pl-3 ">
                  <ul class="one pl-3  ">
                      <li class="pb-5 border-b-3">
                          На карте cлева представлены точки, с пунтками возможной сдачи мусора на переработку.
                      </li>
                      <li class="pb-5 border-b-3">
                        Всегда внимательны к просьбам клиентов
                      </li>
                      <li class="pb-5 border-b-3">
                          Инфоцентр: +375447742316
                      </li>
                      <li class="pb-5 border-b-3">
                         С вопросом  обращаться по почте: artemivanets@bk.ru
                      </li>
                      <li class="pb-5 border-b-3">
                          График работы: 9:00 - 20:00 - ежедневно
                      </li>
                  </ul>

                </div>
            </div>
        </div>
        <section class="relative py-20">
            <div
                class="bottom-auto top-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden -mt-20"
                style="height: 80px;"
            >
                <svg
                    class="absolute bottom-0 overflow-hidden"
                    xmlns="http://www.w3.org/2000/svg"
                    preserveAspectRatio="none"
                    version="1.1"
                    viewBox="0 0 2560 100"
                    x="0"
                    y="0"
                >

                </svg>
            </div>
            <div class="container mx-auto px-4">
                <div class="items-center flex flex-wrap">
                    <div class="w-full md:w-4/12 ml-auto mr-auto px-4">
                        <img
                            alt="..."
                            class="max-w-full rounded-lg shadow-lg"
                            src="../../../images/client/543.jpg"
                        />
                    </div>
                    <div class="w-full md:w-5/12 ml-auto mr-auto px-4">
                        <div class="md:pr-12">
                            <div
                                class="text-pink-600 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-pink-300"
                            >
                                <i class="fas fa-rocket text-xl"></i>
                            </div>
                            <h3 class="text-3xl text-white font-semibold">Растущая команда</h3>
                            <p class="mt-4 text-lg leading-relaxed text-gray-600">
                                Наши взгляды все чаще подходят людям, они с огнем в глазах идут в нашу атмосферную компанию!
                            </p>
                            <ul class="list-none mt-6">
                                <li class="py-2">
                                    <div class="flex items-center">
                                        <div>
                        <span
                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3"
                        ><i class="fas fa-fingerprint"></i
                        ></span>
                                        </div>
                                        <div>
                                            <h4 class="text-gray-600">
                                                Аккуратность
                                            </h4>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-2">
                                    <div class="flex items-center">
                                        <div>
                        <span
                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3"
                        ><i class="fab fa-html5"></i
                        ></span>
                                        </div>
                                        <div>
                                            <h4 class="text-gray-600">Ответственность</h4>
                                        </div>
                                    </div>
                                </li>
                                <li class="py-2">
                                    <div class="flex items-center">
                                        <div>
                        <span
                            class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-pink-600 bg-pink-200 mr-3"
                        ><i class="far fa-paper-plane"></i
                        ></span>
                                        </div>
                                        <div>
                                            <h4 class="text-gray-600">Внимательность к мелочам</h4>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
</template>

<script setup>

import {onMounted} from "vue";

const main = async ()=> {


     let  myPlacemark;

    const myMap = new ymaps.Map("map-container", {
            center: [53.904975, 27.555524],
            zoom: 12
        });

        myPlacemark = new ymaps.Placemark([ 27.555524,53.904975],{
            hintContent: 'Пунктры приема вторсырья!'
        });

        myMap.geoObjects.add(myPlacemark);


//кластеры
    let coords = [
        [53.917203, 27.524092],
        [53.902289, 27.513411,],
        [53.908745, 27.587929],
        [53.888948, 27.558197],
        [53.899076,27.592958],
        [53.879649, 27.581527],
        [53.894262, 27.604295],
        [53.913159, 27.584619],
    ];

    let myCollection = new ymaps.GeoObjectCollection();

    for (let i = 0; i<coords.length; i++) {
        myCollection.add(new ymaps.Placemark(coords[i]), {  balloonContent: '<strong>Пункт приема вторсырья</strong>'});
    }

    myMap.geoObjects.add(myCollection);
}
onMounted(()=>{
    if(document.querySelector('ymaps'))
     document.querySelector('ymaps').remove();

    ymaps.ready(main);


})
</script>

<style scoped>
.info-container{
    width: 45%;

}
.border-b-3{
    border-bottom: 2px solid white;
}
.info  .one{
    list-style: circle inside;
}
#map-container{
    width: 45%;
}
.main-cont{
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}
.page-wrapper{
    padding-top: 6rem;
    margin: 0 auto;
    max-width: 1300px;
}
@media only screen and (max-width: 1220px) {
    #map-container{
        width: 100%;
        margin-bottom: 10px;
    }
    .info-container{
        width: 100%;

    }
}


@media only screen and (max-width: 620px) {



}
</style>
