<template>
    <span class="vue-builder-fighter-profile">
        <table class="mb-0 table table-sm table-bordered table-responsive">
            <thead class="thead-dark"><tr>
                <th class="text-center"
                    v-for="_, key in profile">{{ key }}</th>
            </tr></thead>
            <tbody><tr>
                <td class="text-center"
                    v-for="val, key, index in profile">
                    <span v-if="'Max' == key && 0 == val">
                        -
                    </span>
                    <span v-else>
                        {{ val }}{{ suffixes[index] }}
                    </span>
                </td>
            </tr></tbody>
        </table>
    </span>
</template>

<style lang="sass">
    table
        font-size: 70%
</style>

<script>
export default {
    props: [
        'profile', 'suffixes'
    ]
}
</script>
