<template>
    <div class="vue-partial-killteam-form">
        <input type="hidden" v-model="killteam.id">
        <input class="form-control my-2"
            type="text" v-model="killteamName">
    </div>
</template>

<script>
import KillteamResource from '../../mixins/KillteamResource.js'
export default {
    mixins: [
        KillteamResource,
    ]
}
</script>
