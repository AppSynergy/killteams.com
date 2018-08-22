<template>
    <div class="vue-builder-builder">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-5 col-lg-4">
                    <div class="card mb-4">

                        <span class="card-header h3">Choose Your Fighters</span>

                        <div class="card-body"
                            v-if="'sandbox' == gameMode">
                            <select class="custom-select custom-select-sm"
                                v-model="sandboxSelectedFactionId"
                                v-on:change="sandboxChangeFaction">
                                <option v-for="faction in availableFactions"
                                    :value="faction.id">{{ faction.name }}
                                </option>
                            </select>
                        </div>

                        <div class="card-body pt-0"
                            v-if="faction != undefined">
                            <div class=""
                                v-for="datasheet in faction.datasheets">

                                <div class="h5 mr-3 font-weight-bold d-block">
                                    {{ datasheet.name }}
                                </div>

                                <button class="btn btn-primary btn-sm mr-2 mb-2"
                                    v-on:click="addFighter(mini)"
                                    v-for="mini in datasheet.miniatures"
                                    :disabled="fightersByMiniature[mini.name] >= mini.profile.Max">
                                    {{ mini.name }}
                                    <span class="badge badge-light"
                                        v-if="mini.profile.Max > 0">
                                        {{ countMiniature(mini.name) }} / {{ mini.profile.Max }}
                                    </span>
                                </button>

                            </div>
                        </div>

                        <div class="card-footer">
                            <router-link dusk="back"
                                :to="'/' + gameMode + '/choosefaction'">
                                Back
                            </router-link>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-sm-7 col-lg-8">
                    <div class="card mb-4">

                        <span class="card-header h3 d-flex justify-content-between">
                            Command Roster
                            <span class="badge badge-info">{{ totalPoints }}</span>
                        </span>

                        <div class="card-body py-0">
                            <div class="fighter-list">
                                <span v-for="fighter in fighters">
                                    <fighter
                                        :key="fighter.id"
                                        :factions="factions"
                                        :fighter="fighter"
                                        :specialisms="specialisms"
                                    ></fighter>
                                </span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Fighter from './Fighter.vue'
export default {
    components: {
        Fighter
    },
    props: [
        'factionId', 'factionKeyword', 'gameMode'
    ],
    data() {
        return {
            availableFactions: [],
            currentFactionId: false,
            sandboxSelectedFactionId: this.factionId,
            specialisms: [],
        }
    },
    computed: {
        faction() {
            return this.$store.getters.getFaction(this.currentFactionId)
        },
        factions() {
            return this.$store.getters.getFactions
        },
        fighters() {
            return this.$store.getters.getFighters
        },
        fightersByMiniature() {
            return _.countBy(this.fighters, 'miniatureName')
        },
        totalPoints() {
            return _.sum(_.map(this.fighters, (fighter) => {
                return fighter.finalPoints
            }))
        }
    },
    mounted() {
        this.fetchFaction(this.factionId)
        this.fetchSpecialisms();
        if ('sandbox' == this.gameMode) {
            this.fetchFactions();
        }
    },
    beforeRouteLeave (to, from, next) {
        console.log("@TODO: warning, this will delete your kill team!")
        this.$store.commit('clearKillteam')
        next()
    },
    methods: {
        fetchFaction(id) {
            axios.get(API_URL + '/factions/' + id).then(response => {
                const faction = response.data.data
                this.currentFactionId = faction.id
                this.$store.commit('setFaction', faction)
            })
        },
        fetchFactions() {
            axios.get(API_URL + '/factions').then(response => {
                this.availableFactions = response.data.data
            })
        },
        fetchSpecialisms() {
            axios.get(API_URL + '/specialisms').then(response => {
                this.specialisms = response.data.data
            })
        },
        addFighter(mini) {
            let clone = _.clone(mini)
            clone.miniatureName = clone.name
            clone.name = this.getRandomName()
            this.$store.commit('addFighter', {
                factionId: this.currentFactionId,
                miniature: clone
            })
        },
        getRandomName() {
            if (!_.isEmpty(this.faction.narrative)) {
                let names = this.faction.narrative.names
                return _.sample(names.forename) + ' ' + _.sample(names.surname)
            }
            return "Matt Ward"
        },
        countMiniature(miniature_name) {
            if (_.has(this.fightersByMiniature, miniature_name)) {
                return this.fightersByMiniature[miniature_name]
            } else {
                return 0
            }
        },
        sandboxChangeFaction() {
            const id = this.sandboxSelectedFactionId
            if (id) {
                this.fetchFaction(id)
            }
        }
    }
}
</script>
