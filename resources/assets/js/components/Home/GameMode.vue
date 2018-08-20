<template>
    <div class="vue-home-game-mode">
        <div class="container">
            <div class="card">

                <span class="card-header h3">Choose a Game Mode:</span>

                <div class="card-body">
                    <router-link class="btn btn-primary"
                        to="/sandbox/choosefaction">
                        Sandbox Mode / Open/Narrative Play
                    </router-link>


                    <router-link class="btn btn-primary"
                        to="/tournament/choosefaction">
                        Tournament Mode / Matched Play
                    </router-link>

                    <router-link class="btn btn-primary"
                        to="/campaign/choosefaction">
                        Campaign Mode / Narrative Play
                    </router-link>
                </div>

                <div class="card-footer">
                    <router-link :to="{ name: 'intro' }">
                        Back
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>
