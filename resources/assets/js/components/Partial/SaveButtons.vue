<template>
    <div class="vue-partial-save-buttons">
        <button class="btn btn-primary"
            v-on:click="saveKillteam">
            Save
        </button>
        <button class="btn btn-warning"
            v-on:click="clearFighters">
            Clear All
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
        },
        clearFighters() {
            this.$store.commit('clearFighters')
        }
    }
}
</script>
