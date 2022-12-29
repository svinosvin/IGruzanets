<template>
<button class="btn">
    <slot></slot>
</button>
</template>

<script>
export default {
    name: "my-button"
}
</script>

<style lang="scss" scoped>
.btn {
    background-color: var(--color-primary-light);
    color: #fff;
    margin: 20px 0;
    border: 2px solid white;
    border-radius: 2px;
    font-family: 'Josefin Sans', sans-serif;
    font-size: 1.3rem;
    text-transform: uppercase;
    padding: 1.8rem 40px;
    transition: all .2s;
    cursor: pointer;
    &:hover {
        background-color: var(--color-primary-dark);
    }
}

</style>
