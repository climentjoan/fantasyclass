<template>
  <div>
    <div class="m-2">
      <div class="buttons">
        <a
          :href="'/classroom/' + code + '/cards/create'"
          class="button is-success"
        >
          {{ trans.get("cards.create_card") }}
        </a>
        <a
          v-if="cardsJson.length < 10"
          :href="'/classroom/' + code + '/cards/import/default'"
          class="button is-info"
        >
          {{ trans.get("cards.import_default") }}
        </a>
        <button class="button is-dark is-outlined" @click="getOwnCards">
          {{ trans.get("cards.import") }}
        </button>
      </div>
    </div>
    <div class="p-2 is-flex flex-wrap justify-content-center">
      <show-card
        v-for="card in orderedCards"
        :code="code"
        :properties="true"
        :admin="true"
        :assign="student"
        :card="card"
        v-bind:key="card.id"
      ></show-card>
    </div>
    <b-modal
      :active.sync="isModalActive"
      has-modal-card
      full-screen
      :can-cancel="false"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ trans.get("general.import") }}</p>
        </header>
        <section class="modal-card-body is-flex">
          <div v-if="!ownCards.length">
            {{ trans.get("cards.import_empty") }}
          </div>
          <div
            class="p-2 is-flex flex-wrap justify-content-center"
            v-else
          >
            <show-card
              v-for="card in ownCards"
              :code="code"
              :properties="false"
              :admin="true"
              :import="true"
              :card="card"
              v-bind:key="card.id"
            ></show-card>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="refresh">
            {{ trans.get("general.close") }}
          </button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>

<script>
import Utils from "../../utils.js";

export default {
  props: ["cards", "code", "student"],
  mounted() {
    this.cardsJson = JSON.parse(this.cards);
  },
  data: function () {
    return {
      custom: 0,
      sortKey: "type",
      isModalActive: false,
      cardsJson: [],
      ownCards: [],
    };
  },
  methods: {
    refresh() {
      location.reload();
    },
    getOwnCards() {
      axios.get("/user/cards").then((response) => {
        this.ownCards = response.data;
        axios.get("/card/share/get").then((response) => {
          response.data.forEach((card) => {
            this.ownCards.push(card);
          });
          this.isModalActive = true;
        });
      });
    },
  },
  computed: {
    orderedCards: function () {
      return _.orderBy(this.cardsJson, this.sortKey, "asc");
    },
  },
};
</script>