<template>
    <div class="vue-builder-command-roster">
        <div class="container border border-primary mb-5">
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
                            <tr v-for="stat in stats.team">
                                <td class="primary-box">{{ stat }}</td>
                                <td class="grey-box">FOO</td>
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
                                <tr v-for="fighter in [1,2,3,4,5,6]">
                                    <td class="grey-box"
                                        v-for="stat in stats.fighter">
                                        FOO
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            stats: {
                narrative: [
                    'Player name', 'Faction', 'Mission', 'Background', 'Squad Quirk'
                ],
                resources: [
                    'Intelligence', 'Materiel', 'Morale', 'Territory'
                ],
                team: [
                    'Current Kill Team\'s Force', 'Current Kill Team\'s Name'
                ],
                fighter: [
                    'Name', 'Model Type', 'Wargear', 'Exp', 'Specialism/Abilities', 'Demeanour', 'Pts'
                ]
            }
        }
    }
}
</script>
