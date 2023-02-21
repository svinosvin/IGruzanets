<template>

        <router-link :to="route" class="nav__block" v-slot="{ isActive}" >
            <div class="nav__link">
            <i class="pi icon " :class="icon" ></i>
            <slot v-if="!isOpen"></slot>
            <span class="tooltip" >{{tooltip}}</span>
            </div>
        </router-link>

</template>

<script>
export default {//.sidebar-active .nav__block .tooltip{
//    display: block;
//    text-align: center;
//    position: fixed;
//    z-index: 100;
//    line-height: 30px;
//    transform: translateY(65%) translateX(75%);
//
//    border-radius: 6px;
//    background-color: $sidebar_colorhover;
//    color: $sidebar_color;
//    height: 35px;
//    width: 122px;
//    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
//}

    name: 'NavLink',
    props: ['route', 'icon', 'tooltip', 'isOpen']
}
</script>

<style scoped lang="scss">
$sidebar_bg: #11101C;
$sidebar_bghover: #FFFFFF;
$sidebar_bgactive:#FFFFFF;

$sidebar_color:#FFFFFF;
$sidebar_colorhover:#35313A;
$sidebar_coloractive:#35313A;
$sidebar_size:225px;
$sidebar_size_close:80px;

.active{

}
.nav{
    &__block{
        position: relative;
        font-size: 17px;
        background-color: $sidebar_bg;
        padding: 5px 20px 10px 40px;
        width: 100%;
        display: flex;
        justify-content: center;
        transition: .2s all ;
        align-items: center;

        &:hover{
            background:$sidebar_bghover;
        }
        border-radius: 5px;
    }

}

.nav__link{
    line-height: 30px;
    display: block;
    width: 100%;
    max-width: 250px;
    color: $sidebar_color;
}

.icon{
    padding-right: 30px;
    font-size: 22px;
    width:25px;
    height:25px;
    color: $sidebar_color;
    margin-left:6px ;
}
.nav__block:hover .icon {
    color: $sidebar_colorhover;
}

.nav__block:hover .nav__link{
    color: $sidebar_colorhover;
}



.nav__block .tooltip{
    display: none;
    text-align: center;
    position: fixed;
    z-index: 100;
    line-height: 30px;
    transform: translateY(65%) translateX(110%);

    border-radius: 6px;
    background-color: $sidebar_colorhover;
    color: $sidebar_color;
    height: 35px;
    width: 122px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}

.sidebar-active .nav__block:hover .tooltip{
    display: block;
    text-align: center;
    position: fixed;
    z-index: 100;
    line-height: 30px;
    transform: translateY(-25%) translateX(45%);

    border-radius: 6px;
    background-color: $sidebar_colorhover;
    color: $sidebar_color;
    height: 35px;
    width: 122px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}

</style>
