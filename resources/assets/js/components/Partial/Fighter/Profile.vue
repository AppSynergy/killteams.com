<template>
    <span class="vue-partial-fighter-profile d-block table-responsive my-2">
        <table class="mb-0 table table-sm table-bordered">
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
