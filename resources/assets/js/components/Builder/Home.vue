<template>
    <div class="vue-builder-home">

        <div class="container my-2">
            <div class="row">
                <div class="col col-12 col-md-6">
                    <mini-explorer></mini-explorer>

                </div>
                <div class="col col-12 col-md-6">
                    <button class="btn btn-success"
                        v-on:click="saveKillTeam">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <command-roster></command-roster>

    </div>
</template>

<script>
import CommandRoster from './CommandRoster.vue'
import MiniExplorer from './MiniExplorer.vue'
import hasFactionStore from '../../mixins/hasFactionStore.js'
export default {
    mixins: [ hasFactionStore ],
    components: { CommandRoster, MiniExplorer },
    data() {
        return {
            saved: false,
        }
    },
    computed: {
        killteam() {
            return this.$store.getters.getKillteam
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
