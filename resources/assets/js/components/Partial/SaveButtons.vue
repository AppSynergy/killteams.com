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
    data() {
        return {
            latestKillteamId: null,
        }
    },
    methods: {
        saveKillteam() {
            this.ajaxSaveKillteam(this.killteam, this.refetchKillteams)
        },
        refetchKillteams(killteamId) {
            this.latestKillteamId = killteamId
            this.ajaxFetchKillteams(this.reloadKillteams)
        },
        reloadKillteams() {
            const killteam = _.find(this.killteams, { id: this.latestKillteamId })
            this.$store.dispatch('loadKillteam', killteam)
        }
    }
}
</script>
