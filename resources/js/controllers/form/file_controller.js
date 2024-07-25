/**------------------------------------------------------------
 * file_controller.js
 * Ian Kollipara
 *
 * Description: Controller for the file form inputs.
 *------------------------------------------------------------**/

import "filepond/dist/filepond.min.css";
import { Controller } from "@hotwired/stimulus";
import { create, registerPlugin } from "filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";

export default class FileController extends Controller {
  static targets = ["input"];
  static values = { file: String };

  initialize() {
    registerPlugin(FilePondPluginFileValidateType);
    registerPlugin(FilePondPluginImagePreview);
  }

  connect() {
    console.log(this.fileValue);
    this.filepond = create(this.inputTarget, {
      storeAsFile: true,
      files: this.fileValue,
    });
  }

  disconnect() {
    this.filepond.destroy();
  }
}
