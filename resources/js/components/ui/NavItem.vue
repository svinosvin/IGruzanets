<template>
    <div class="wrapper" v-if="props.isVisible==true">
        <router-link :to="props.route" v-slot="{ isActive }">
            <div class="item" :class="{ active: isActive }">
                <span>
                    <slot></slot>
                </span>
            </div>
        </router-link>
    </div>
</template>

<script setup>

import { useRoute } from 'vue-router'

const props = defineProps(['route','isVisible']);
console.log(props.isVisible);
</script>


<style lang="scss" scoped>
.wrapper {

    width: 25%;
    height: 2.5rem;
}

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
    border-bottom: #00ad81 5px solid;
    font-weight: 600;
    span{
        color: #00ad81
    }

}

</style>
