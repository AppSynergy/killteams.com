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
            wargearMasks: []
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
        },
        applyWargearMask(armament, mask) {
            _.each(mask.replace_items, (item) => {
                _.remove(armament, x => x == item)
            })
            _.each(mask.add_items, (item) => {
                armament.push(item)
            })
            return armament
        },
        selectWargear(selection) {
            const replace = (_.isArray(selection.replace)) ? selection.replace : [selection.replace]
            const option = (_.isArray(selection.option)) ? selection.option : [selection.option]
            // clear previous masks
            this.wargearMasks = _.reject(this.wargearMasks, { selection_id: selection.selection_id })
            // add to masks
            if (selection.isSelected) {
                this.wargearMasks.push({
                    selection_id: selection.selection_id,
                    replace_items: replace,
                    add_items: option,
                })
            }
            let finalArmament = _.clone(this.fighter.armament)
            _.each(this.wargearMasks, (mask) => {
                finalArmament = this.applyWargearMask(finalArmament, mask)
            })
            this.$store.commit('setFighterArmament', {
                fighter_id: this.fighter.id,
                armament: finalArmament
            })
        }

    }
}
</script>
