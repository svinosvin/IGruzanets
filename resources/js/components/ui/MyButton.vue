<template>
<button class="btn">
    <slot></slot>
</button>
</template>

<script>
export default {
    name: "MyButton"
}
</script>

<style lang="scss">
.btn{
    background-color: var(--color-primary-light);
    color: #fff;
    border-radius: 0;
    font-family: 'Josefin Sans', sans-serif;
    font-size: 1.5rem;
    padding: 18rem 3rem;
    transition: all .2s;
    cursor: pointer;

    &:hover{
        background-color: var(--color-primary-dark);
    }
}
</style>
