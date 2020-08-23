<template>
  <div class="w-100 content">
    <form @submit.prevent="save">
      <div class="columns" v-for="student in students" :key="student.id">
        <div v-if="evaluable.type == 1" class="column is-narrow">
          <button class="button is-info" @click.prevent="loadRubric(student)">Rubric</button>
        </div>
        <div class="column is-narrow">
          <div class="field">
            <div class="control">
              <input
                v-model="student.grade"
                class="input"
                step="0.1"
                type="number"
                placeholder="Grade"
              />
            </div>
          </div>
        </div>
        <div class="column">
          <textarea v-model="student.feedback" class="input" placeholder="Feedback"></textarea>
        </div>
        <div class="column is-flex align-items-center">{{ student.name }}</div>
        <hr style="background-color: black" />
      </div>
      <button class="button is-primary">
        <i class="fas fa-save has-margin-right-3"></i>
        {{ trans.get('general.save') }}
      </button>
    </form>

    <b-modal
      :active.sync="showRubric"
      has-modal-card
      trap-focus
      :destroy-on-hide="false"
      aria-role="dialog"
      aria-modal
      full-screen
      v-if="studentActive!=null"
    >
      <div class="modal-card" style="width: auto">
        <header class="modal-card-head">
          <p class="modal-card-title">{{ studentActive.name }}</p>
        </header>
        <section class="modal-card-body">
          <div
            class="div_rounded rubricRow marginRadius"
            v-for="rubricRow in rubric.rows"
            :key="rubricRow.id"
          >
            <h2 class="description">{{ rubricRow.description }}</h2>
            <div class="rubricSubitems">
              <div
                class="rubricSubitem marginRadius"
                v-for="item in rubricRow.items"
                :key="item.id"
                :row="'row' + rubricRow.id"
                :item="'item' + item.id"
                @click="selectItem($event.target, rubricRow.id, item)"
              >
                <div class="rubricDetails">{{ item.description }}</div>
                <div class="rubricScore">{{ item.points }}</div>
              </div>
            </div>
          </div>
        </section>
        <footer class="modal-card-foot">
          <button class="button" type="button" @click="studentActive=null;showRubric=false">Close</button>
          <input
            type="number"
            v-model="grade"
            class="input has-margin-right-3"
            style="width: 100px;"
          />
          <button class="button is-primary">Grade</button>
        </footer>
      </div>
    </b-modal>
  </div>
</template>
<script>
export default {
  props: ["classroom", "evaluable", "students", "rubric"],
  created: function () {},
  data: function () {
    return {
      showRubric: false,
      studentActive: null,
      grade: null,
    };
  },
  methods: {
    selectItem: function (target, row, item) {
      let element = document.querySelector("[item=item" + item.id + "]");
      document
        .querySelectorAll("[row=row" + row + "]")
        .forEach(function (rowItem) {
          rowItem.classList.remove("selectedSubItem");
        });

      element.classList.add("selectedSubItem");
      this.recalculate();
    },
    recalculate: function () {
      let total = 0;
      let totalSelected = 0;
      let totalOptional = 0;

      document
        .querySelectorAll(
          ".rubricSubitems:not([data-info=data-optional]) .rubricSubitem.selectedSubItem"
        )
        .forEach(function (rowItem) {
          totalSelected += parseFloat(
            rowItem.querySelector(".rubricScore").innerHTML
          );
        });

      document
        .querySelectorAll(".rubricSubitems:not([data-info=data-optional])")
        .forEach(function (row) {
          var max = 0;
          row.querySelectorAll(".rubricSubitem").forEach((item) => {
            let score = parseFloat(
              item.querySelector(".rubricScore").innerHTML
            );
            if (score > max) max = score;
          });
          total += max
        });

        // TODO optional rows
        // $('.rubricSubitems[data-info=data-optional]').find('.rubricSubitem.selectedSubItem').each(function(index){
        //     totalOptional += parseFloat($(this).find('.rubricScore').html());
        // });

        this.grade = Math.min(10, Math.round((totalSelected/total*10 + totalOptional) * 100) / 100)

    },
    loadRubric: function (student) {
      this.grade = null;
      this.showRubric = true;
      this.studentActive = student;
      // axios.post('/classroom/student/rubric', {student: student.id, rubric: this.rubric.id})
      //   .then(response => {
      //     console.log(response)
      //   })
    },
    save: function () {
      axios
        .post("/classroom/evaluation/" + this.evaluable.id + "/evaluate", {
          grades: this.students,
        })
        .then((response) => {
          console.log(response);
        });
    },
  },
  components: {},
};
</script>
<style>
.rubricRow {
  overflow-x: auto;
}
.rubricSubitems {
  display: flex;
}
.marginRadius {
  border: 1px solid #575757;
  margin: 5px;
  padding: 30px;
  border-radius: 10px;
}
.rubricSubitem {
  flex-grow: 1;
  position: relative;
}
.rubricDetails {
  font-size: 1.5em;
  padding-right: 35px;
}
.rubricSubitem:hover {
  background-color: #dcedc8;
  cursor: pointer;
}
.selectedSubItem {
  background-color: #dcedc8;
}
.rubricScore {
  position: absolute;
  top: 0;
  right: 0;
  background-color: #ffe0b2;
  border-top-right-radius: 8px;
  border-bottom-right-radius: 8px;
  border-left: 1px solid #575757;
  height: 100%;
  text-align: center;
  box-sizing: border-box;
  padding: 20px;
  font-size: 1.25em;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
}
.rubricInfo {
  padding: 30px;
  background-color: rgba(250, 250, 250, 1);
  margin: -10px -10px 10px -10px;
  position: sticky;
  top: 0;
  z-index: 9;
  border-bottom: 1px solid #575757;
}
.rubricInfo h2 {
  padding-right: 90px;
}
.optional {
  background-color: #cfd8dc;
}
</style>