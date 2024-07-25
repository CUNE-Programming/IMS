import "./bootstrap";
import { createIcons, icons } from "lucide";
import * as htmx from "htmx.org";
import { Application } from "@hotwired/stimulus";
import FileController from "./controllers/form/file_controller";
import ModalsController from "./controllers/modals-controller";

import.meta.glob(["../fonts/**", "../images/**"]);

createIcons({ icons });

window.htmx = htmx;
window.Stimulus = Application.start();

Stimulus.register("form--file", FileController);
Stimulus.register("modals", ModalsController);

Stimulus.debug = true;
