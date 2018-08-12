<template>
    <div class="vue-builder-wargear-selector">
        <popper trigger="click" :options="{placement: 'right'}">

            <div class="popper p-2">
                <wargear-option
                    v-for="option, key in fighter.wargear_options"
                    :fighter-id="fighter.id"
                    :key="fighter.id"
                    :opt="option">
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
export default {
    components: { Popper, WargearOption },
    props: ['fighter']
}
</script>
