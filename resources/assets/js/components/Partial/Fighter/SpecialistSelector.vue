<template>
    <div class="vue-partial-fighter-specialist-selector">
        <div class="form-inline">

            <span class="mr-2 font-weight-bold">
                Specialism:
            </span>

            <select class="custom-select custom-select-sm"
                v-model="specialistSelector.specialism_id"
                v-on:change="updateSpecialism">
                <option v-for="specialist in availableSpecialisms"
                    :value="specialist.id">
                    {{ specialist.name }}
                </option>
            </select>

            <span v-if="'sandbox' == gameMode">
                <span class="mx-2 font-weight-bold">
                    Level:
                </span>

                <select class="custom-select custom-select-sm"
                    v-model="specialistSelector.level"
                    v-on:change="updateSpecialism">
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
                <select class="custom-select custom-select-sm"
                    v-model="specialistSelector.abilities[level-1]">
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
import SpecialismsResource from '../../../mixins/SpecialismsResource.js'
export default {
    mixins: [
        SpecialismsResource,
    ],
    props: [
        'availableSpecialistNames', 'fighterId', 'gameMode', 'specialistSelector',
    ],
    computed: {
        availableSpecialisms() {
            return _.filter(this.specialisms, (specialism) => {
                return _.includes(this.availableSpecialistNames, specialism.name)
            })
        },
        currentSpecialism() {
            return _.find(this.availableSpecialisms, (specialism) => {
                return specialism.id == this.specialistSelector.specialism_id
            })
        },
        levels() {
            return _.range(1, this.specialistSelector.level + 1)
        },
        availableAbilities() {
            if (!_.isEmpty(this.currentSpecialism)) {
                return this.currentSpecialism.abilities
            }
            return []
        }
    },
    methods: {
        updateSpecialism() {
            this.$store.commit('updateSpecialistSelector', {
                fighterId: this.fighterId,
                selector: this.specialistSelector,
            })
        }
    }
}
</script>
