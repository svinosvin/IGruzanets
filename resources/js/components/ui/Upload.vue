<template>
    <div class="card border-2 flex justify-between items-end flex-row">
        <div v-if="source || modelValue">
            <img class="w-48 h-44" :src="modelValue!=null ? modelValue.objectURL : source" alt="Image" />
        </div>
        <div v-else>
            <img class="w-48 h-44" src="../../../images/admin/empty.png " alt="Image" />
        </div>

        <div class="pb-2">
            <FileUpload  mode="basic" choose-label="Добавить картинку" class="w-54" name="demo[]" url="/api/upload" accept="image/*" @select="fileUploaded($event)" customUpload   @uploader="" />
        </div>
    </div>

</template>

<script setup>

import {onMounted, ref} from "vue";

const emit = defineEmits(['update'])

const props = defineProps({
    placeholder: String,
    modelValue: File || null,
    source: String,
})

const fileUploaded = (event) =>{
    const data = event.files
    console.log(data[0]);
    emit('update:modelValue', data[0])
    console.log(props.modelValue)
}

</script>

<style scoped>

</style>
