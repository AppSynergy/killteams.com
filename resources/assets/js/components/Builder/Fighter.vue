<template>
    <div class="vue-builder-fighter my-3 pb-3 border-bottom"
        :dusk="'fighter-' + index">

        <span class="mb-2 d-flex justify-content-between align-items-start">
            <span class="badge badge-primary handle">
                HANDLE
            </span>
            <span class="form-inline">
                <input type="text" class="form-control"
                    v-model="fighter.name">
            </span>
            <span class="text-sm">
                {{ fighter.miniature.name }}
            </span>
            <span class="close"
                v-on:click="removeFighter(fighter.id)">
                &times;
            </span>
            <span class="badge badge-info" dusk="points">
                <h5 class="h5 m-0">
                    {{ getPoints(fighter) }}
                </h5>
            </span>
        </span>

        <fighter-profile
            :profile="fighter.miniature.profile"
            :suffixes="fighter.miniature.profile_suffixes">
        </fighter-profile>

        <fighter-armament
            :faction-id="fighter.faction_id"
            :fighter-id="fighter.id"
            :miniature-armament="fighter.miniature.armament"
        ></fighter-armament>

        <specialist-selector
            :fighter-id="fighter.id"
            :game-mode="gameMode"
            :available-specialist-names="fighter.miniature.specialists"
            :specialist-selector="fighter.specialistSelector"
        ></specialist-selector>

        <span class="my-2 d-block"
            v-if="hasWargearOptions">
            <wargear-selector
                v-for="selector in fighter.wargearSelectors"
                :available="isWargearSelectorAvailable(selector.wgo)"
                :fighter="fighter"
                :game-mode="gameMode"
                :key="selector.id"
                :selector="selector"
            ></wargear-selector>
        </span>

    </div>
</template>

<script>
import FighterArmament from '../Partial/Fighter/Armament.vue'
import FighterProfile from '../Partial/Fighter/Profile.vue'
import SpecialistSelector from '../Partial/Fighter/SpecialistSelector.vue'
import WargearSelector from '../Partial/Fighter/WargearSelector.vue'
export default {
    components: {
        FighterArmament, FighterProfile,
        SpecialistSelector, WargearSelector,
    },
    props: [
        'fighter', 'gameMode', 'index',
    ],
    computed: {
        hasWargearOptions() {
            return !_.isEmpty(this.fighter.miniature.wargear_options)
        },
        fightersWargear() {
            return this.$store.getters.getAllFighterWargearSelectors
        }
    },
    methods: {
        removeFighter(fighterId) {
            this.$store.commit('removeFighter', fighterId)
        },
        getPoints(fighter) {
            return this.$store.getters.getFighterPoints({
                fighterId: fighter.id,
                factionId: fighter.faction_id,
            })
        },
        getArmament(fighter) {
            return this.$store.getters.getFighterArmament({
                fighterId: fighter.id,
                miniatureArmament: fighter.miniature.armament,
            })
        },
        isWargearSelectorAvailable(wargearOption) {
            const armament = this.getArmament(this.fighter)
            const itemsToReplaceAreAllThere = _.every(wargearOption.replace, (item) => {
                return _.includes(armament, item)
            })
            const limitedItemsAlreadyTaken = _(this.fightersWargear).filter((sel) => {
                const notMine = (undefined == _.find(this.fighter.wargearSelectors, {id: sel.id}))
                return ((sel.wgo.who != 'ANY') && notMine && (sel.isSelected))
            }).flatMap((sel) => {
                return sel.option
            }).value()
            const notAlreadyTaken = _.isEmpty(_.intersection(wargearOption.options, limitedItemsAlreadyTaken))
            return itemsToReplaceAreAllThere && notAlreadyTaken
        }
    }
}
</script>
