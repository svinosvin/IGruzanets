<template>
    <div class="card border-2 flex justify-between items-end flex-row">
        <div>
            <img class="w-52 h-48" :src="basesrc " alt="Image" />
        </div>
        <div class="pr-48 pb-2">
            <FileUpload  mode="basic" choose-label="Добавить картинку" class="w-54" name="demo[]" url="/api/upload" accept="image/*" @select="fileUploaded($event)" customUpload   @uploader="" />
        </div>
    </div>

</template>

<script setup>

import {onMounted, ref} from "vue";

const emit = defineEmits(['update'])

const props = defineProps({
    placeholder: String,
    modelValue: File,
    source: String,
})

const basesrc = ref('../../../images/admin/auto.png');
const fileUploaded = (event) =>{
    const data = event.files
    console.log(data[0]);
    emit('update:modelValue', data[0])
}

</script>

<style scoped>

</style>
