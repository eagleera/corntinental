<template>
  <div class="min-h-screen flex items-center">
    <b-container class="h-full card rounded-md md:p-6 has-background-light pt-4">
      <b-row>
        <b-col md="6">
          <b-row class="h-full">
            <b-col cols="12" class="flex items-center">
              <b-button
                v-b-modal.create-room-modal
                variant="outline-primary"
                class="btn-block text-3xl font-bold flex items-center justify-center md:h-48"
              >Crear nueva mesa</b-button>
            </b-col>
            <b-col class="flex items-center">
              <b-button
                v-b-modal.join-room-modal
                variant="outline-secondary"
                class="btn-block text-3xl font-bold flex items-center justify-center mt-4 md:h-48"
              >Unirse a una mesa</b-button>
            </b-col>
          </b-row>
        </b-col>
        <div class="col-12 col-md-6 p-8">
          <div class="border-4 border-gray-600 h-full rounded-md px-8 py-4 text-black">
            <div v-if="!login && !signup">
              <div>
                <p class="font-bold text-4xl">Hola!</p>
                <p
                  class="text-2xl text-black"
                >Para empezar a llevar la cuenta de tus juegos y puntuaciones inicia sesión o crea una cuenta!</p>
              </div>
              <div class="columns mt-16 is-multiline">
                <div class="column is-12">
                  <a
                    class="btn btn-primary btn-block text-xl font-bold text-white"
                    @click="() => login = !login"
                  >Iniciar sesión</a>
                </div>
                <div class="column is-12 mt-3">
                  <a
                    class="btn btn-secondary btn-block h-full text-xl font-bold text-white"
                    @click="() => signup = !signup"
                  >Crear una cuenta</a>
                </div>
              </div>
            </div>
            <div v-if="login">
              <p class="text-2xl font-bold">Inicia sesión</p>
              <b-form @submit.stop.prevent="doLogin">
                <b-form-group
                  label="Correo electronico:"
                  label-for="login_email"
                  description="No compartiremos tu correo electronico con nadie más."
                >
                  <b-form-input
                    id="login_email"
                    v-model="loginform.email"
                    type="email"
                    required
                    placeholder="Introduce tu correo..."
                  ></b-form-input>
                </b-form-group>
                <b-form-group label="Contraseña:" label-for="login_pwd">
                  <b-form-input
                    id="login_pwd"
                    v-model="loginform.password"
                    type="password"
                    required
                    placeholder="Introduce tu contraseña..."
                  ></b-form-input>
                </b-form-group>
                <b-button type="submit" variant="primary" block>Iniciar sesión</b-button>
                <p
                  class="text-blue cursor-pointer text-center mt-3"
                  @click="() => {login = false; signup = true;}"
                >¿No tienes una cuenta? Crea una ahora</p>
              </b-form>
            </div>
            <div v-if="signup">
              <p class="text-2xl font-bold">Crea una cuenta</p>
              <b-form @submit.stop.prevent="doSignup">
                <b-form-group
                  label="Correo electronico:"
                  label-for="signup_email"
                  description="No compartiremos tu correo electronico con nadie más."
                >
                  <b-form-input
                    id="signup_email"
                    v-model="signupform.email"
                    type="email"
                    required
                    placeholder="Introduce tu correo..."
                  ></b-form-input>
                </b-form-group>
                <b-form-group label="Nombre:" label-for="signup_name">
                  <b-form-input
                    id="signup_name"
                    v-model="signupform.name"
                    type="text"
                    required
                    placeholder="Introduce tu nombre..."
                  ></b-form-input>
                </b-form-group>
                <b-form-group label="Contraseña:" label-for="signup_pwd">
                  <b-form-input
                    id="signup_pwd"
                    v-model="signupform.password"
                    type="password"
                    required
                    placeholder="Introduce tu contraseña..."
                  ></b-form-input>
                </b-form-group>
                <b-form-group label="Confirmar contraseña:" label-for="signup_pwd_confirm">
                  <b-form-input
                    id="signup_pwd_confirm"
                    v-model="signupform.password_confirmation"
                    type="password"
                    required
                    placeholder="Confirma tu contraseña..."
                  ></b-form-input>
                </b-form-group>
                <b-button type="submit" variant="primary" block>Crear cuenta</b-button>
                <p
                  class="text-blue cursor-pointer text-center mt-3"
                  @click="() => {login = true; signup = false;}"
                >¿Ya tienes una cuenta? Inicia sesión</p>
              </b-form>
            </div>
          </div>
        </div>
      </b-row>
      <join-room />
      <create-room />
    </b-container>
  </div>
</template>

<script>
import JoinRoom from "./modals/JoinRoom";
import CreateRoom from "./modals/CreateRoom";

export default {
  data() {
    return {
      login: false,
      signup: false,
      loginform: {
        email: "",
        password: ""
      },
      signupform: {
        email: "",
        name: "",
        password: "",
        password_confirmation: ""
      }
    };
  },
  components: {
    JoinRoom,
    CreateRoom
  },
  methods: {
    doLogin() {
      User.login(this.loginform).then(res => {
        if(res === true){
          this.$router.push({ name: 'AuthHome'});
        }
        this.$bvToast.toast("El correo o la contraseña son incorrectos", {
          title: `Ups... ha ocurrido un error`,
          variant: "danger",
          solid: true
        });
      });
    },
    doSignup() {
      User.register(this.signupform).then(errors => {
        console.log(errors);
        Object.keys(errors).forEach((element, key) => {
          switch (element) {
            case "email":
              this.$bvToast.toast("Este email ya se encuentra en uso", {
                title: `Ups... ha ocurrido un error`,
                variant: "danger",
                solid: true
              });
              break;
            case "name":
              this.$bvToast.toast("El nombre debe ser minimo 5 letras", {
                title: `Ups... ha ocurrido un error`,
                variant: "danger",
                solid: true
              });
              break;
          }
        });
      });
    }
  }
};
</script>

<style>
</style>