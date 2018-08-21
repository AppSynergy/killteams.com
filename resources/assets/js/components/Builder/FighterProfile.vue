<template>
    <span class="vue-builder-fighter-profile">
        <table class="mb-0 table table-sm table-bordered table-responsive">
            <thead class="thead-dark"><tr>
                <th class="text-center"
                    v-for="_, key in profile"
                    v-if="'Max' != key">
                    {{ key }}
                </th>
            </tr></thead>
            <tbody><tr>
                <td class="text-center"
                    v-for="val, key, index in profile"
                    v-if="'Max' != key">
                    {{ val }}{{ suffixes[index] }}
                </td>
            </tr></tbody>
        </table>
    </span>
</template>

<script>
export default {
    props: [
        'profile', 'suffixes'
    ]
}
</script>
