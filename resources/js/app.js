import "./bootstrap";
// import "../css/app.css";//comentado para que no cargue los estilos por defecto y solo vuetify

// css
import "./assets/css/all.min.css";
import "./assets/css/adminlte.min.css";
import "./assets/css/config.css";
import "./assets/css/datatables.css";
import "./assets/css/form.css";
import "./assets/css/icheck-bootstrap.min.css";
import "./assets/css/miTable.css"; // mi-table

// mis scripts
import "./assets/js/jquery.min.js";
import "./assets/js/bootstrap.bundle.js";
// import "./assets/js/adminlte.min.js";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

// sweetalert2
import Swal from "sweetalert2";
window.Swal = Swal;

// Pinia
import { createPinia } from "pinia";
const pinia = createPinia();

// Element-UI plus
import ElementPlus from "element-plus";
import "element-plus/dist/index.css";

// Default Layout
import App from "@/Layouts/App.vue";

// App
const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        );
        page.then((module) => {
            module.default.layout = module.default.layout ?? App;
        });
        return page;
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(pinia)
            .use(ElementPlus)
            .mount(el);
    },
    progress: {
        color: "#ffffff",
    },
});
