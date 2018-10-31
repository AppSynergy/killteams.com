<template>
    <div class="vue-home-choose-faction">
        <div class="container">
            <div class="card">

                <span class="card-header h2 text-center">Select a Faction</span>

                <div class="card-body">
                    <breadcrumb
                        activeText="Select faction"
                        :parents="[{title: 'Home', route: { name: 'intro' }},
                            {title: 'Select game mode', route: { name: 'gamemode' }}]"
                    ></breadcrumb>
                    <div class="row">
                        <div class="col col-12 col-lg-6 col-xl-4 mb-3"
                            v-for="faction in factions">
                            <div class="border-primary border-bottom">
                                <div class="pb-2 d-flex flex-row align-items-center justify-content-between">
                                    <h4 class="h4 text-center m-0">{{ faction.name }}</h4>
                                    <router-link class="btn btn-primary"
                                        :dusk="faction.name"
                                        :class="(isDisabled(faction) ? 'disabled' : '')"
                                        :event="(isDisabled(faction) ? '' : 'click')"
                                        :disabled="isDisabled(faction)"
                                        :to="'/' + gameMode + '/' + faction.id + '/'
                                        + faction.faction_keyword + '/builder'">
                                        Select
                                    </router-link>
                                </div>
                                <div class="text-justify pb-1">
                                    <span v-if="isDisabled(faction)">
                                        <em>Coming soon.</em>
                                    </span>
                                    <span v-else>
                                        {{ faction.description }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <router-link :to="{ name: 'gamemode' }" dusk="back">
                        Back
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import Breadcrumb from '../Partial/Breadcrumb.vue'
export default {
    components: {
        Breadcrumb,
    },
    props: [
        'gameMode'
    ],
    computed: {
        factions() {
            return this.$store.getters.getFactions
        }
    },
    methods: {
        isDisabled(faction) {
            return faction.has_datasheets == false
        }
    }
}
</script>
