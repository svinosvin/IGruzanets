<template>
    <div class="page__wrapper">
        <div class="mb-5 mt-1">
            <div class="page__name w-full bg-green-600 text-white text-3xl font-bold p-2.5 text-center">
                {{headerPage}}
            </div>
            <div class="header__view">
                <slot name="header">

                </slot>
            </div>
            <div class="main__view">
                <slot name="main">

                </slot>
            </div>
            <div class="footer__view">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    headerPage: String,
})



</script>

<style scoped lang="scss">
.page__name{
    border-radius: 20px 20px 0 0;
}

html body .page__wrapper
{
}
</style>
