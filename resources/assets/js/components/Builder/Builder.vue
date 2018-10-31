<template>
    <div class="vue-builder-builder">
        <div class="container">

            <breadcrumb
                activeText="Select kill team"
                :parents="[{title: 'Home', route: { name: 'intro' }},
                    {title: 'Select game mode', route: { name: 'gamemode' }},
                    {title: 'Select faction', route: { name: 'choosefaction' }}]"
            >
                <save-buttons></save-buttons>
            </breadcrumb>

            <div class="row">
                <div class="col-12 col-sm-5 col-lg-4">
                    <sidebar
                        :factionId="factionId"
                        :factionKeyword="factionKeyword"
                        :fighters="killteam.fighters"
                        :gameMode="gameMode"
                    ></sidebar>
                </div>
                <div class="col-12 col-sm-7 col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body py-0 pt-3">

                            <killteam-form></killteam-form>
                            <div class="fighter-list" dusk="fighters">
                                <draggable v-model="killteam.fighters"
                                    :options="{handle:'.handle'}">
                                    <fighter v-for="fighter, index in killteam.fighters"
                                        :fighter="fighter"
                                        :game-mode="gameMode"
                                        :index="index"
                                        :key="fighter.id"
                                    ></fighter>
                                </draggable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Breadcrumb from '../Partial/Breadcrumb.vue'
import Draggable from 'vuedraggable'
import Fighter from './Fighter.vue'
import KillteamResource from '../../mixins/KillteamResource.js'
import KillteamForm from '../Partial/KillteamForm.vue'
import SaveButtons from '../Partial/SaveButtons.vue'
import Sidebar from '../Partial/Sidebar.vue'
export default {
    components: {
        Breadcrumb, Draggable, Fighter, KillteamForm, SaveButtons, Sidebar
    },
    mixins: [
        KillteamResource,
    ],
    props: [
        'factionId', 'factionKeyword', 'gameMode'
    ],
    mounted() {
        const faction_id = parseInt(this.factionId, 10)
        this.$store.dispatch('fetchFaction', { factionId: faction_id })
    },
    beforeRouteLeave (to, from, next) {
        console.log("@TODO: warning, this will delete your kill team!")
        this.$store.dispatch('clearKillTeam')
        next()
    }
}
</script>
