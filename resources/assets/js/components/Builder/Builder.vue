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

                        <div class="card-body pt-3"
                            v-if="faction != undefined">
                            <div class=""
                                v-for="datasheet in faction.datasheets">

                                <div class="h5 mr-3 font-weight-bold d-block">
                                    {{ datasheet.name }}
                                </div>

                                <button class="btn btn-primary btn-sm mr-2 mb-2"
                                    :dusk="'add ' + mini.name"
                                    v-on:click="addFighter(mini)"
                                    v-for="mini in datasheet.miniatures"
                                    :disabled="isDisabled(mini)">
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
                                Back to faction select
                            </router-link>
                            <router-link dusk="home" to="/">
                                Home
                            </router-link>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-sm-7 col-lg-8">
                    <div class="card mb-4">

                        <span class="card-header d-flex justify-content-between">
                            <span class="h3 mb-0">
                                Command Roster
                                <span class="badge badge-info">{{ totalPoints }}</span>
                            </span>
                            <input class="form-control" type="text"
                                v-model="teamName">
                            <button class="btn"
                                v-on:click="saveKillTeam">
                                Save
                            </button>
                        </span>

                        <div class="card-body py-0">
                            <div class="fighter-list" dusk="fighters">
                                <draggable v-model="fighters">
                                    <fighter v-for="fighter, index in fighters"
                                        :key="fighter.id"
                                        :factions="factions"
                                        :fighter="fighter"
                                        :fighters-wargear="fightersWargear"
                                        :index="index"
                                        :specialisms="specialisms"
                                        :game-mode="gameMode"
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
import Draggable from 'vuedraggable'
import FactionResource from '../../mixins/factionResource.js'
import Fighter from './Fighter.vue'
export default {
    components: {
        Draggable, Fighter
    },
    mixins: [
        FactionResource
    ],
    props: [
        'factionId', 'factionKeyword', 'gameMode'
    ],
    data() {
        return {
            currentFactionId: false,
            sandboxSelectedFactionId: this.factionId,
            specialisms: [],
            saved: false,
        }
    },
    computed: {
        killteam() {
            return this.$store.getters.getKillteam
        },
        faction() {
            return this.$store.getters.getFaction(this.currentFactionId)
        },
        teamName: {
            get() {
                return this.$store.getters.getTeamName
            },
            set(value) {
                this.$store.commit('updateTeamName', value)
            }
        },
        fighters: {
            get() {
                return this.$store.getters.getFighters
            },
            set(value) {
                this.$store.commit('updateFighters', value)
            }
        },
        fightersWargear() {
            return _.flatMap(this.fighters, (fighter) => {
                return fighter.wargearSelectors
            })
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
        saveKillTeam() {
            axios.post(API_URL + '/killteam', this.killteam)
                .then(response => (this.saved = true))
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
        isDisabled(mini) {
            if (0 == mini.profile.Max) {
                return false
            }
            return this.fightersByMiniature[mini.name] >= mini.profile.Max
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
