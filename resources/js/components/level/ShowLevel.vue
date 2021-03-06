<template>
  <div
    v-if="level"
    :class="{
      'column is-6-tablet is-12-mobile is-3-desktop mb-0 is-flex has-all-centered': edit,
      column: !edit,
    }"
  >
    <div
      :class="{ 'min-width': !edit }"
      class="columns w-100 is-variable is-0 py-2"
    >
      <div
        class="column is-narrow py-0 card-shadow-s rounded-left has-background-light"
      >
        <figure class="image is-128x128">
          <label class="cursor-pointer" :for="'file' + level.id">
            <croppa
              class="p-2 card-shadow-s is-full-rounded"
              v-model="image"
              :width="128"
              :height="128"
              :quality="1"
              style="z-index: 15"
              accept="image/*"
              placeholder="Image"
              :placeholder-font-size="16"
              canvas-color="transparent"
              :show-remove-button="true"
              remove-button-color="black"
              :show-loading="true"
              :loading-size="50"
              :initial-image="prevImage"
              v-if="edit"
            ></croppa>
            <img
              v-else
              class="p-2 card-shadow-s is-full-rounded"
              :src="prevImage"
            />
          </label>
        </figure>
      </div>
      <div class="column content card p-4 rounded-right card-shadow-s">
        <p class="is-size-4">
          {{ trans.get("levels.level") }} {{ level.number }}
        </p>
        <p class="my-2" v-if="edit">
          <i class="fas fa-fist-raised colored"></i>
          {{ trans.get("levels.xp") }}
        </p>
        <h2 v-if="!edit">{{ level.title }}</h2>
        <p v-if="!edit">{{ level.description }}</p>
        <input
          type="number"
          v-if="edit"
          v-model="level.xp"
          class="input w-100"
        />
        <p class="my-2" v-if="edit">{{ trans.get("levels.title") }}</p>
        <input
          v-model="level.title"
          v-if="edit"
          type="text"
          class="input w-100"
        />
        <p class="my-2" v-if="edit">{{ trans.get("levels.description") }}</p>
        <p v-if="edit">
          <textarea
            class="input"
            rows="20"
            style="height: 100px"
            v-model="level.description"
          ></textarea>
        </p>
        <div v-if="edit" class="has-text-right mt-2">
          <button class="button is-dark" @click="update">
            <i class="fas fa-edit"></i>
          </button>
          <button class="button is-danger" @click="remove" v-if="last">
            <i class="fas fa-trash-alt"></i>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["level", "last", "code", "edit"],
  created() {
    this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    if (this.level) {
      this.prevImage = this.level.imagelvl;
    }
  },
  data: function () {
    return {
      csrfToken: null,
      prevImage: null,
      image: null,
    };
  },
  methods: {
    update: function () {
      this.image.generateBlob(
        (blob) => {
          // form data
          var formData = new FormData();
          if (blob) formData.append("logo", blob, "logo.png");
          formData.append("id", this.level.id);
          formData.append("title", this.level.title ? this.level.title : "");
          formData.append(
            "description",
            this.level.description ? this.level.description : ""
          );
          formData.append("xp", this.level.xp);
          formData.append("_method", "patch");
          axios
            .post("/classroom/levels/" + this.level.id, formData, {
              headers: {
                "content-type": "multipart/form-data",
              },
            })
            .then((response) => {
              this.$toast(response.data.message, { type: response.data.type });
            });
        },
        "image/png",
        0.8
      );
    },
    remove: function () {
      axios.delete("/classroom/level/" + this.level.id).then((response) => {
        this.$parent.levels.pop();
        this.$parent.$forceUpdate();
      });
    },
  },
};
</script>
<style>
.min-width {
  min-width: 400px;
}
</style>