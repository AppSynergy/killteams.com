<template>
    <div class="vue-builder-command-roster">
        <div class="container">
            <div class="border border-primary mb-5 p-3">
                <h1 class="display-4 text-uppercase text-center text-primary">
                    Command Roster
                </h1>
                <div class="border-top border-primary pt-3">
                    <div class="row">
                        <div class="col col-12 col-md-5">
                            <table class="table">
                                <tr v-for="stat in stats.narrative">
                                    <td class="primary-box">{{ stat }}</td>
                                    <td class="grey-box">FOO</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col col-12 col-md-3">
                            <table class="table table-borderless">
                                <tr v-for="stat in stats.resources">
                                    <td class="primary-box">{{ stat }}</td>
                                    <td class="grey-box">FOO</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col col-12 col-md-4">
                            <table class="table">
                                <tr v-for="stat, key in stats.team">
                                    <td class="primary-box">{{ stat }}</td>
                                    <td class="grey-box">
                                        <span v-if="'force' == key">
                                            {{ totalPointsCost }} points
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col col-12">
                            <table class="table">
                                <thead>
                                    <tr >
                                        <td class="primary-box"
                                            v-for="stat in stats.fighter">
                                            {{ stat }}
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <fighter-row
                                        v-for="fighter in fighters"
                                        :key="fighter.id"
                                        :fighter="fighter"
                                        :stats="stats.fighter">
                                    </fighter-row>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FighterRow from './CommandRoster/FighterRow.vue'
import hasFactionStore from '../../mixins/hasFactionStore.js'
export default {
    components: { FighterRow },
    mixins: [ hasFactionStore ],
    computed: {
        fighters() {
            return this.$store.getters.getFighters
        },
        totalPointsCost() {
            return _.reduce(this.fighters, function(xs, x) {
                return xs + x.points;
            }, 0)
        }
    },
    data() {
        return {
            stats: {
                narrative: [
                    'Player name', 'Faction', 'Mission', 'Background', 'Squad Quirk'
                ],
                resources: [
                    'Intelligence', 'Materiel', 'Morale', 'Territory'
                ],
                team: {
                    force: 'Current Kill Team\'s Force',
                    name: 'Current Kill Team\'s Name'
                },
                fighter: {
                    name: 'Name',
                    mini: 'Model Type',
                    wargear: 'Wargear',
                    exp: 'Exp',
                    notes: 'Specialism/Abilities',
                    demeanour: 'Demeanour',
                    pts: 'Pts'
                }
            }
        }
    }
}
</script>
