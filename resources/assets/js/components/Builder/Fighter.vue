<template>
    <div class="vue-builder-fighter my-3 pb-3 border-bottom"
        :dusk="'fighter-' + index">

        <span class="mb-2 d-flex justify-content-between align-items-start">
            <div class="h3">
                <span class="badge badge-info" dusk="points">
                    {{ fighter.finalPoints }}
                </span>
            </div>

            <div class="">
                <span class="form-inline">
                    <input type="text" class="form-control"
                        v-model="fighter.name">
                </span>
                <div class="text-sm">
                    {{ fighter.miniatureName }}
                </div>
            </div>

            <fighter-profile :profile="fighter.profile"
                :suffixes="fighter.profile_suffixes">
            </fighter-profile>
            <span class="">
                <span class="close"
                    v-on:click="removeFighter(fighter.id)">
                    &times;
                </span>
            </span>
        </span>

        <span class="my-2 d-block">
            <strong>Armed with:</strong> <em
                v-html="itemListToText(fighter.finalArmament, faction.wargear, ' and ')"></em><br>
        </span>

        <span class="my-2 d-block"
            v-if="hasWargearOptions">
            <wargear-selector
                v-for="selector in fighter.wargearSelectors"
                :key="selector.id"
                :selection-id="selector.id"
                :fighter-id="fighter.id"
                :armament="fighter.armament"
                :available="getAvailable(selector.wgo)"
                :wgo="selector.wgo"
                :wargear="faction.wargear"
            ></wargear-selector>
        </span>

        <fighter-specialism
            :specialists="fighter.specialists"
            :specialisms="specialisms"
            :game-mode="gameMode"
        ></fighter-specialism>

    </div>
</template>

<script>
import itemsToText from '../../mixins/itemsToText.js'
import FighterProfile from './FighterProfile.vue'
import FighterSpecialism from './FighterSpecialism.vue'
import WargearSelector from './WargearSelector.vue'
export default {
    components: {
        FighterProfile, FighterSpecialism, WargearSelector
    },
    mixins: [
        itemsToText
    ],
    props: [
        'factions', 'fighter', 'fighters-wargear', 'index', 'gameMode', 'specialisms'
    ],
    computed: {
        faction() {
            return this.factions[this.fighter.factionId]
        },
        hasWargearOptions() {
            return !_.isEmpty(this.fighter.wargear_options)
        }
    },
    methods: {
        removeFighter(fighterId) {
            this.$store.commit('removeFighter', fighterId)
        },
        getAvailable(wargear_option) {
            const replaceable = _.every(wargear_option.replace, (item) => {
                return _.includes(this.fighter.finalArmament, item)
            })
            const notMineLimited = _(this.fightersWargear).filter((sel) => {
                const notMine = (undefined == _.find(this.fighter.wargearSelectors, {id: sel.id}))
                return ((sel.wgo.who != 'ANY') && notMine && (sel.isSelected))
            }).flatMap((sel) => {
                return sel.option
            }).value()
            return replaceable &&  _.isEmpty(_.intersection(wargear_option.options, notMineLimited))
        }
    }
}
</script>
