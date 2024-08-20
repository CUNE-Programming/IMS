/**------------------------------------------------------------
 * file.js
 * Ian Kollipara
 *
 * Description: Filepond Alpine Component
 *------------------------------------------------------------**/

import "filepond/dist/filepond.min.css";
import { create, registerPlugin } from "filepond";

import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import "filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css";

registerPlugin(FilePondPluginFileValidateType);
registerPlugin(FilePondPluginImagePreview);
export default (value, el, config) => ({
  init() {
    this.filepond = create(document.querySelector(el), {
      storeAsFile: true,
      files: value,
      ...config,
    });
  },

  destroy() {
    if (this.filepond) {
      this.filepond.destroy();
    }
  },
});
