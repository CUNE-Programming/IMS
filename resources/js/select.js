/**------------------------------------------------------------
 * select.js
 * Ian Kollipara
 *
 * Description: This file contains the JavaScript code for the
 * select component.
 *------------------------------------------------------------**/

import "slim-select/styles";

export default config => ({
  init() {
    import("slim-select").then(({ default: SlimSelect }) => {
      console.log(config);
      this.slimSelect = new SlimSelect({
        select: this.$el,
        ...config,
      });
    });
  },

  destroy() {
    this.slimSelect.destroy();
  },
});
