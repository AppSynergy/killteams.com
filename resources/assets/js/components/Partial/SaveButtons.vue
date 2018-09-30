<template>
    <div class="vue-partial-save-buttons">
        <button class="btn"
            v-on:click="saveKillTeam">
            Save
        </button>
    </div>
</template>

<script>
import KillteamResource from '../../mixins/killteamResource.js'
export default {
    mixins: [
        KillteamResource,
    ],
    data() {
        return {
            saved: false,
        }
    },
    methods: {
        saveKillTeam() {
            axios.post(API_URL + '/killteam', this.killteam)
                .then(response => (this.saved = true))
        }
    }
}
</script>
