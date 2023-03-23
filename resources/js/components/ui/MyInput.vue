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
            let data = event.target.value;
            this.$emit('update:modelValue', data)
        }
    }

}
</script>

<style scoped>


</style>
