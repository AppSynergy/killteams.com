<template>
    <tr>
        <td class="grey-box"
            v-for="stat, key in stats">

            <div v-if="'name' == key" class="form-group">
                <div class="input-group">
                    <input class="form-control" v-model="fighter.name">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-danger text-white"
                            v-on:click="removeFighter(fighter.id)"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>

            <div v-if="'mini' == key" class="form-group">
                <div class="form-control-plaintext">
                    {{ fighter.miniature_name }}
                </div>
            </div>

            <div v-if="'wargear' == key" class="form-group">
                <div class="form-control-plaintext d-flex justify-content-between">
                    {{ getWargearText(fighter) }}
                    <button type="button" class="ml-3 btn btn-sm btn-info btn-wargear"
                        v-on:click="openWargearOptions(fighter)">
                        COG
                    </button>
                </div>
            </div>

            <div v-if="'exp' == key" class="form-group">
                <div class="form-control-plaintext">
                    0
                </div>
            </div>

            <div v-if="'pts' == key" class="form-group">
                <div class="form-control-plaintext">
                    {{ fighter.points }}
                </div>
            </div>

        </td>
    </tr>
</template>

<script>
import hasFactionStore from '../../../mixins/hasFactionStore.js'
export default {
    mixins: [ hasFactionStore ],
    props: ['fighter', 'stats'],
    methods: {
        removeFighter(fighter_id) {
            this.$store.commit('removeFighter', fighter_id)
        },
        getWargearText(fighter) {
            return _.map(fighter.armament, (x) => (this.getWargearName(x))).join(', ')
        },
        getWargearName(wargear_id) {
            return _.find(this.faction.wargear, (x) => (x.id == wargear_id)).name
        },
        openWargearOptions(fighter) {

        }
    },
}
</script>
