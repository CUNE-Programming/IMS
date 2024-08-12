/**------------------------------------------------------------
 * calendar-controller.js
 * Ian Kollipara
 *
 * FullCalendar Stimulus Controller
 *------------------------------------------------------------**/

import { Calendar } from "@fullcalendar/core";
import { Controller } from "@hotwired/stimulus";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import { useIdle } from "stimulus-use";

export default class CalendarController extends Controller {
  static values = {
    feedUrl: String,
    rightHeader: {
      type: String,
      default: "dayGridMonth,timeGridWeek,listWeek",
    },
    centerHeader: { type: String, default: "title" },
    leftHeader: { type: String, default: "prev,next today" },
    height: { type: String, default: "auto" },
    aspectRatio: { type: Number, default: 1.35 },
  };

  static targets = ["calendar"];

  connect() {
    useIdle(this, { ms: 1500 });
  }

  calendarTargetConnected(el) {
    this.calendar = new Calendar(el, {
      plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
      height: this.heightValue,
      aspectRatio: this.aspectRatioValue,
      events: {
        url: this.feedUrl,
        format: "ics",
      },
      initialView: "dayGridMonth",
      headerToolbar: {
        left: this.leftHeaderValue,
        center: this.centerHeaderValue,
        right: this.rightHeaderValue,
      },
    });

    this.calendar.render();
  }

  away(_) {
    this.calendar.refetchEvents();
  }
}
