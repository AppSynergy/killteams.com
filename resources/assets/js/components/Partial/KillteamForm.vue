<template>
    <div class="vue-partial-killteam-form">
        <input class="form-control my-2"
            type="text" v-model="killteamName">
    </div>
</template>

<script>
import KillteamResource from '../../mixins/killteamResource.js'
export default {
    mixins: [
        KillteamResource,
    ]
}
</script>
