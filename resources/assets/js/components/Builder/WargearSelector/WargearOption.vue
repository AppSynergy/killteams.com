<template>
    <div class="vue-builder-wargear-selector-wargear-option">
        <div class="form-check">
            <input type="checkbox" class="form-check-input"
                v-model="selected">
            <span v-if="'REPLACE' == opt.may">
                Replace {{ itemsToText(opt.replace) }} with
            </span>
            <span v-if="'TAKE' == opt.may">
                Take
            </span>
            <span v-if="'ALLOF' == opt.method">
                {{ itemsToText(opt.options) }}
            </span>
            <span v-if="'ONEOF' == opt.method">
                <select class="form-control">
                    <option v-for="choice in opt.options" :value="choice">
                        {{ idToName(choice) }}
                    </option>
                </select>
            </span>
            <span v-if="'ONEOFEACHOF' == opt.method"
                v-for="options in opt.options">
                <select class="form-control">
                    <option v-for="choice in options" :value="choice">
                        {{ idToName(choice) }}
                    </option>
                </select>
            </span>
        </div>
    </div>
</template>

<script>
import hasFactionStore from '../../../mixins/hasFactionStore.js'
export default {
    props: ['opt', 'fighterId'],
    mixins: [ hasFactionStore ],
    data() {
        return {
            checkbox: false,
        }
    },
    watch: {
        checkbox(newVal, oldVal) {
            this.setFighterArmament()
        }
    },
    methods: {
        idToName(item) {
            return _.find(this.faction.wargear, (g) => g.id == item).name.toLowerCase()
        },
        itemsToText(items) {
            return this.arrayToList(_.map(items, this.idToName))
        },
        arrayToList(arr) {
            return arr.join(', ').replace(/,([^,]*)$/,' and$1')
        },
        setFighterArmament() {
            this.$store.commit('setFighterArmament', {
                fighter_id: this.fighterId,
                armament: []
            })
        }
    }
}
</script>
