<template>
    <div class="vue-builder-wargear-selector">
        <popper trigger="click" :options="{placement: 'right'}">

            <div class="popper p-2">
                <wargear-option
                    v-for="option, key in fighter.wargear_options"
                    :fighter-id="fighter.id"
                    :key="key"
                    :opt="option"
                    v-on:wargearSelection="wargearSelection">
                </wargear-option>
            </div>

            <button slot="reference" type="button"
                class="ml-3 btn btn-sm btn-info btn-wargear"
                title="Wargear Options"
                data-toggle="popover"
                data-html="true">
                COG
            </button>

        </popper>
    </div>
</template>

<script>
import Popper from 'vue-popperjs'
import WargearOption from './WargearSelector/WargearOption.vue'
import hasFactionStore from '../../mixins/hasFactionStore.js'
export default {
    components: { Popper, WargearOption },
    mixins: [ hasFactionStore ],
    props: ['fighter'],
    methods: {
        wargearSelection(replace_items, add_items) {

            _.each(replace_items, (item) => {
                console.log("replace", item)
                if (_.includes(this.fighter.armament, item)) {
                    this.fighter.armament = _.remove(this.fighter.armament, item)
                }
            })

            _.each(add_items, (item) => {
                console.log("add", item)
                this.fighter.armament.push(item)
            })

        }
    }
}
</script>
