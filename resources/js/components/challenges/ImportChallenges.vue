<template>
  <div class="modal-card" style="width: auto">
    <header class="modal-card-head">
      <p class="modal-card-title">{{ trans.get('menu.challenges') }}</p>
    </header>
    <section class="modal-card-body content" style="align-items: flex-start;">
      <div v-for="(classroom, index) in fullChallenges" :key="index">
        <details v-if="classroom.challenge_groups.length">
        <summary class="my-3 cursor-pointer"><h1 style="display: inline-block;">{{ classroom.name }}</h1></summary>
        <hr>
        <div v-for="group in classroom.challenge_groups" :key="group.id">
          <h2 class="pl-3" v-if="group.challenges.length">{{ group.name }}</h2>
          <h2 v-else>{{ trans.get('success_error.challenges_empty') }}</h2>
          <div class="box my-4" v-for="challenge in group.challenges" :key="challenge.id">
            <article class="media">
              <div class="media-content">
                <div class="content">
                  <p class="m-3">
                    <strong>{{ challenge.title }}</strong> <small>{{ challenge.description }}</small>
                    <br>
                    <div v-html="challenge.content" style="max-height: 100px; overflow: auto"></div>
                  </p>
                </div>
              </div>
            </article>
            <button @click="importChallenge(challenge)" class="button is-primary my-4">{{ trans.get('general.import') }}</button>
          </div>
        </div>
        </details>
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button" type="button" @click="$parent.$parent.isImportModalActive=false">{{ trans.get('general.close') }}</button>
    </footer>
  </div>
</template>
<script>
export default {
  props: ["classroom", "challengegroup"],
  created() {
    axios.get('/user/challenges')
      .then(response => {
        this.fullChallenges = response.data
      });
  },
  data: function() {
    return {
      behaviour: null,
      fullChallenges: null,
    };
  },
  methods: {
    importChallenge: function(challenge) {
       axios.post('/user/challenges/import/' + challenge.id, { 'group' : this.challengegroup })
        .then(response => {
          this.$parent.$parent.isImportModalActive=false
          this.$parent.$parent.$parent.getChallenges(this.challengegroup);
        });
      // this.$parent.$parent.challengeEdit = challenge;
      // this.$parent.$parent.challengeEdit.id = null
      // this.$parent.$parent.challengeEdit.challengeGroup = null
      // this.$parent.$parent.addChallenge = true
      // this.$parent.$parent.importFlag = true
      // // this.$parent.$parent.reload = true
      // this.$parent.$parent.isImportModalActive = false;

    }
  },
  computed: {}
};
</script>