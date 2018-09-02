<template>
    <div class="vue-builder-fighter-specialism">
        <div class="form-inline">

            <span class="mr-2 font-weight-bold">
                Specialism:
            </span>

            <select class="custom-select custom-select-sm"
                v-model="selectedSpecialistName">
                <option v-for="specialist in specialistOptions"
                    :value="specialist">
                    {{ specialist }}
                </option>
            </select>

            <span v-if="'sandbox' == gameMode">
                <span class="mx-2 font-weight-bold">
                    Level:
                </span>

                <select class="custom-select custom-select-sm"
                    v-model="selectedLevel">
                    <option v-for="level in [1,2,3,4]"
                        :value="level">
                        {{ level }}
                    </option>
                </select>
            </span>

            <span class="ml-2"
                v-for="level in levels"
                v-if="availableAbilities.length > 0">
                <span class="mr-2">
                    Level {{ level }}:
                </span>
                <select class="custom-select custom-select-sm">
                    <option v-for="ability in availableAbilities"
                        v-if="level == ability.level && level <= 3"
                        :value="ability.id">
                        {{ ability.name }}
                    </option>
                    <option v-for="ability in availableAbilities"
                        v-if="level == 4"
                        :value="ability.id">
                        {{ ability.name }}
                    </option>
                </select>
            </span>

        </div>
    </div>
</template>

<script>
export default {
    props: [
        'gameMode', 'specialisms', 'specialists'
    ],
    data() {
        return {
            selectedSpecialistName: 'None',
            selectedLevel: 1
        }
    },
    mounted() {

    },
    computed: {
        level() {
            if ('sandbox' == this.gameMode) {
                return this.selectedLevel
            } else {
                return 1
            }
        },
        levels() {
            return _.range(1, this.level + 1)
        },
        specialistOptions() {
            let list = _.clone(this.specialists)
            list.splice(0, 0, 'None')
            return list
        },
        availableAbilities() {
            if (!this.selectedSpecialistName || this.selectedSpecialistName == 'None') {
                return []
            }
            const specialism = _.filter(this.specialisms, (specialism) => {
                return specialism.name == this.selectedSpecialistName
            })
            if (specialism) {
                return _.first(specialism).abilities
            }
            return []
        }
    }
}
</script>
