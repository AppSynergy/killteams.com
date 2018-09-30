<template>
    <div class="vue-builder-fighter my-3 pb-3 border-bottom"
        :dusk="'fighter-' + index">

        <span class="mb-2 d-flex justify-content-between align-items-start">
            {{ fighter }}
            <span class="form-inline">
                <input type="text" class="form-control"
                    v-model="fighter.name">
            </span>
        </span>

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
        'fighter', 'gameMode', 'index',
    ],
    computed: {

    },
    methods: {

    }
}
</script>
