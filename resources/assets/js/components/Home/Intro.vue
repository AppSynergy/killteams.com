<template>
    <div class="vue-home-intro">
        <div class="container">
            <div class="card">

                <span class="card-header h3">Kill Team Builder</span>

                <div class="card-body">
                    <router-link class="btn btn-primary"
                        :to="{ name: 'gamemode' }">
                        Start a new Kill Team
                    </router-link>
                </div>

                <div class="card-footer">

                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>
