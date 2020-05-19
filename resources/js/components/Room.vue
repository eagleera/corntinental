<template>
  <div class="pt-8">
    <div class="card rounded-sm p-4 text-primary mx-4" v-if="room != null">
      <div class="row">
        <div class="col-12 col-md-8">
          <p class="text-2xl font-bold">Sala #{{room.id}}, eres {{ me.alias }}</p>
        </div>
        <div class="col-12 col-md-4">
          <p class="text-xl">Contraseña:</p>
          <div class="flex justify-between text-2xl">
            <div
              v-for="(letra, index) in pwdArray"
              :key="index"
              class="bg-light px-2 py-2 rounded-md font-bold text-danger"
            >{{letra}}</div>
          </div>
          {{ actual_round}}
        </div>
      </div>
      <div class="row mt-4">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead class="thead-dark">
              <tr>
                <th>Rondas / Jugadores</th>
                <th v-for="guest in room.guests" :key="guest.id">{{ guest.alias}}</th>
              </tr>
            </thead>
            <tbody>
              <tr :class="{'text-danger': actual_round == 1 }" v-for="n in 7" :key="n">
                <td>#6</td>
                <td v-for="(round, index) in round(n)" :key="index">{{ round.points }}</td>
              </tr>
              <!-- <tr>
                <td>#7</td>
                <td v-for="(round, index) in round(2)" :key="index">{{ round.points }}</td>
              </tr>
              <tr>
                <td>#8</td>
                <td v-for="(round, index) in round(3)" :key="index">{{ round.points }}</td>
              </tr>
              <tr>
                <td>#9</td>
                <td v-for="(round, index) in round(4)" :key="index">{{ round.points }}</td>
              </tr>
              <tr>
                <td>#10</td>
                <td v-for="(round, index) in round(5)" :key="index">{{ round.points }}</td>
              </tr>
              <tr>
                <td>#11</td>
                <td v-for="(round, index) in round(6)" :key="index">{{ round.points }}</td>
              </tr>
              <tr>
                <td>#12</td>
                <td v-for="(round, index) in round(7)" :key="index">{{ round.points }}</td>
              </tr> -->
            </tbody>
            <tfoot>
              <tr>
                <td>Totales:</td>
                <th v-for="guest in room.guests" :key="guest.id">{{ total(guest.id) }}</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <div v-if="is_owner">
        <b-button variant="success" v-b-modal.results-modal>Anotar resultados de ronda</b-button>
      </div>
      <b-modal id="results-modal" ref="modal" title="Resultados de la ronda" @ok="nextRound">
        <form ref="nextroundform" @submit.stop.prevent="nextRound">
          <b-form-group
            v-for="guest in room.guests"
            :key="guest.id"
            :label="guest.alias"
            label-for="name-input"
            invalid-feedback="El nombre es obligatorio"
          >
            <b-form-input id="name-input" v-model="guest.points" required></b-form-input>
          </b-form-group>
        </form>
      </b-modal>
    </div>
  </div>
</template>
<script>
export default {
  name: "room",
  data() {
    return {
      prueba: 10,
      room: null,
      is_owner: false,
      me: null,
      actual_round: 1,
      rounds: null
    };
  },
  computed: {
    pwdArray() {
      return Array.from(this.room.password.toString());
    }
  },
  methods: {
    nextRound() {
      let round = {
        actual: this.actual_round,
        points: [],
        room: this.room.id
      };
      this.room.guests.forEach(guest => {
        round.points.push({
          guest_id: guest.id,
          points: guest.points
        });
        delete guest.points;
      });
      Room.nextRound(round).then(data => {
        this.room = data;
      });
    },
    round(id) {
      const grouped = this.groupBy(this.room.points, point => point.round_id);
      this.actual_round = grouped.size + 1;
      let round = grouped.get(id);
      if (!round) {
        round = [];
        this.room.guests.forEach(guest => {
          round.push({
            points: 0
          });
        });
      }
      return round;
    },
    groupBy(list, keyGetter) {
      const map = new Map();
      list.forEach(item => {
        const key = keyGetter(item);
        const collection = map.get(key);
        if (!collection) {
          map.set(key, [item]);
        } else {
          collection.push(item);
        }
      });
      return map;
    },
    total(guest_id) {
      return this.room.points
        .filter(point => point.guest_id == guest_id)
        .reduce((prev, next) => prev + next.points, 0);
    }
  },
  mounted() {
    Room.getData(this.$route.params.id).then(data => {
      this.room = data;
      if (this.room.owner.guest_id == localStorage.getItem("guest_id")) {
        this.is_owner = true;
      }
      this.me = data.guests.filter(
        guest => guest.guest_id == localStorage.getItem("guest_id")
      )[0];
    });
    Room.getRounds(data => this.rounds = data);
    Echo.channel("joinChannel").listen("JoinEvent", e => {
      if (this.$route.params.id == e.id) {
        Room.getData(this.$route.params.id).then(data => {
          this.room = data;
          console.log(this.room);
        });
      }
    });
  }
};
</script>