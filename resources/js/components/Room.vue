<template>
  <div>
    <div class="py-8">
      <div class="card rounded-sm p-4 text-primary mx-4" v-if="room != null && me != null">
        <div class="row">
          <div class="col-12 col-md-8">
            <p class="text-2xl font-bold">{{room.name}}, eres {{ me.alias }}</p>
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
          </div>
        </div>
        <div v-if="actual_round == 8  || !room.status">
          <p class="text-2xl text-danger mt-4 md:mt-0">
            La partida ha terminado
            <b-button variant="outline-primary" class="ml-4" @click="getOut">Regresar a inicio</b-button>
          </p>
          <b-row class="items-center mt-6" v-if="winners.length > 0">
            <b-col class="my-2 md:my-0" sm="12" md="4" v-if="winners.length >= 2">
              <div class="rounded-lg bg-silver shadow border-0 flex items-center pl-4 p-3">
                <b-row>
                  <b-col md="2">
                    <p class="text-4xl font-bold text-white mt-2">2</p>
                  </b-col>
                  <b-col class="flex flex-col justify-center">
                    <p class="text-lg text-white">{{ winners[1].alias}}</p>
                    <p class="text-sm text-white font-light">{{ winners[1].won}} juegos ganados</p>
                    <p class="text-sm text-white font-light">{{ winners[1].points }} Puntos</p>
                  </b-col>
                </b-row>
              </div>
            </b-col>
            <b-col class="my-2 md:my-0" sm="12" md="4">
              <div class="rounded-lg bg-gold shadow border-0 flex items-center pl-4 p-4">
                <b-row>
                  <b-col md="2">
                    <p class="text-5xl font-bold text-white mt-2">1</p>
                  </b-col>
                  <b-col class="flex flex-col justify-center">
                    <p class="text-lg text-white">{{ winners[0].alias}}</p>
                    <p class="text-sm text-white font-light">{{ winners[0].won}} juegos ganados</p>
                    <p class="text-sm text-white font-light">{{ winners[0].points }} Puntos</p>
                  </b-col>
                </b-row>
              </div>
            </b-col>
            <b-col class="my-2 md:my-0" sm="12" md="4">
              <div class="rounded-lg bg-bronze shadow border-0 flex items-center pl-4">
                <b-row>
                  <b-col md="2">
                    <p class="text-4xl font-bold text-white mt-2">3</p>
                  </b-col>
                  <b-col class="flex flex-col justify-center">
                    <p class="text-lg text-white">{{ winners.length >= 3 ? winners[2].alias : ""}}</p>
                    <p
                      class="text-sm text-white font-light"
                      v-if="winners.length >= 3"
                    >{{ winners[2].won}} juegos ganados</p>
                    <p class="text-sm text-white font-light" v-else></p>
                    <p
                      class="text-sm text-white font-light"
                      v-if="winners.length >= 3"
                    >{{ winners[2].points }} Puntos</p>
                    <p class="text-sm text-white font-light" v-else></p>
                  </b-col>
                </b-row>
              </div>
            </b-col>
          </b-row>
        </div>
        <div class="row mt-4">
          <p>T = Tercia, E = Escalera</p>
          <div class="table-responsive" v-if="rounds.length > 0">
            <table class="table table-bordered">
              <thead class="thead-dark">
                <tr>
                  <th>Rondas / Jugadores</th>
                  <th v-for="guest in room.guests" :key="guest.id">{{ guest.alias}}</th>
                </tr>
              </thead>
              <tbody>
                <tr :class="{'text-danger': actual_round == n }" v-for="n in 7" :key="n">
                  <td>#{{ rounds.find(x => x.id == n).name }} ({{ rounds.find(x => x.id == n).description }})</td>
                  <td
                    v-for="(round, index) in round(n)"
                    :key="index"
                    :class="{'bg-success': round.points === 0}"
                  >{{ round.points }}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td>Totales:</td>
                  <th v-for="guest in room.guests" :key="guest.id">
                    {{ total(guest.id) }}
                    <span
                      v-if="downPoints(guest.id).charAt(0) == '+'"
                      v-b-tooltip.hover
                      title="Puntos arriba del primer lugar"
                      class="text-danger"
                    >{{ downPoints(guest.id) }}</span>
                    <span
                      v-else
                      class="text-danger"
                      v-b-tooltip.hover
                      title="Jugador con menos puntos"
                    >{{ downPoints(guest.id) }}</span>
                  </th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <div v-if="actual_round == 1 && is_owner" class="mb-3">
          <b-button variant="dark" v-b-modal.add-players-modal>Agregar jugadores manualmente</b-button>
        </div>
        <div v-if="is_owner && actual_round < 8">
          <b-button variant="success" v-b-modal.results-modal>Anotar resultados de ronda</b-button>
          <b-button variant="danger" @click="closeTable">Cerrar mesa y terminar partida</b-button>
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
        <b-modal id="add-players-modal" ref="modal" title="Agregar jugador" @ok="addPlayer">
          <form ref="addplayerform" @submit.stop.prevent="addPlayer">
            <b-form-group
              label="Nombre del jugador"
              label-for="name-input"
              invalid-feedback="El nombre es obligatorio"
            >
              <b-form-input id="name-input" v-model="player_name" required></b-form-input>
            </b-form-group>
          </form>
        </b-modal>
      </div>
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
      rounds: [],
      winners: [],
      player_name: null
    };
  },
  computed: {
    pwdArray() {
      return Array.from(this.room.password.toString());
    },
    winning() {
      let totals = [];
      this.room.guests.forEach(guest => {
        totals.push(this.total(guest.id));
      });
      return Math.min(...totals);
    }
  },
  watch: {
    actual_round: function(val) {
      if (val == 8) {
        Room.getWinners(this.room.id).then(data => {
          var keys = Object.keys(data);
          keys.forEach(key => {
            this.winners.push(data[key]);
          });
          this.winners.sort((a, b) => a.points - b.points);
        });
      }
    }
  },
  methods: {
    closeTable() {
      this.$bvModal
        .msgBoxConfirm(
          "Estas seguro que deseas cerrar la mesa y terminar la partida",
          {
            title: "Porfavor confirma",
            size: "sm",
            buttonSize: "sm",
            okVariant: "danger",
            okTitle: "Si",
            cancelTitle: "No",
            footerClass: "p-2",
            hideHeaderClose: false,
            centered: true
          }
        )
        .then(value => {
          if (value) {
            Room.close(this.room.id);
          }
        });
    },
    getOut() {
      localStorage.removeItem("guest_id");
      localStorage.removeItem("game_id");
      document.cookie =
        "guest_id=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
      window.location = "/";
    },
    addPlayer() {
      let data = {
        alias: this.player_name,
        password: this.room.password,
        room_id: this.room.id,
        user_id: null
      };
      Room.joinLocal(data);
      this.player_name = null;
    },
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
            points: id == this.actual_round ? "0" : ""
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
    },
    downPoints(guest_id) {
      if (this.total(guest_id) === this.winning) {
        return "👑";
      }
      return "+" + (this.total(guest_id) - this.winning);
    }
  },
  mounted() {
    Room.getData(this.$route.params.id).then(data => {
      this.room = data;
      if (data.owner.guest_id == localStorage.getItem("guest_id")) {
        this.is_owner = true;
      }
      if (!data.status) {
        this.me = data.guests.filter(
          guest => guest.id == this.$route.query.user
        )[0];
      } else {
        this.me = data.guests.filter(
          guest => guest.guest_id == localStorage.getItem("guest_id")
        )[0];
        console.log(this.me);
      }
    });
    Room.getRounds().then(data => {
      this.rounds = data;
    });
    Echo.channel("joinChannel").listen("JoinEvent", e => {
      if (this.$route.params.id == e.id) {
        this.$bvToast.toast(e.guest.alias + " ha entrado a la mesa", {
          title: `Ha entrado un nuevo jugador!`,
          variant: "info",
          solid: true
        });
        Room.getData(this.$route.params.id).then(data => {
          this.room = data;
          console.log(this.room);
        });
      }
    });
    Echo.channel("pointsChannel").listen("PointsEvent", e => {
      console.log(e);
      if (this.$route.params.id == e.id) {
        Room.getData(this.$route.params.id).then(data => {
          this.room = data;
        });
      }
    });
    Echo.channel("closeChannel").listen("CloseEvent", e => {
      if (this.$route.params.id == e.id) {
        this.$bvToast.toast("La sala ha sido cerrada por el creador", {
          title: `¡Se ha cerrado la Sala!`,
          variant: "danger",
          solid: true
        });
        setTimeout(() => {
          localStorage.removeItem("guest_id");
          localStorage.removeItem("game_id");
          document.cookie =
            "guest_id=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;";
          window.location = "/";
        }, 1000);
      }
    });
  }
};
</script>