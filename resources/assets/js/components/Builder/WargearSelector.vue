<template>
    <div class="vue-builder-wargear-selector">
        <button type="button" class="ml-3 btn btn-sm btn-info btn-wargear"
            title="Wargear Options"
            data-toggle="popover"
            data-html="true">
            COG
        </button>
        <div class="d-none wargear-selector-list">
            <div class="form-check" v-for="opt in fighter.wargear_options">
                <input type="checkbox" class="form-check-input">
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
                        <option v-for="choice in opt.options" value="choice">
                            {{ idToName(choice) }}
                        </option>
                    </select>
                </span>
                <span v-if="'ONEOFEACHOF' == opt.method"
                    v-for="options in opt.options">
                    <select class="form-control">
                        <option v-for="choice in options" value="choice">
                            {{ idToName(choice) }}
                        </option>
                    </select>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import hasFactionStore from '../../mixins/hasFactionStore.js'
export default {
    mixins: [ hasFactionStore ],
    props: ['fighter'],
    mounted() {
        jQuery(function () {
            jQuery('[data-toggle="popover"]').popover({
                html: true,
                content: function() {
                    return $(this).next('.wargear-selector-list').html()
                }
            })
        })
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

        }
    }
}
</script>
