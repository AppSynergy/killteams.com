<template>
    <div class="vue-partial-save-buttons">
        <button class="btn"
            v-on:click="saveKillteam">
            Save
        </button>
    </div>
</template>

<script>
import KillteamResource from '../../mixins/KillteamResource.js'
import KillteamsResource from '../../mixins/KillteamsResource.js'
export default {
    mixins: [
        KillteamResource,
        KillteamsResource,
    ],
    methods: {
        saveKillteam() {
            this.ajaxSaveKillteam(this.killteam, this.refetchKillteams)
        },
        refetchKillteams() {
            this.ajaxFetchKillteams(this.reloadKillteams)
        },
        reloadKillteams(killteamId) {
            const killteam = _.find(this.killteams, killteamId)
            this.$store.dispatch('loadKillteam', killteam)
        }
    }
}
</script>
