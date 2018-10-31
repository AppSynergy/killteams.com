<template>
    <div class="vue--partial-sidebar">
        <div class="card">

            <div class="card-body"
                v-if="'sandbox' == gameMode">
                <div class="h5 mr-3 font-weight-bold d-block">
                    Faction
                </div>
                <select class="custom-select custom-select-sm"
                    v-model="selectedFactionId"
                    v-on:change="updateFactionId">
                    <option v-for="faction in factions"
                        :value="faction.id">{{ faction.name }}
                    </option>
                </select>
            </div>

            <div class="card-body pt-3"
                v-if="faction != undefined">
                <div class=""
                    v-for="datasheet in faction.datasheets">
                    <div class="h5 mr-3 font-weight-bold d-block">
                        {{ datasheet.name }}
                    </div>
                    <button class="btn btn-primary btn-sm mr-2 mb-2"
                        v-for="miniature in datasheet.miniatures"
                        v-on:click="addFighter(miniature)"
                        :disabled="isMiniatureDisabled(miniature)"
                        :dusk="'add ' + miniature.name">
                        {{ miniature.name }}
                    </button>
                </div>
            </div>

            <div class="card-body pt-3">
                <loader></loader>
            </div>

            <div class="card-footer">
                <router-link dusk="back"
                    :to="'/' + gameMode + '/choosefaction'">
                    Back to faction select
                </router-link>
                <router-link dusk="home" to="/">
                    Home
                </router-link>
            </div>

        </div>
    </div>
</template>

<script>
import Loader from './Loader.vue'
export default {
    components: {
        Loader,
    },
    props: [
        'factionId', 'factionKeyword', 'fighters', 'gameMode',
    ],
    computed: {
        factions() {
            return this.$store.getters.getFactions
        },
        faction() {
            return _.find(this.factions, { id: this.selectedFactionId })
        },
    },
    data() {
        return {
            selectedFactionId: parseInt(this.factionId, 10),
        }
    },
    methods: {
        isMiniatureDisabled(miniature) {
            if (0 == miniature.profile.Max) {
                return false
            }
            let count = _.countBy(this.fighters, 'miniature.name')
            return count[miniature.name] >= miniature.profile.Max
        },
        addFighter(miniature) {
            let wargearSelectors = []
            _.each(miniature.wargear_options, (wgo) => {
                wargearSelectors.push({
                    isSelected: false,
                    replace: wgo.replace,
                    option: ('ALLOF' == wgo.method) ? wgo.options : null,
                    wgo: wgo
                })
            })
            this.$store.dispatch('addFighter', {
                name: 'Frodo',
                miniature,
                specialistSelector: {
                    id: null,
                    fighter_id: null,
                    specialism_id: null,
                    selector_id: null,
                    level: 1,
                    abilities: [],
                },
                wargearSelectors,
            })
        },
        updateFactionId() {
            this.$store.dispatch('fetchFaction', { faction_id: this.selectedFactionId })
            this.$router.push({
                name: 'builder',
                params: {
                    gameMode: this.gameMode,
                    factionId: this.selectedFactionId,
                    factionKeyword: this.faction.faction_keyword,
                }
            })
        }
    }
}
</script>
