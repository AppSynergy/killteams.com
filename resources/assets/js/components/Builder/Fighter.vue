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
        </span>

        <fighter-profile
            :profile="fighter.miniature.profile"
            :suffixes="fighter.miniature.profile_suffixes">
        </fighter-profile>

        <fighter-armament
            :faction-id="fighter.faction_id"
            :armament="fighter.miniature.armament"
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
        FighterArmament, FighterProfile, SpecialistSelector, WargearSelector,
    },
    props: [
        'fighter', 'gameMode', 'index',
    ],
    computed: {
        hasWargearOptions() {
            return !_.isEmpty(this.fighter.miniature.wargear_options)
        }
    },
    methods: {
        removeFighter(fighterId) {
            this.$store.commit('removeFighter', fighterId)
        }
    }
}
</script>
