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

            <span class="ml-2"
                v-if="availableAbilities.length > 0">
                <span class="mr-2">
                    Level {{ level }}:
                </span>
                <select class="custom-select custom-select-sm">
                    <option v-for="ability in availableAbilities"
                        v-if="level >= ability.level"
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
        'level', 'specialisms', 'specialists'
    ],
    data() {
        return {
            noneValue: 'None',
            selectedSpecialistName: 'None'
        }
    },
    mounted() {
        this.selectedSpecialistName = this.noneValue
    },
    computed: {
        specialistOptions() {
            let list = _.clone(this.specialists)
            list.splice(0, 0, this.noneValue)
            return list
        },
        availableAbilities() {
            if (!this.selectedSpecialistName || this.selectedSpecialistName == this.noneValue) {
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
