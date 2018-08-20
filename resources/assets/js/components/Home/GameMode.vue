<template>
    <div class="vue-home-game-mode">
        <div class="container">
            <div class="card">

                <span class="card-header h3">Kill Team Builder &middot; Choose a Game Mode</span>

                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <router-link class="btn btn-primary mr-3"
                                to="/sandbox/choosefaction">
                                Sandbox Mode
                            </router-link>
                            Freely build any Kill Team you like, suitable for Open or Narrative play.
                        </li>

                        <li class="list-group-item">
                            <router-link class="btn btn-primary mr-3"
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
