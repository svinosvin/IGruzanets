<template>
    <div class="select mr-2 h-12  rounded-md"  @onfocus="console.log('dsadas')" :class="{'select-focus': open}" @blur="open = false">
        <div class="select-head w-60 flex items-center justify-between h-11 mb-1 pr-1" @click="open = !open">
            <span class="current" v-if="getData(selected)">
                {{getData(selected)}}
            </span>
            <span v-else>
                {{placeholder}}
            </span>
            <span class="pi pi-chevron-down pr-2">
            </span>
        </div>
        <Transition>
            <div class="select-body"  v-show="open">
                <input class="select-input mt-2 shadow-sm pl-2" type="text"
                       placeholder="Введите..." ref="selectInputElement" @keyup.enter="" />
                <div class='select-items' >
                    <div v-for="(item, i) of items"  class="border-b-2">
                        {{getData(item)}}
                    </div>
                </div>
            </div>
        </Transition>
    </div>
</template>

<script setup>
import { ref, onMounted, toRef, watch, computed, toRaw } from "vue";

onMounted(()=>{
    selected.value = props.modelValue ?? null;
    items.value = props.options;
    console.log('items = ', items.value)
})

const props = defineProps({
    placeHolder: String,
    options : Array,
    modelValue: {
        type: Object,
        default: () => ({}),
    },
    fieldName: String,
});

///refs
const open = ref(false);
const selected = ref(null);
const items = ref([]);
const placeholder = ref('')

const getData = (obj) =>{
    if(!obj) return obj;
    if(props.fieldName){
        return obj[props.fieldName];
    }

}

</script>


<style scoped>


.current {
    border-bottom: 2px solid var(--primary-color);
}
.select {
    position: relative;
    outline: none;
    width: 15rem;
    border: 1px solid gray;

}
.select-input {
    border: 0px solid black;
    outline: none;
}

/*.select-buttons:not(:disabled) div:hover .unicon svg {*/
/*}*/
.select-input:focus {}
.select-clear {}
.transition {
    transition: all 1s ease;
}
.transform-rotate {
    transform: rotate(180deg);
}
.v-enter-active,
.v-leave-active {
    transition: all 0.3s ease ;
}
.v-enter-from,
.v-leave-to {
    transform: translateY(-30px);
    opacity: 0;
}
.select .select-head {
    padding-left: 1rem;
    cursor: pointer;
    user-select: none;
}

.select-focus{
    transition: all 0.1s ease;
    border: 2px solid var(--primary-color);
}
.select-body {
    margin-top: 0.2em;
    background: white;
    line-height: 2rem;
    position: fixed;
    z-index: 110;
    border-radius: 6px;
    box-shadow: 0 2px 4px -1px rgb(0 0 0 / 20%), 0 4px 5px 0 rgb(0 0 0 / 14%), 0 1px 10px 0 rgb(0 0 0 / 12%);
}
.select-items {
    overflow: hidden;
    overflow-y: auto;
    max-height: 14rem;
    min-height: 6px;
}
/* width */
.select-items::-webkit-scrollbar {
    width: 2px !important;
}
/* Track */
.select-items::-webkit-scrollbar-track {
    background: transparent !important;
}
/* Handle */
.select-items::-webkit-scrollbar-thumb {
    background: rgb(179, 179, 179) !important;
}
/* Handle on hover */
.select-items::-webkit-scrollbar-thumb:hover {
    background: transparent !important;
}
.select-items div {

    padding-left: 1em;
    cursor: pointer;
    user-select: none;
    transition: all 0.35s;
}
.select-items div:not(.current):hover {
    transform: translateY(4px);
}
.one-item-hint {
    font-size: small;
    color: gray;
}
</style>
