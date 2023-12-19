import { createApp } from "vue";
import App from "./components/App.vue";
import VueInstantSearch from "vue-instantsearch/vue3/es";
import algoliasearch from "algoliasearch/lite";

const app = createApp(App);
app.use(VueInstantSearch);
app.mount("#app");