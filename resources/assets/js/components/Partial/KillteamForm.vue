<template>
    <div class="vue-partial-killteam-form">
        <span class="d-flex justify-content-between align-items-center">
            <h3 class="h3 m-0">Command Roster</h3>
            <span class="text-uppercase">
                Total points:
                <span class="badge badge-info "><h5 class="h5 m-0">
                    {{ totalPoints }}
                </h5></span>
            </span>
        </span>
        <input type="hidden" v-model="killteam.id">
        <input class="form-control my-2"
            type="text" v-model="killteamName" placeholder="Name your Kill Team">
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
