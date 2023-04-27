<template>
    <div class="wrapper" v-if="props.isVisible==true">
        <router-link class="link lg:text-gray-400 lg:hover:text-blue-600 hover:text-blue-600 px-3 py-4 lg:py-2 flex items-center text-xs uppercase font-bold" :to="props.route" v-slot="{ isActive }">
            <div class="text-center" :class="{active:isActive}">
               <i
                    class="lg:text-gray-300 text-gray-500 text-lg leading-lg" :class="icon"
                ></i
                ><span class="inline-block ml-2">
                    <slot></slot>
                </span>
            </div>
        </router-link>
    </div>
</template>

<script setup>

import { useRoute } from 'vue-router'

const props = defineProps(['route','isVisible', 'icon']);
console.log(props.isVisible);
</script>


<style lang="scss" scoped>


.item {
    margin-inline: 0.1rem;
    height: 70px;
    font-size: 16px;

    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items:center;
    border-radius: 2px;
    cursor: pointer;
    transition: all 0.1s;

    &:active {
        box-shadow: none;
        transform: translateY(3px);
    }

    &:hover {
        color: #00ad81

    }
    span {
        display: inline-block;
        width: 100px;
        text-align: center;
    }

}

.active {
    color: #00ad81;
    font-weight: 600;
    span{

        color: rgb(59 130 246 );
        border-bottom: 2px solid rgb(59 130 246 ) ;

    }

}
.link {
    transition: .2s all ease;
}
</style>
