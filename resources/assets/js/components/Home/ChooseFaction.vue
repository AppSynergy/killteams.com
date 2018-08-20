<template>
    <div class="vue-home-choose-faction">
        <div class="container">
            <div class="card">

                <span class="card-header h2">Choose a Faction:</span>

                <div class="card-body">
                    <router-link to="/sandbox/DEATH GUARD/builder">
                        e.g. Death Guard
                    </router-link>
                </div>

                <div class="card-footer">
                    <router-link :to="{ name: 'gamemode' }">
                        Back
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'gameMode'
    ]
}
</script>
