/**------------------------------------------------------------
 * calendar.js
 * Ian Kollipara
 *
 * FullCalendar Alpine Component
 *------------------------------------------------------------**/

import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import iCalPlugin from "@fullcalendar/icalendar";
import listPlugin from "@fullcalendar/list";

export default config => ({
  init() {
    (this.calendar = new Calendar(this.$el, {
      plugins: [dayGridPlugin, timeGridPlugin, listPlugin, iCalPlugin],
      ...config,
    })),
      this.calendar.render();
  },

  destroy() {
    this.calendar.destroy();
  },
});
