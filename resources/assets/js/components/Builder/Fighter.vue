<template>
    <div class="vue-builder-fighter my-3 pb-3 border-bottom"
        :dusk="'fighter-' + index">
        {{ fighter }}
    </div>
</template>

<script>
import itemsToText from '../../mixins/itemsToText.js'
import FighterProfile from './FighterProfile.vue'
import SpecialistSelector from './SpecialistSelector.vue'
import WargearSelector from './WargearSelector.vue'
export default {
    components: {
        FighterProfile, SpecialistSelector, WargearSelector
    },
    mixins: [
        itemsToText
    ],
    props: [
        'factions', 'fighter', 'fighters-wargear', 'index', 'gameMode', 'specialisms'
    ],
    computed: {

    },
    methods: {

    }
}
</script>
