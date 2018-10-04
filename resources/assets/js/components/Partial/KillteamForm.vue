<template>
    <div class="vue-partial-killteam-form">
        <span class="h3 mb-0">
            Command Roster
            <span class="badge badge-info">{{ totalPoints }}</span>
        </span>
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
    ],
    computed: {
        totalPoints() {
            return _.sum(_.map(this.killteam.fighters, (fighter) => {
                return fighter.points
            }))
        }
    }
}
</script>
