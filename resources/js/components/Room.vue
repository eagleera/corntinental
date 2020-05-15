<template>
  <div class="card rounded-sm p-4 text-primary">
    <div class="row">
      <div class="col-8">
        <p class="text-2xl font-bold">Sala #{{room.id}}, eres {{ me.alias }}</p>
      </div>
      <div class="col-4">
        <p class="text-xl">Contraseña:</p>
        <div class="flex justify-between text-2xl">
          <div
            v-for="(letra, index) in pwdArray"
            :key="index"
            class="bg-light px-4 py-3 rounded-md font-bold text-danger"
          >{{letra}}</div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <table class="table table-bordered">
        <thead class="thead-dark">
          <tr>
            <th>Rondas / Jugadores</th>
            <th v-for="guest in room.guests" :key="guest.id">{{ guest.alias}}</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
        <tfoot>
            <tr>
                <td>Totales:</td>
                <th v-for="guest in room.guests" :key="guest.id">0</th>
            </tr>
        </tfoot>
      </table>
    </div>
    <div v-if="is_owner">
      <b-button @click="nextRound" variant="success">Comenzar partida</b-button>
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
      me: null
    };
  },
  computed: {
    pwdArray() {
      return Array.from(this.room.password.toString());
    }
  },
  methods:{
      nextRound(){
          Room.nextRound(this.room.id);
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
    Echo.channel("joinChannel").listen("JoinEvent", e => {
      console.log(e, this.$route.params.id);
      if (this.$route.params.id == e.id) {
        this.prueba += 10;
      }
    });
  }
};
</script>