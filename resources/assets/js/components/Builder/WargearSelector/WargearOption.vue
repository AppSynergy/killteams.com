<template>
    <div class="vue-builder-wargear-selector-wargear-option">
        <div class="form-check">
            <input type="checkbox" class="form-check-input"
                v-model="checkbox"
                v-on:change="updateOption">
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
                <select class="form-control"
                    v-model="selectedOption"
                    v-on:change="updateOption">
                    <option v-for="choice in opt.options" :value="choice">
                        {{ idToName(choice) }}
                    </option>
                </select>
            </span>
            <span v-if="'ONEOFEACHOF' == opt.method"
                v-model="selectedOption"
                v-for="options in opt.options">
                <select class="form-control"
                    v-on:change="updateOption">
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
            selectedOption: false
        }
    },

    methods: {
        updateOption() {
            //console.log("Updates: ", this.checkbox, this.opt.replace, this.selectedOption)
            if (this.checkbox) {
                this.$emit('wargearSelection', this.opt.replace, [this.selectedOption])
            }
        },
        idToName(item) {
            if (_.isArray(item)) {
                return _.map(item, this.idToName)
            }
            return _.find(this.faction.wargear, (g) => g.id == item).name.toLowerCase()
        },
        itemsToText(items) {
            return this.arrayToList(_.map(items, this.idToName))
        },
        arrayToList(arr) {
            return arr.join(', ').replace(/,([^,]*)$/,' and$1')
        }
    }
}
</script>
