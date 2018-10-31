<template>
    <div class="vue-partial-breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" v-for="item in parents">
                    <router-link :to="item.route">
                        {{ item.title }}
                    </router-link>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ activeText }}
                </li>
            </ol>
        </nav>
    </div>
</template>

<script>
export default {
    props: ['activeText', 'parents']
}
</script>
