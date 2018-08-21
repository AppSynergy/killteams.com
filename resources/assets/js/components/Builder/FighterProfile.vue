<template>
    <span class="vue-builder-fighter-profile">
        <table class="table table-sm table-bordered">
            <thead class="thead-dark"><tr>
                <th class="text-center"
                    v-for="_, key in profile">{{ key }}</th>
            </tr></thead>
            <tbody><tr>
                <td class="text-center"
                    v-for="val in profile">{{ val }}</td>
            </tr></tbody>
        </table>
    </span>
</template>

<script>
export default {
    props: [
        'profile'
    ]
}
</script>
