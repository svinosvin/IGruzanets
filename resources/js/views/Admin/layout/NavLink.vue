<template>
    <li class="nav-item">
        <router-link :to="route" class="nav-link" v-slot="{ isActive}" >
            <div class="wrapper" :class="{active: isActive}">
                <i class="mr-1 pi" :class="icon" ></i>
                <p>
                    <slot></slot>
                </p>
            </div>
        </router-link>
    </li>
</template>

<script>
export default {
    name: 'NavLink',
    props: ['route', 'icon']
}
</script>

<style scoped lang="scss">

.active{

}

</style>
