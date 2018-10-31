<template>
    <div class="vue-home-game-mode">
        <div class="container">
            <div class="card">

                <span class="card-header h3 text-center">Select a Game Mode</span>

                <div class="card-body">
                    <breadcrumb
                        activeText="Select game mode"
                        :parents="[{title: 'Home', route: { name: 'intro' }}]"
                    ></breadcrumb>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <router-link class="btn btn-primary mr-3"
                                dusk="sandbox-mode"
                                to="/sandbox/choosefaction">
                                Sandbox Mode
                            </router-link>
                            Freely build any Kill Team you like, suitable for Open or Narrative play.
                        </li>

                        <li class="list-group-item">
                            <router-link class="btn btn-primary mr-3"
                                dusk="tournament-mode"
                                to="/tournament/choosefaction">
                                Tournament Mode
                            </router-link>
                            Build a tournament-legal Kill Team from a single faction. Suitable for any Matched play game.
                        </li>

                        <li class="list-group-item">
                            <router-link class="btn btn-primary mr-3 disabled"
                                to="/campaign/choosefaction">
                                Campaign Mode
                            </router-link>
                            Coming soon!
                        </li>
                    </ul>
                </div>

                <div class="card-footer">
                    <router-link :to="{ name: 'intro' }" dusk="back">
                        Back
                    </router-link>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import Breadcrumb from '../Partial/Breadcrumb.vue'
export default {
    components: {
        Breadcrumb,
    }
}
</script>
