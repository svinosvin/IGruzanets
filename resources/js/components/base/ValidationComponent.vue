<template>
    <Field :name="name" class="dsp-none w-full field" :value="modelValue"></Field>
    <small :id="`${name}-help`" class="p-error">{{ errorMessage }}</small>
</template>

<script setup>
import { Field, useField } from 'vee-validate';
import {onMounted, toRef} from "vue";
const props = defineProps({
    name: String,
    modelValue: String || Number || Boolean,

})
const emit = defineEmits(['update:modelValue']);
onMounted(()=>{
    console.log(props)
})
const { errorMessage, value } = useField(toRef(props, 'name'));

</script>

<style scoped>
.dsp-none{
    display:none;
}
</style>
