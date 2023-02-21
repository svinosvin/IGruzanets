<template>
    <input :value="modelValue" @input="updateInput" class="input-custom" type="text">
</template>

<script>
export default {
    name: "MyInput",
    props :{
        modelValue:[String,Number],
        name: [String,Number] ?? '',
    },
    methods :{
        updateInput(event){
            this.$emit('update:modelValue', event.target.value)
        }
    }

}
</script>

<style scoped>


</style>
