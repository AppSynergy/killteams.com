<template>
    <div class="vue-partial-breadcrumb">
        <nav aria-label="breadcrumb" class="navbar navbar-light px-0">
            <ol class="breadcrumb mr-auto mb-0 pl-0">
                <li class="breadcrumb-item" v-for="item in parents">
                    <router-link :to="item.route">
                        {{ item.title }}
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ activeText }}
                </li>
            </ol>
            <slot></slot>
        </nav>
    </div>
</template>

<style>
.breadcrumb {
    background-color: transparent;
}
</style>

<script>
export default {
    props: ['activeText', 'parents']
}
</script>
