<template>
    <div class="vue-builder-fighter my-3 pb-3 border-bottom">

        <span class="mb-2 d-flex justify-content-between align-items-start">
            <div class="h3">
                <span class="badge badge-info">{{ fighter.finalPoints }}</span>
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
                v-for="wgo, wgo_i in fighter.wargear_options"
                :key="wgo_i"
                :fighter-id="fighter.id"
                :armament="fighter.armament"
                :available="getAvailable(wgo)"
                :wgo="wgo"
                :wargear="faction.wargear"
                v-on:selectWargear="selectWargear"
            ></wargear-selector>
        </span>

        <fighter-specialism
            :level="level"
            :specialists="fighter.specialists"
            :specialisms="specialisms">
        </fighter-specialism>

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
        'factions', 'fighter', 'specialisms'
    ],
    data() {
        return {
            level: 1,
        }
    },
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
            return replaceable
        }
    }
}
</script>
