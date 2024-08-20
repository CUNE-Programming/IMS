import "./bootstrap";
import htmx from "htmx.org";
import Alpine from "alpinejs";
import resize from "@alpinejs/resize";
import Trix from "trix";
import select from "./select";
import calendar from "./calendar";

import "trix/dist/trix.css";
import file from "./file";

import.meta.glob(["../fonts/**", "../images/**"]);

window.htmx = htmx;
window.Alpine = Alpine;
Alpine.plugin(resize);
Alpine.data("select", select);
Alpine.data("calendar", calendar);
Alpine.data("filepond", file);

Alpine.start();
