<template>
    <div class="vue-builder-wargear-selector">
        <button type="button" class="ml-3 btn btn-sm btn-info btn-wargear"
            title="Wargear Options"
            data-toggle="popover"
            data-html="true"
            v-on:click="openWargearOptions()">
            COG
        </button>
        <div class="d-none wargear-selector-list">
            {{ fighter.wargear_options }}
        </div>
    </div>
</template>

<script>
export default {
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
        openWargearOptions() {

        }
    }
}
</script>
