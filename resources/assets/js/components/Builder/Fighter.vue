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
        <specialist-selector
            :fighterId="fighter.id"
            :game-mode="gameMode"
            :availableSpecialistNames="fighter.miniature.specialists"
            :specialistSelector="fighter.specialistSelector"
        ></specialist-selector>

    </div>
</template>

<script>
import itemsToText from '../../mixins/itemsToText.js'
import FighterProfile from '../Partial/Fighter/Profile.vue'
import SpecialistSelector from '../Partial/Fighter/SpecialistSelector.vue'
import WargearSelector from '../Partial/Fighter/WargearSelector.vue'
export default {
    components: {
        FighterProfile, SpecialistSelector, WargearSelector,
    },
    mixins: [
        itemsToText,
    ],
    props: [
        'fighter', 'gameMode', 'index',
    ],
    computed: {

    },
    methods: {
        removeFighter(fighterId) {
            this.$store.commit('removeFighter', fighterId)
        }
    }
}
</script>
