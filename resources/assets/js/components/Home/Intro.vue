<template>
    <div class="vue-home-intro">
        <div class="container">
            <div class="card">

                <span class="card-header h3">Kill Team Builder</span>

                <div class="card-body">
                    <div class="row">
                        <div class="col col-12 col-sm-6">
                            <router-link class="btn btn-primary"
                                dusk="new-kill-team"
                                :to="{ name: 'gamemode' }">
                                Start a new Kill Team
                            </router-link>
                        </div>
                        <div class="col col-12 col-sm-6">
                            <loader></loader>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import Loader from '../Partial/Loader.vue'
export default {
    components: {
        Loader,
    }
}
</script>
