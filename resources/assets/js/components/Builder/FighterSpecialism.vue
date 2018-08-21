<template>
    <span class="vue-builder-fighter-specialism">

        <span class="alert alert-warning d-block">
            {{ specialists.join(' &middot; ') }}
        </span>

    </span>
</template>

<script>
export default {
    props: [
        'specialisms', 'specialists'
    ]
}
</script>
