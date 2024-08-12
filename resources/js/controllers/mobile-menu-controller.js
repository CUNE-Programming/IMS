/**------------------------------------------------------------
 * mobile-menu-controller.js
 * Ian Kollipara
 *
 * Description: This file contains the controller for the mobile
 * menu. It is responsible for toggling the menu on and off.
 *------------------------------------------------------------**/

import { Controller } from "@hotwired/stimulus";

export default class MobileMenuController extends Controller {
  static targets = ["menu", "showIcon", "hideIcon"];

  toggleMenu() {
    this.menuTarget.classList.toggle("hidden");
    this.showIconTarget.classList.toggle("hidden");
    this.hideIconTarget.classList.toggle("hidden");
  }
}
